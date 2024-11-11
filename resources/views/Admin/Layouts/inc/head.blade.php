{{--<link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet"--}}
{{--    type="text/css" />--}}
{{--<link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />--}}
{{--<script src="{{ asset('assetsAdmin/layouts/vertical-light-menu/loader.js') }}"></script>--}}

<!-- BEGIN GLOBAL MANDATORY STYLES -->
@if (app()->getLocale() == 'ar')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<link href="{{ asset('assetsAdmin/ar/src/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assetsAdmin/ar/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assetsAdmin/ar/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap"
    rel="stylesheet">
@else
<link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700" rel="stylesheet">
<link href="{{ asset('assetsAdmin/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet"
    type="text/css" />
@endif
<!-- END GLOBAL MANDATORY STYLES -->
@stack('css')
