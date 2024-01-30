<div class="col-lg-4 mt60">
    <div class="single-blog-post- shdo">
        <div class="single-blog-img-">
            @if ($post->image)
                <a href="{{ Route('website.post', ['slug' => $post->slug]) }}"><img
                        src="{{ asset('uploads/'.$post->image) }}" alt="{{ $post->title }}" class="img-fluid"></a>
            @else
                <a href="{{ Route('website.post', ['slug' => $post->slug]) }}"><img
                        src="{{ asset('website') }}/images/blog/blog-1.jpg"
                        alt="{{ $post->title }}" class="img-fluid"></a>
            @endif
            <div class="entry-blog-post dg-bg2">
                @if ($post->category)
                    <span class="bypost-"><a href="{{ Route('website.category', ['slug' => $post->category->slug]) }}"><i class="fas fa-tag"></i> {{ $post->category->name }}</a></span>
                @endif
                <span class="posted-on-"><a href="#"><i class="fas fa-clock"></i> Sep 23, 2020</a></span>
            </div>
        </div>
        <div class="blog-content-tt">
            <div class="entry-blog">
                @if ($post->author)
                    <span class="bypost"><a href="{{ Route('website.author', ['slug' => $post->author->id]) }}"><i class="fas fa-user"></i> {{ $post->author->name }}</a></span>
                @endif

                <span class="posted-on"><a href="#"><i class="fas fa-clock"></i> {{ $post->created_at->format('M d, Y') }}</a></span>
                <span><a href="#"><i class="fas fa-comment-dots"></i> (<span>
                                                  @if ($post->view_count < 1000)
                                {{ $post->view_count }}
                            @else
                                @php
                                    $count = $post->view_count / 1000;
                                @endphp
                                @if ($count < 100)
                                    {{ round($count, 2) }}K
                                @else
                                    @php
                                        $countm = $count / 1000;
                                    @endphp
                                    {{ round($countm, 2) }}M
                                @endif
                            @endif
                                            </span>)</a></span>
            </div>
            <div class="single-blog-info-">
                <h4><a href="{{ Route('website.post', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h4>
                @if (strlen($post->excerpt) != 0)
                    <p>{{ Str::limit($post->excerpt), 100, ' ...' }}</p>
                @else
                    <p>{{ Str::limit(strip_tags($post->body)), 100, ' ...' }}</p>
                @endif
            </div>
            <div class="post-social">
                <div class="ss-inline-share-wrapper ss-hover-animation-fade ss-inline-total-counter-left ss-left-inline-content ss-small-icons ss-with-spacing ss-circle-icons ss-without-labels">
                    <div class="ss-inline-share-content">
                        <div class="ss-social-icons-container">
                            <a href="javascript:void(0)">Shares</a>
                            <a href="javascript:void(0)" target="blank"><i class="fab fa-facebook"></i></a>
                            <a href="javascript:void(0)" target="blank"><i class="fab fa-twitter"></i></a>
                            <a href="javascript:void(0)" target="blank"><i class="fab fa-linkedin"></i></a>
                            <a href="javascript:void(0)" target="blank"><i class="fas fa-envelope"></i></a>
                            <a href="javascript:void(0)" target="blank"><i class="fab fa-facebook-messenger"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
