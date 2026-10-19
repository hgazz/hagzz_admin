<?php

namespace App\Http\Controllers;

use App\Models\AdminAuditLog;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'admin_id' => ['nullable', 'integer', 'min:1'],
            'action' => ['nullable', 'string', 'max:255'],
            'result' => ['nullable', 'in:completed,rejected'],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);
        $query = AdminAuditLog::query();
        foreach (['admin_id', 'action', 'result'] as $key) {
            if (!empty($filters[$key])) $query->where($key, $filters[$key]);
        }
        if (!empty($filters['from'])) $query->where('created_at', '>=', $filters['from'].' 00:00:00');
        if (!empty($filters['to'])) $query->where('created_at', '<', \Carbon\Carbon::parse($filters['to'])->addDay()->startOfDay());
        return view('Admin.pages.audit-logs.index', [
            'logs' => $query->orderByDesc('id')->paginate(25)->withQueryString(),
            'filters' => $filters,
        ]);
    }
}
