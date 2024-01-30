@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'Search : '.request()->query('search'),'url'=>'#'])


        <!-- Start Blog Area -->
        <div class="portfolio-page pad-tb">
            <div class="container">
                <div class="row justify-content-center">
                    @if ($searchpost->count()==0)
                        <h2 class="text-danger text-center">No Post Found</h2>
                    @else
                    @foreach ($searchpost as $post)
                            @include('website.includes.single_post',['post' => $post])
                    @endforeach
                 @endif
                </div>
                {{ $searchpost->appends(['search'=>request()->query('search')])->links('vendor.pagination.niwax') }}

            </div>
        </div>
        <!-- End Blog Area -->
        @endsection
