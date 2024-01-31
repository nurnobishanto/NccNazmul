@extends('layouts.master')
@section('content')
    <!--Start 404 Error-->
    <section class=" bg-gradient pad-tb">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt50 mb50">
                    <div class="">
                        <div class="error-block">
                            <h1>Limit Crossed: Unable to Take Exam</h1>
                            <p>We regret to inform you that you have exceeded the allowed limit for taking this exam. Please review the exam guidelines and restrictions. If you believe this is an error, kindly contact our support team for assistance. Thank you for your understanding.</p>
                            <div class="images mt20">
                                <img src="{{route('website')}}/website/images/shape/error-page.png" alt="error page" class="img-fluid"/>
                            </div>
                            <a href="{{route('website')}}" class="btn-outline">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
