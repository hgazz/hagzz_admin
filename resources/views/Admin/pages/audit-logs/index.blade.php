@extends('Admin.Layouts.master')
@section('title', trans('admin.audit.title'))
@section('content')
<div class="middle-content container-xxl p-0">
    <div class="card mt-4">
        <div class="card-header"><h1 class="h4 mb-0">{{ trans('admin.audit.title') }}</h1></div>
        <div class="card-body">
            <p class="text-muted">{{ trans('admin.audit.intro') }}</p>
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
            @endif
            <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="row g-3 mb-4">
                <div class="col-md-2"><label class="form-label" for="audit-actor">{{ trans('admin.audit.actor_id') }}</label><input id="audit-actor" class="form-control" name="admin_id" type="number" min="1" value="{{ $filters['admin_id'] ?? '' }}"></div>
                <div class="col-md-3"><label class="form-label" for="audit-action">{{ trans('admin.audit.action') }}</label><input id="audit-action" class="form-control" name="action" maxlength="255" dir="ltr" value="{{ $filters['action'] ?? '' }}" placeholder="admin.academies.update"></div>
                <div class="col-md-2"><label class="form-label" for="audit-result">{{ trans('admin.audit.result') }}</label><select id="audit-result" class="form-select" name="result"><option value="">{{ trans('admin.audit.all') }}</option>@foreach(['completed', 'rejected'] as $result)<option value="{{ $result }}" @selected(($filters['result'] ?? '') === $result)>{{ trans('admin.audit.'.$result) }}</option>@endforeach</select></div>
                @foreach(['from', 'to'] as $date)
                    <div class="col-md-2"><label class="form-label" for="audit-{{ $date }}">{{ trans('admin.audit.'.$date) }}</label><input id="audit-{{ $date }}" class="form-control" type="date" name="{{ $date }}" value="{{ $filters[$date] ?? '' }}"></div>
                @endforeach
                <div class="col-12 d-flex gap-2"><button class="btn btn-primary" type="submit">{{ trans('admin.audit.filter') }}</button><a class="btn btn-outline-secondary" href="{{ route('admin.audit-logs.index') }}">{{ trans('admin.audit.reset') }}</a></div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr>@foreach(['time','actor','action','targets','result','status','ip'] as $column)<th scope="col">{{ trans('admin.audit.'.$column) }}</th>@endforeach</tr></thead>
                    <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-nowrap"><time datetime="{{ $log->created_at->toIso8601String() }}">{{ $log->created_at->format('Y-m-d H:i:s T') }}</time></td>
                            <td>{{ $log->actor_name }} <span class="text-muted">#{{ $log->admin_id }}</span></td>
                            <td><code dir="ltr">{{ $log->method }} {{ $log->action }}</code></td>
                            <td>@foreach($log->target_ids ?? [] as $key => $ids)<div><span dir="ltr">{{ $key }}: {{ is_array($ids) ? implode(', ', $ids) : $ids }}</span></div>@endforeach</td>
                            <td><span class="badge {{ $log->result === 'completed' ? 'bg-success' : 'bg-danger' }}">{{ trans('admin.audit.'.$log->result) }}</span></td>
                            <td>{{ $log->response_status }}</td><td dir="ltr">{{ $log->ip_address }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">{{ trans('admin.audit.empty') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
