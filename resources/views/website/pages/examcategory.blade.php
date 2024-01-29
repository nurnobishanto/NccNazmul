@extends('layouts.master')

@section('content')

    <!-- Start Blog Area -->
    <div class="blog-area pt-5 pb-4">
        <div class="container">
            <h2 class="text-center">Select Exam Category</h2>
            <hr>
            <div class="row justify-content-center">
                @foreach ($ecats as $sub)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-blog-card">


                                @if ($sub->image)
                                <div class="blog-image">
                                    <a href="{{ route('exam_category', ['slug' => $sub->slug]) }}"><img
                                            src="{{ asset('uploads/'.$sub->image) }}" alt="{{ $sub->name }}"></a>
                                    <div class="blog-content with-padding">
                                        <b>{{ $sub->name }}</b>
                                    </div>
                                   </div>
                                @else
                                    <a class="d-block" href="{{ route('exam_category', ['slug' => $sub->slug]) }}">
                                        <h4 class="text-light text-center align-middle pt-5 pb-5 p-2 rounded-pill"
                                            style="background-color: #004400;">
                                            {{ $sub->name }}
                                        </h4>
                                    </a>
                                @endif

                        </div>
                    </div>
                @endforeach


            </div>

            {{-- {{ $ecats->links('vendor.pagination.custom') }} --}}
        </div>
    </div>
    <!-- End Blog Area -->
@endsection
