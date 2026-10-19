<?php

namespace App\Http\Middleware;

use App\Models\AdminAuditLog;
use Closure;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecordAdminAudit
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $action = $route?->getName();
        if (!is_string($action) || !str_starts_with($action, 'admin.') ||
            ($request->isMethodSafe() && $action !== 'admin.logout')) {
            return $next($request);
        }

        $actor = auth('admin')->user();
        $exception = null;
        try {
            $response = $next($request);
        } catch (Throwable $error) {
            $exception = $error;
            // Render once so validation and authorization failures retain their actual status.
            app(ExceptionHandler::class)->report($error);
            $response = app(ExceptionHandler::class)->render($request, $error);
        }

        $actor ??= auth('admin')->user(); // Successful login acquires its identity here.
        if ($actor) {
            $targets = [];
            foreach ($route->parameters() as $key => $value) {
                $id = $value instanceof Model ? $value->getKey() : $value;
                if (is_scalar($id) && ctype_digit((string) $id)) {
                    $targets[$key] = (string) $id;
                }
            }
            // Legacy bulk-delete endpoints submit IDs in the body. Never retain other input.
            foreach (['id', 'ids'] as $key) {
                $ids = $request->input($key);
                if ($ids !== null) {
                    $targets[$key] = array_values(array_filter(array_slice((array) $ids, 0, 500),
                        fn ($id) => is_scalar($id) && ctype_digit((string) $id)));
                }
            }
            $status = $response->getStatusCode();
            $newFlash = $request->hasSession() ? $request->session()->get('_flash.new', []) : [];
            $errors = in_array('errors', $newFlash, true) ? $request->session()->get('errors') : null;
            $validationFailed = $errors instanceof MessageBag ? $errors->any() :
                ($errors instanceof \Illuminate\Support\ViewErrorBag && $errors->any());
            $result = ($exception || $status >= 400 || $validationFailed ||
                in_array('error', $newFlash, true)) ? 'rejected' : 'completed';
            try {
                AdminAuditLog::create([
                    'admin_id' => $actor->getAuthIdentifier(),
                    'actor_name' => mb_substr(trim($actor->first_name.' '.$actor->last_name), 0, 255),
                    'action' => $action, 'method' => $request->method(),
                    'target_ids' => $targets, 'response_status' => $status, 'result' => $result,
                    'ip_address' => $request->ip(), 'created_at' => now(),
                ]);
            } catch (Throwable $error) {
                // A logging outage must not turn a completed payment into an apparent failure.
                Log::critical('Admin audit write failed', ['action' => $action, 'admin_id' => $actor->getAuthIdentifier()]);
                report($error);
            }
        }

        return $response;
    }
}
