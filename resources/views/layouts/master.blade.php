<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8"/>
    @yield('seo_meta')
    {!! SEO::generate() !!}
{{--    <title>Niwax - Web Design &amp; Digital Marketing Agency HTML Template</title>--}}
{{--    <meta name="description" content="Creative Agency, Marketing Agency Template">--}}
{{--    <meta name="keywords" content="Creative Agency, Marketing Agency">--}}
{{--    <meta name="author" content="rajesh-doot">--}}
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#2e2a8f">
    <!--website-favicon-->
    <link href="images/favicon.png" rel="icon">
    <!--plugin-css-->
    <link href="{{asset('website')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('website')}}/css/plugin.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- template-style-->
    <link href="{{asset('website')}}/css/style.css" rel="stylesheet">
    <link href="{{asset('website')}}/css/responsive.css" rel="stylesheet">
    <link href="{{asset('website')}}/css/darkmode.css" rel="stylesheet">
    @laravelPWA
    @yield('css')
</head>
<body>
<!-- top progress bar start-->
<div id="progress-bar"></div>
<!-- top progress bar end -->

<!--Start Preloader -->
@if(env('PRE_LOADING') == 'show')
@include('website.includes.preloader')
@endif
<!--End Preloader -->
<!--Start Header -->
@include('website.includes.header')
<!--End Header -->


@yield('content')






<!--Start Footer-->
@include('website.includes.footer')
<!--End Footer-->
@if(env('LEAD_POPUP'))
<!-- lead generaton popup start -->
@include('website.includes.leadpopup')
<!-- lead generaton popup end -->
@endif
<!-- js placed at the end of the document so the pages load faster -->
<script src="{{asset('website')}}/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="{{asset('website')}}/js/jquery.min.js"></script>
<script src="{{asset('website')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('website')}}/js/plugin.min.js"></script>
<script src="{{asset('website')}}/js/preloader.js"></script>
<script src="{{asset('website')}}/js/dark-mode.js"></script>
<!--common script file-->
<script src="{{asset('website')}}/js/main.js"></script>
<script src="{{asset('website')}}/js/progress-bar.js"></script>

@if(env('LEAD_POPUP'))
<script>
    $(window).on('load',function(){
        var delayMs = 4000; // delay in milliseconds
        setTimeout(function(){
            $('#leadModal').modal('show');
        }, delayMs);
    });
</script>
@endif
<script>
//Mobile nav
var $main_nav = $('#main-nav');
var defaultOptions = {
    navTitle: '{{getSetting('site_title')}}',
};
// Nav call plugin
var Nav = $main_nav.hcOffcanvasNav(defaultOptions);
</script>
@yield('js')
</body>
</html>
