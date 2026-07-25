@extends('Admin.Layouts.master')

@section('title', trans('admin.academies.show'). " | " . $academies->commercial_name)

@section('content')
    <div class="middle-content container-xxl p-0">

        <!--  BEGIN BREADCRUMBS  -->
        <div class="secondary-nav">
            <div class="breadcrumbs-container" data-page-heading="Analytics">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">

                            <div class="page-title">
                            </div>

                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ trans('admin.dashboard') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.academies.index') }}">{{ trans('admin.academies.academies') }}</a> </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('admin.academies.show') .  ' ' . $academies->commercial_name}}</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <!--  END BREADCRUMBS  -->

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="row m-auto">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{$academies->commercial_name}}</h5>
                                <img src="{{ $academies->image }}" width="120px" height="80px" class="img-thumbnail" alt="{{$academies->commercial_name}}">
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.commercial_name') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->getTranslation('commercial_name', 'en') . " | " . $academies->getTranslation('commercial_name', 'ar') ??  null}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.address.location') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->address ?? null}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.role') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->role}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.email') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->email}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.phone') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->phone}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.trade_license_number') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->trade_license_number}}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.trade_license_expire_date') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->trade_license_expire_date}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">--}}
{{--                                        <div class="card me-2">--}}
{{--                                            <div class="card-header">--}}
{{--                                                <h5 class="card-title text-center">{{ trans('admin.academies.national_id_number') }}</h5>--}}
{{--                                            </div>--}}
{{--                                            <div class="card-body">--}}
{{--                                                <p class="card-text text-center text-dark fw-bold">--}}
{{--                                                    {{$academies->national_id_number ?? 'null'}}--}}
{{--                                                </p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.status') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->status ?? 'null'}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.Tax percentage') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->percentage?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.owner_name') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->owner_name?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.tax_number') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->tax_number?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.facebook') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    <a href="{{$academies->facebook?? null}}">{{ trans('admin.academies.facebook') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.instagram') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    <a href="{{$academies->instagram ?? null}}">{{ trans('admin.academies.instagram') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.app_name') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->app_name ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{trans('admin.academies.Account Manger')}}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    {{$academies->account_manager}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.website') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->website ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.contract_link') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->contract_link ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.bank_name') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->bank_name ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.bank_account_type') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->bank_account_type ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.beneficiary_name') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->beneficiary_name ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.commission_percentage') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->commission_percentage ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.bank_account_number') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->bank_account_number ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.non_refund_days_count') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->non_refund_days_count ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.settlement_days_count') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                {{$academies->settlement_days_count ?? null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                        <div class="card me-2">
                                            <div class="card-header">
                                                <h5 class="card-title text-center">{{ trans('admin.academies.contract_link') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text text-center text-dark fw-bold">
                                                    <a href="{{$academies->contract_link }}" download="">{{ trans('admin.academies.download') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4 px-3">
                                    <div class="col-12">
                                        <div class="card border">
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                                <h6 class="card-title m-0 fw-bold text-dark"><i class="fa-solid fa-users-gear me-2"></i> طاقم العمل والمستخدمين (Team Members)</h6>
                                                <span class="badge bg-primary">{{ $academies->users->count() }} مستخدم</span>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>الاسم</th>
                                                                <th>البريد الإلكتروني</th>
                                                                <th>الهاتف</th>
                                                                <th>الدور (Role)</th>
                                                                <th>نطاق الفروع</th>
                                                                <th>الحالة</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($academies->users as $user)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td class="fw-bold">
                                                                        {{ $user->name }}
                                                                        @if($user->is_owner) <span class="badge bg-warning text-dark ms-1">المالك</span> @endif
                                                                    </td>
                                                                    <td>{{ $user->email }}</td>
                                                                    <td>{{ $user->phone ?? '-' }}</td>
                                                                    <td>
                                                                        @foreach($user->roles as $role)
                                                                            <span class="badge bg-info text-dark me-1">{{ app()->getLocale() == 'ar' ? $role->display_name_ar : $role->display_name_en }}</span>
                                                                        @endforeach
                                                                        @if($user->is_owner && $user->roles->isEmpty()) <span class="badge bg-warning text-dark">مالك الشريك</span> @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($user->is_owner || $user->access_all_branches)
                                                                            <span class="badge bg-success">كافة الفروع</span>
                                                                        @else
                                                                            <span class="badge bg-secondary">{{ $user->assignedBranches->count() }} فرع</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge @if($user->status === 'active') bg-success @else bg-danger @endif">{{ $user->status }}</span>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center text-muted py-3">لا يوجد مستخدمون مسجلون لهذا الشريك بعد.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                </div>
                            </div>

                            <div class="row mt-4 px-3">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <h6 class="card-title m-0 fw-bold text-dark"><i class="fa-solid fa-list-check me-2"></i> سجل أحداث وأنشطة الشريك (Partner Activity Log)</h6>
                                            <span class="badge bg-secondary">{{ $academies->activityLogs->count() }} حدث</span>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>المستخدم</th>
                                                            <th>الحدث (Action)</th>
                                                            <th>التفاصيل</th>
                                                            <th>عنوان IP</th>
                                                            <th>التاريخ والتوقيت</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($academies->activityLogs->take(20) as $log)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td class="fw-bold">{{ $log->user_name ?? 'الشريك' }}</td>
                                                                <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                                                                <td>{{ $log->description }}</td>
                                                                <td><code>{{ $log->ip_address ?? '-' }}</code></td>
                                                                <td>{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted py-3">لا يوجد أنشطة مسجلة لهذا الشريك حتى الآن.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


<div class="card-footer">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 d-block ">
            <form method="POST"  action="{{ route('admin.academies.updateStatus', $academies) }}" id="updateStatus" class="me-1 d-inline">
                @csrf
                @method('PUT')
                <button class="btn mt-2  w-25 @if($academies->status == 'active') btn-success @else btn-danger @endif">{{$academies->status}}</button>
            </form>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 d-block">
            <button class="btn mt-2  w-25 @if($academies->is_registered) btn-success @else btn-danger @endif d-inline">{{ trans('admin.academies.is_registered') }}</button>
        </div>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
{{--    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.8/datatables.min.js"></script>--}}
<script src="{{ asset('assetsAdmin/src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
@endpush
