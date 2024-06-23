@extends('Admin.Layouts.master')

@section('title', trans('admin.user.show_details'))

@push('css')


@endpush
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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">{{ trans('admin.user.user') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('admin.user.show_details') }}</li>
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
                <div class="card">
                    <div class="container mt-4">
                        <h2 class="text-center"> {{trans('admin.user.Trainings')}} </h2>
                        @if($showUser->joins->count() == 0)
                            <h3 class="text-center"> {{trans('admin.user.no_trainings')}} </h3>
                        @else
                            <div class="row mt-4">
                            @foreach($showUser->joins as $join)
                                <div class="col-md-4 mb-2">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{$join->training->sport->icon}}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ trans('admin.user.training_name') }} : {{$join->training->name}}</h5>
                                            <p class="card-text">{{ trans('admin.user.training_details') }} : {{$join->training->description}}</p>
                                            <p class="text-success">{{ trans('admin.user.start_date') }} : {{$join->training->start_date}}</p>
                                            <p class="text-danger">{{ trans('admin.user.end_date') }} : {{$join->training->end_date}}</p>
                                            <p>{{trans('admin.user.coach')}} : {{$join->training->coach->name}} </p>
                                            <p>{{trans('admin.training.academy')}} : {{$join->training->academy->commercial_name}} </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                        <hr>
                        <h2 class="text-center"> {{trans('admin.user.Sports')}} </h2>
                        @if($showUser->sports->count() == 0)
                            <h3 class="text-center"> {{trans('admin.user.no_sports')}} </h3>
                        @else
                        <div class="row mt-4">
                            @foreach($showUser->sports as $sport)
                                <div class="col-md-4 mb-2">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{$sport->icon}}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$sport->name}}</h5>
                                            @if($sport->status == 'active')
                                                <p class="card-text text-success">{{$sport->status}}</p>
                                            @else
                                                <p class="card-text text-danger">{{$sport->status}}</p>
                                            @endif
                                            <span class="">{{ trans('admin.academies.academies') }} - {{$sport->academy->commercial_name ?? trans('admin.user.sport_not_related_to_partner')}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ url()->previous()}}" class="btn btn-primary btn-lg"> {{trans('admin.user.back')}}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

