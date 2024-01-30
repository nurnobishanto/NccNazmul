@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',[
    'parent_title' => 'Category Clouds',
    'url' => route('website.category_clouds'),
    'title' => $category->name,])
    <!--Start Blog Grid-->
    <section class="blog-page pad-tb pt40">
        <div class="container">
            <div class="row">
                @if($categoryposts->count())
                @foreach ($categoryposts as $post)
                    @include('website.includes.single_post',['post' => $post])
                @endforeach
                @else
                    <h2 class="text-center text-danger">No Post Found</h2>
                @endif
            </div>
            {{ $categoryposts->links('vendor.pagination.niwax') }}
        </div>
    </section>
    <!--End Blog Grid-->
@endsection
