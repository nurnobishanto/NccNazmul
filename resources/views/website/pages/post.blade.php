@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',[
     'title' => $post->title,])
    <!-- Start Page Banner Area -->
    <section class="blog-page pad-tb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-header">
                        <h1>{{ $post->title }}</h1>
                        <div class="row mt20 mb20">
                            <div class="col-md-8 col-9">
                                <div class="media">
                                    @if ($post->author)
                                    <div class="user-image bdr-radius">
                                        @if($post->author->image)
                                            <img src="{{ asset('uploads/'.$post->author->image) }}" class="rounded-circle"
                                                 alt="{{ $post->author->name }}">
                                        @else
                                            <img src="{{ asset('website/images/user-thumb/user.png') }}" class="rounded-circle"
                                                 alt="{{ $post->author->name }}">
                                        @endif

                                    </div>
                                    <div class="media-body user-info">
                                        <h5>By <a href="{{ Route('website.author', ['slug' => $post->author->id]) }}">{{ $post->author->name}}</a></h5>
                                        <p>{{ $post->created_at->format('M d, Y')}}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-3">
                                <div class="postwatch"><i class="far fa-eye"></i> {{ $post->view_count }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="image-set">
                        @if ($post->image)
                            <img src="{{  asset('uploads/'.$post->image) }}"  class="img-fluid"
                                 alt="{{ $post->title }}<">
                        @endif
                    </div>
                    <div class="blog-content mt30">
                        {!! $post->body !!}
                    </div>

                    <div class="comments-block mt60">
                        <h2 class="mb60">Comments ({{$comments->count()}}):</h2>
                        @foreach ($comments as $comment)
                        <div class="media">
                            <div class="user-image">
                                @if ($comment->user)
                                    @if($comment->user->image)
                                        <img src="{{ asset('uploads/'.$comment->user->image) }}" class="rounded-circle img-fluid"
                                             alt="{{ $comment->user->name }}">
                                    @else

                                        <img src="{{asset('website')}}/images/user-thumb/{{$comment->user->gender}}.png" class="rounded-circle img-fluid"
                                             alt="{{ $comment->user->name }}">
                                    @endif
                                @else
                                    <img src="{{asset('website')}}/images/user-thumb/user.png" alt="girl" class="img-fluid">
                                @endif

                            </div>
                            <div class="media-body user-info">
                                <h5 class="mb10">
                                    @if ($comment->user)
                                        {{$comment->user->name}} <small>says:</small>
                                    @else
                                        Unknown User <small>says:</small>
                                    @endif
                                    <span>{{ $comment->created_at->format('M d, Y') }}</span>
                                </h5>

                                <p>{{ $comment->comment}}</p>
                            </div>
                        </div>
                        @endforeach
                        {{ $comments->links('vendor.pagination.niwax') }}
                        <div class="form-block form-blog mt60">
                            @if (Auth::user())
                                @php
                                    $currentuser = Auth::id();
                                @endphp
                                <form action="{{ route('comment.store') }}" method="POST">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                            @php
                                                Session::forget('success');
                                            @endphp
                                        </div>
                                    @endif
                                    @csrf
                                        <input required hidden type="number" value="{{ Auth::user()->id }}"
                                               name="user_id">
                                        <input required hidden type="number" value="{{ $post->id }}"
                                               name="post_id">

                                    <div class="fieldsets"><textarea placeholder="Write Your Comment" name="comment">{{old('comment')}}</textarea></div>
                                    <div class="fieldsets mt10">
                                        <button type="submit" name="#" class="btn-main bg-btn lnk">Submit <i class="fas fa-chevron-right fa-icon"></i><span class="circle"></span></button>
                                    </div>
                                </form>
                            @else
                                <h5>You must be <a class="text-danger" href="{{ route('login') }}" target="_blank">logged</a> in to
                                        comment
                                        on this post. <a class="text-danger" href="{{ route('login') }}" target="_blank">Login</a> or <a
                                            class="text-danger" href="{{ route('register') }}" target="_blank">Register</a> </h5>
                            @endif

                        </div>
                    </div>
                </div>
                <!--End Blog Details-->
                <!--Start Sidebar-->
                @include('website.includes.blog_sidebar')
                <!--End Sidebar-->
            </div>
        </div>
    </section>



@endsection
