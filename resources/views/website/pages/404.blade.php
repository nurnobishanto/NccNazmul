@extends('layouts.master')
@section('content')
    <!-- Start 404 Error Area -->
    <div class="error-area ptb-100">
        <div class="container">
            <div class="error-content">
                <img src="{{asset('website')}}/assets/images/error.png" alt="{{getSetting('site_title')}}">
                <h3>{{("Error 404 : Page Not Found")}}</h3>
                <p>{{("The page you are looking for might have been removed had its name changed or is temporarily unavailable.")}}</p>
                <a href="{{route('website')}}" class="default-btn">{{("Back to Homepage")}}</a>
            </div>
        </div>
    </div>
    <!-- End 404 Error Area -->
@endsection
