<div class="col-lg-4">
    <div class="sidebar">
        <!--Start block for offer/ads-->
{{--        <div class="offer-image">--}}
{{--            <img src="images/blog/strategy-guide.jpg" alt="offer" class="img-fluid">--}}
{{--        </div>--}}
        <!--End block for offer/ads-->
        <!--Start Recent post-->
{{--        <div class="widgets ">--}}
{{--            <form class="search-form" method="GET" action="{{ route('website')}}">--}}
{{--                <input name="search" type="search" class="search-field" placeholder="Search...">--}}
{{--                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>--}}
{{--            </form>--}}
{{--        </div>--}}
        <div class="recent-post widgets mt60">
            <h3 class="mb30">Popular Posts</h3>

            @foreach ($poularpost as $item)
            <div class="media">
                <div class="post-image bdr-radius">
                    <a href="{{route('website.post',['slug'=>$item->slug])}}">
                        @if($item->image)
                            <img src="{{ asset('uploads/'. $item->image )}}" alt="{{$item->title}}" class="img-fluid">
                        @else
                            <img src="{{ asset('website/images/blog/blog-1.jpg' )}}" alt="{{$item->title}}" class="img-fluid">
                        @endif
                    </a>
                </div>
                <div class="media-body post-info">
                    <h5><a href="{{Route('website.post',['slug'=>$item->slug])}}">{{$item->title}}</a></h5>
                    <p>{{$item->created_at->format('M d, Y')}}</p>
                </div>
            </div>
            @endforeach

        </div>
        <!--Start Recent post-->
        <!--Start Blog Category-->
        <div class="recent-post widgets mt60">
            <h3 class="mb30">Category Clouds</h3>
            <div class="blog-categories">
                <ul>
                    @foreach ($allcategories as $category)
                    <li>
                        <a href="{{route('website.category',['slug'=>$category->slug])}}">{{$category->name}} <span class="categories-number">({{$category->posts->count()}})</span></a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--End Blog Category-->


    </div>
</div>
