<section class="breadcrumb-area banner">
    <div class="text-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 v-center">
                    <div class="bread-inner">
                        <div class="bread-menu">
                            <ul>
                                <li><a href="{{route('website')}}">Home</a></li>
                                @if(!empty($parent_title) )
                                <li><a href="{{$url}}">{{$parent_title}}</a></li>
                                @endif
                                <li><a href="">{{$title}}</a></li>
                            </ul>
                        </div>
                        <div class="bread-title">
                            <h2>{{$title}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
