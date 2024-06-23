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
                        <div class="row mt-4">
                            @foreach($showUser->joins as $join)
                                <div class="col-md-4">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{$join->training->sport->icon}}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$join->training->name}}</h5>
                                            <p class="card-text">{{$join->training->description}}</p>
                                            <span class="text-success">{{$join->training->start_date}}</span>
                                            /
                                            <span class="text-danger">{{$join->training->end_date}}</span>
                                            <br>
                                            <span>{{trans('admin.user.coach')}} :{{$join->training->coach->name}} </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <h2 class="text-center"> {{trans('admin.user.Sports')}} </h2>
                        <div class="row mt-4">
                            @foreach($showUser->sports as $sport)
                                <div class="col-md-4">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{$sport->icon}}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$sport->name}}</h5>
                                            @if($sport->status == 'active')
                                                <p class="card-text text-success">{{$sport->status}}</p>
                                            @else
                                                <p class="card-text text-danger">{{$sport->status}}</p>
                                            @endif
                                            <span class="">{{ trans('admin.academies.academies') }} - {{$sport->academy->commercial_name ?? 'Not Academy'}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

