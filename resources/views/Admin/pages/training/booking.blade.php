@extends('Admin.Layouts.master')

@section('title', trans('admin.training.create'))


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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.training.index') }}">{{ trans('admin.training.training') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('admin.training.create') }}</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <!--  END BREADCRUMBS  -->

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:24px;">
                <form method="POST" action="{{ route('admin.training.storeBooking') }}">
                    @csrf
                    <input type="hidden" name="training_id" value="{{ $training->id }}">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ trans('admin.training.create_booking') }}</h3>
                        </div>
                        <div class="card-body">
                            @include('Admin.pages.training.partials._formBooking')
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mt-3">{{ trans('admin.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ app()->getLocale() }}" id="lang">
@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const lang = $('#lang').val();

            function loadCities(countryID, callback) {
                if (countryID) {
                    $.ajax({
                        url: '{{ route("admin.training.getCities") }}',
                        type: "POST",
                        data: { country_id: countryID },
                        dataType: "json",
                        success: function(data) {
                            $('#city').empty();
                            $('#city').append('<option value="">{{ trans('admin.training.select_city') }}</option>');
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' + value.name[lang] + '</option>');
                            });
                            if (callback) callback();
                        }
                    });
                } else {
                    $('#city').empty();
                    $('#area').empty();
                }
            }

            function loadAreas(cityID, callback) {
                if (cityID) {
                    $.ajax({
                        url: '{{ route("admin.training.getAreaByCity") }}',
                        type: "POST",
                        data: { city_id: cityID },
                        dataType: "json",
                        success: function(data) {
                            $('#area').empty();
                            $('#area').append('<option value="">{{ trans('admin.academies.select_area') }}</option>');
                            $.each(data, function(key, value) {
                                $('#area').append('<option value="' + value.id + '">' + value.name[lang] + '</option>');
                            });
                            if (callback) callback();
                        }
                    });
                } else {
                    $('#area').empty();
                }
            }

            $('#country').change(function() {
                var countryID = $(this).val();
                loadCities(countryID);
            });

            $('#city').change(function() {
                const cityID = $(this).val();
                loadAreas(cityID);
            });

            // Load initial data if old values exist
            const oldCountry = '{{ old('country_id') }}';
            const oldCity = '{{ old('city_id') }}';
            const oldArea = '{{ old('area_id') }}';

            if (oldCountry) {
                $('#country').val(oldCountry);
                loadCities(oldCountry, function() {
                    if (oldCity) {
                        $('#city').val(oldCity);
                        loadAreas(oldCity, function() {
                            if (oldArea) {
                                $('#area').val(oldArea);
                            }
                        });
                    }
                });
            }
        });
    </script>


@endpush


