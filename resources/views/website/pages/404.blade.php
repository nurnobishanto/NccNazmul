@extends('layouts.master')
@section('content')
    <!--Start 404 Error-->
    <section class=" bg-gradient pad-tb">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt50 mb50">
                    <div class="layer-div">
                        <div class="error-block">
                            <h1>Page not Found</h1>
                            <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                            <div class="images mt20">
                                <img src="{{route('website')}}/images/shape/error-page.png" alt="error page" class="img-fluid"/>
                            </div>
                            <a href="{{route('website')}}" class="btn-outline">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
