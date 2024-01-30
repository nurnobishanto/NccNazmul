
<!--Start Footer-->
<footer class="footerdez dark-footer pt50 pb80">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-sm-6 pt-3">
                <div class="ftr-brand-pp">
                    <a class="navbar-brand mb25 f-dark-logo" href="{{route('website')}}"> <img src="{{asset('uploads/'.getSetting('site_footer_dark_logo'))}}" alt="{{getSetting('site_title')}}"/></a>
                    <a class="navbar-brand mb25 f-white-logo" href="{{route('website')}}"> <img src="{{asset('uploads/'.getSetting('site_footer_dark_logo'))}}" alt="{{getSetting('site_title')}}" /></a>
                    <p>{!! getSetting('site_description') !!}</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pt-3">
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
            <div class="col-lg-2 col-sm-6 pt-3">
                <h5>Our Services</h5>
                {{ menu('our-services', 'menu.footer_meu') }}
            </div>
            <div class="col-lg-2 col-sm-6 pt-3">
                <h5>Useful Links</h5>
                {{ menu('useful-links', 'menu.footer_meu') }}
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="row fttlnks flexend">
                    <div class="col-sm-6 text-md-start text-sm-center pt-3">
                        <div class="ff-social-icons mt30">
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
                    <div class="col-sm-6 text-md-end text-sm-center pt-3">
                        <div class="footer-copyrights-">
                            <p>Developed By <a href="https://soft-itbd.com" target="blank">SOFT-ITBD Smart IT Solution</a></p>
                        </div>
                    </div>
                    <div class="col-md-12 text-md-center  pt-3">
                        <div class="footer-copyrights-">
                            <p>© 2023 - {{date('Y')}} {!! getSetting('site_copyright') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End Footer-->

