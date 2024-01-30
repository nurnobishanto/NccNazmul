@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'Our Blog Posts','url'=>'#'])
    <!--Start Blog Grid-->
    <section class="blog-page pad-tb">
        <div class="container">
            <div class="row">
                @foreach ($allposts as $post)
                    @include('website.includes.single_post',['post' => $post])
                @endforeach
            </div>
            {{ $allposts->links('vendor.pagination.niwax') }}
        </div>
    </section>
    <!--End Blog Grid-->

@endsection
