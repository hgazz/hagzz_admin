@extends('Admin.Layouts.master')

@section('title', trans('admin.training.Show Details'))


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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.training.index') }}">{{ trans('admin.training.training') }}</a> </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('admin.academies.show') .  ' ' . $training->name}}</li>
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
                            <div class="card-body">
                                <div class="simple-tab">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab-icon" data-bs-toggle="tab" data-bs-target="#home-tab-icon-pane" type="button" role="tab" aria-controls="home-tab-icon-pane" aria-selected="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> {{ trans('admin.training.main_details') }}
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab-icon" data-bs-toggle="tab" data-bs-target="#profile-tab-icon-pane" type="button" role="tab" aria-controls="profile-tab-icon-pane" aria-selected="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                {{ trans('admin.training.Classes') }}
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home-tab-icon-pane" role="tabpanel" aria-labelledby="home-tab-icon" tabindex="0">
                                               <div class="container-fluid mt-4">
                                                   <div class="row">
                                                       <div class="col-sm-4 mt-2">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h5 class="card-title">{{ trans('admin.training.name') }}</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <p class="card-text text-dark fw-bold">{{$training->getTranslation('name', 'en') ." | ". $training->getTranslation('name', 'ar')}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           <div class="col-sm-4 mt-2">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h5 class="card-title">{{ trans('admin.training.price') }}</h5>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <p class="card-text text-dark fw-bold">{{$training->price}}</p>
                                                                        </div>
                                                                    </div>
                                                           </div>
                                                           <div class="col-sm-4 mt-2">
                                                               <div class="card">
                                                                   <div class="card-header">
                                                                       <h5 class="card-title">{{ trans('admin.training.discount_price') }}</h5>
                                                                   </div>
                                                                   <div class="card-body">
                                                                       <p class="card-text text-dark fw-bold">{{$training->discount_price}}</p>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                           <div class="col-sm-4 mt-2">
                                                               <div class="card">
                                                                   <div class="card-header">
                                                                       <h5 class="card-title">{{ trans('admin.training.start_date') }}</h5>
                                                                   </div>
                                                                   <div class="card-body">
                                                                       <p class="card-text text-dark fw-bold">{{$training->start_date}}</p>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                           <div class="col-sm-4 mt-2">
                                                                   <div class="card">
                                                                       <div class="card-header">
                                                                           <h5 class="card-title">{{ trans('admin.training.end_date') }}</h5>
                                                                       </div>
                                                                       <div class="card-body">
                                                                           <p class="card-text text-dark fw-bold">{{$training->end_date}}</p>
                                                                       </div>
                                                                   </div>
                                                           </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.academy') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->academy->commercial_name}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.coach') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->coach->name}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.max_players') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->max_players}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.level') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->level}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.gender') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->gender}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.age_group') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->age_group}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.address') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->address->address}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.sport') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->sport->name}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-4 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.active') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->active ? trans('admin.training.active') : trans('admin.training.InActive')}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-6 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.description_en') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->getTranslation('description', 'en')}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="col-sm-6 mt-2">
                                                           <div class="card">
                                                               <div class="card-header">
                                                                   <h5 class="card-title">{{ trans('admin.training.description_ar') }}</h5>
                                                               </div>
                                                               <div class="card-body">
                                                                   <p class="card-text text-dark fw-bold">{{$training->getTranslation('description', 'ar')}}</p>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                                </div>

                                            </div>

                                        <div class="tab-pane fade" id="profile-tab-icon-pane" role="tabpanel" aria-labelledby="profile-tab-icon" tabindex="0">
                                           @forelse($training->classes as $class)
                                                <div class="col-md-6 col-lg-4 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title">{{$class->title}}</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            @php
                                                                $numberOfOutcomes = count(json_decode($class->out_comes, true));
                                                                $numberBringsWithMe = count(json_decode($class->bring_with_me, true));
                                                                $outcomes = json_decode($class->out_comes, true);
                                                                $bringsWithMe = json_decode($class->bring_with_me, true);
                                                            @endphp
                                                            <div class="col-sm-6">
                                                                {{$outcomes[1]}}
{{--                                                                <ul>{{ trans('admin.training.out_comes') }}--}}
{{--                                                                    @for($i = 0; $i < $numberOfOutcomes; $i++)--}}
{{--                                                                        <li>{{$class->out_comes[$i]}}</li>--}}
{{--                                                                    @endfor--}}
{{--                                                                </ul>--}}
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <ul>{{ trans('admin.training.brings_with_me') }}
                                                                    @for($i = 0; $i < $numberBringsWithMe; $i++)
                                                                        <li>{{$class->bring_with_me[$i]}}</li>
                                                                    @endfor
                                                                </ul>
                                                            </div>

                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="card-text text-dark fw-bold">{{$class->date}}</p>
                                                            <small class="text-muted">{{ trans('admin.training.start_time') }}: {{ $class->start_time }}</small>
                                                            <small class="float-end text-muted">{{ trans('admin.training.end_time') }}: {{ $class->end_time }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-sm-8 mx-auto mt-3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title fw-bold text-center">{{ trans('admin.training.no_classes') }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                           @endforelse
                                        </div>
                                        <hr>
                                        <form action="{{ route('admin.training.active', $training) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="{{ !$training->active ? 'btn btn-danger' : 'btn btn-success' }}"> {{ $training-> active ? trans('admin.academies.make_inactive') : trans('admin.academies.make_active') }}</button>
                                        </form>
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

