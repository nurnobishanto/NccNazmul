@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',[
 'parent_title' => 'Author',
 'url' => '#',
 'title' => $author->name,])
    <!--Start Blog Grid-->
    <section class="blog-page pad-tb pt40">
        <div class="container">
            <div class="row">
                @if($authorposts->count())
                    @foreach ($authorposts as $post)
                        @include('website.includes.single_post',['post' => $post])
                    @endforeach
                @else
                    <h2 class="text-center text-danger">No Post Found</h2>
                @endif
            </div>
            {{ $authorposts->links('vendor.pagination.niwax') }}
        </div>
    </section>
    <!--End Blog Grid-->

@endsection
