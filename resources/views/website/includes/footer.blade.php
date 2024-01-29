<footer>

{{--   @include('website.includes.newsletter')--}}
    <div class="footer-row2">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-3 col-sm-6  ftr-brand-pp">
                    <a class="navbar-brand mt30 mb25 f-dark-logo" href="{{route('website')}}"> <img src="{{asset('uploads/'.getSetting('site_footer_logo'))}}" alt="{{getSetting('site_title')}}"/></a>
                    <a class="navbar-brand mt30 mb25 f-white-logo" href="{{route('website')}}"> <img src="{{asset('uploads/'.getSetting('site_footer_dark_logo'))}}" alt="{{getSetting('site_title')}}" /></a>
                    <p>{!! getSetting('site_address') !!}</p>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <h5>Contact Us</h5>
                    <ul class="footer-address-list ftr-details">
                        <li>
                            <span><i class="fas fa-envelope"></i></span>
                            <p>Email <span> <a href="mailto:{{getSetting('site_email')}}">{{getSetting('site_email')}}</a></span></p>
                        </li>
                        <li>
                            <span><i class="fas fa-phone-alt"></i></span>
                            <p>Phone <span> <a href="tel:{{getSetting('site_phone')}}">{{getSetting('site_phone')}}</a></span></p>
                        </li>
                        @if(getSetting('site_phone_2'))
                        <li>
                            <span><i class="fas fa-phone-alt"></i></span>
                            <p>Phone <span> <a href="tel:{{getSetting('site_phone_2')}}">{{getSetting('site_phone_2')}}</a></span></p>
                        </li>
                        @endif
                        <li>
                            <span><i class="fas fa-map-marker-alt"></i></span>
                            <p>Address <span> {{getSetting('site_address')}}</span></p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h5>Company</h5>
                    <ul class="footer-address-list link-hover">
                        <li><a href="get-quote.html">Contact</a></li>
                        <li><a href="javascript:void(0)">Customer's FAQ</a></li>
                        <li><a href="javascript:void(0)">Refund Policy</a></li>
                        <li><a href="javascript:void(0)">Privacy Policy</a></li>
                        <li><a href="javascript:void(0)">Terms and Conditions</a></li>
                        <li><a href="javascript:void(0)">License & Copyright</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 footer-blog-">
                    <h5>Latest Blogs</h5>
                    <div class="single-blog-">
                        <div class="post-thumb"><a href="#"><img src="{{asset('website')}}/images/blog/blog-small.jpg" alt="blog"></a></div>
                        <div class="content">
                            <p class="post-meta"><span class="post-date"><i class="far fa-clock"></i>April 15, 2020</span></p>
                            <h4 class="title"><a href="blog-sngle.html">We Provide you Best &amp; Creative Consulting Service</a></h4>
                        </div>
                    </div>
                    <div class="single-blog-">
                        <div class="post-thumb"><a href="#"><img src="{{asset('website')}}/images/blog/blog-small.jpg" alt="blog"></a></div>
                        <div class="content">
                            <p class="post-meta"><span class="post-date"><i class="far fa-clock"></i>April 15, 2020</span></p>
                            <h4 class="title"><a href="blog-sngle.html">We Provide you Best &amp; Creative Consulting Service</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-row3">
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-social-media-icons">
                            @if(getSetting('site_facebook'))
                            <a href="{{getSetting('site_facebook')}}" target="blank"><i class="fab fa-facebook"></i></a>
                            @endif
                            @if(getSetting('site_twitter'))
                            <a href="{{getSetting('site_twitter')}}" target="blank"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if(getSetting('site_instagram'))
                            <a href="{{getSetting('site_instagram')}}" target="blank"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if(getSetting('site_linkedin'))
                            <a href="{{getSetting('site_linkedin')}}" target="blank"><i class="fab fa-linkedin"></i></a>
                            @endif
                            @if(getSetting('site_youtube'))
                            <a href="{{getSetting('site_youtube')}}" target="blank"><i class="fab fa-youtube"></i></a>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="footer">
                            <p>© 2023 - {{date('Y')}} {{getSetting('site_copyright')}}. Developed By <a href="https://soft-itbd.com" target="blank">SOFT-ITBD Smart IT Solution</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
