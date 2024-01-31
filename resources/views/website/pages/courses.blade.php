@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => $title,'url'=>'#'])
    <div class="shop-products-bhv pt20 pb60">
        <div class="container">
            <div class="row">
                @foreach($courses as $course)
                @include('website.includes.single_course',['course' => $course])
                @endforeach
            </div>
            {{ $courses->links('vendor.pagination.niwax') }}

        </div>
    </div>
@endsection
