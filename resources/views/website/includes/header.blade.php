<style>
    .top-header .left-side .ff-social-icons a {
        padding:0px;
        line-height:25px;
    }
   
    .top-header .right-side .ff-social-icons a {
        font-size:25px;
        padding:0px 0px 0px 10px;
    }
</style>
<div class="bg-dark text-light top-header">
    <div class="container py-2">
        <div class="row g-0 align-items-center">
            <div class="left-side col-sm-8 col-9">
                <div class="ff-social-icons">
                    <div class="row ">
                        <div class="col-lg-5 col-md-7 col-12">
                            <a  href="mailto:{{getSetting('site_email')}}" target="blank"><i class="fa fa-envelope"></i> {{getSetting('site_email')}}</a>
                        </div>
                        <div class="col-lg-7 col-md-5 col-12">
                            <a href="tel:{{getSetting('site_phone')}}" target="blank"><i class="fa fa-phone-alt"></i> {{getSetting('site_phone')}}</a>
                        </div>
                    </div>
                    
                   
                </div> 
            </div>
            <div class="right-side col-sm-4 col-3">
                <div class="text-end ff-social-icons">
                    @if(getSetting('site_facebook'))
                    <a href="{{getSetting('site_facebook')}}" target="blank"><i class="fab fa-facebook"></i></a>
                    @endif
                    @if(getSetting('site_youtube'))
                        <a href="{{getSetting('site_youtube')}}" target="blank"><i class="fab fa-youtube"></i></a>
                    @endif
                </div> 
            </div>
        </div>

    </div>
</div>
<!-- nav-bg-b fixed-top -->
<header class="@if(request()->routeIs('website') && !request()->query('search')) nav-bg-w @else nav-bg-w @endif main-header sticky-top navfix menu-white">
    
    <div class="container m-pad">
        <div class="menu-header">
            <div class="dsk-logo"><a class="nav-brand" href="{{route('website')}}">

                    <img src="{{asset('uploads/'.getSetting('site_dark_logo'))}}" alt="{{getSetting('site_title')}}" class="mega-white-logo"/>
                    <img src="{{asset('uploads/'.getSetting('site_logo'))}}" alt="{{getSetting('site_title')}}" class="mega-darks-logo"/>
                </a>
            </div>
            <div class="custom-nav" role="navigation">
                {{ menu('header', 'menu.headermenu') }}

                <!-- mobile + desktop - sidebar menu- dark mode witch and button -->
                <ul class="nav-list right-end-btn">
                    <!--@if(getSetting('site_facebook'))-->
                    <!--    <li class="hidemobile"><a  href="{{getSetting('site_facebook')}}" class="btn-round- btn-br bg-btn2"><i class="fab fa-facebook"></i></a></li>-->
                    <!--    <li class="hidedesktop"><a  href="{{getSetting('site_facebook')}}" class="btn-round- btn-br bg-btn2"><i class="fab fa-facebook"></i></a></li>-->
                    <!--@endif-->
                    <!--@if(getSetting('site_youtube'))-->
                    <!--    <li class="hidemobile"><a  href="{{getSetting('site_youtube')}}" class="btn-round- btn-br bg-btn2"><i class="fab fa-youtube"></i></a></li>-->
                    <!--    <li class="hidedesktop"><a  href="{{getSetting('site_youtube')}}" class="btn-round- btn-br bg-btn2"><i class="fab fa-youtube"></i></a></li>-->
                    <!--@endif-->
                    <li><a  href="{{ route('profile') }}" class=" btn-br bg-btn2">login</a></li>
                    <!--<li class="hidemobile"><a  href="{{ route('profile') }}" class="btn-round- btn-br bg-btn2"><i class="fas fa-user"></i></a></li>-->
                    <li class="hidedesktop darkmodeswitch"><div class="switch-wrapper">
                            <label class="switch" for="niwax"> <input type="checkbox" id="niwax"/>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </li>
                    <!--<li class="hidedesktop"><a  href="{{ route('profile') }}" class="btn-round- btn-br bg-btn2"><i class="fas fa-user"></i></a></li>-->
                    <li class="navm- hidedesktop"> <a class="toggle" href="#"><span></span></a></li>
                </ul>
            </div>
        </div>

        <!--Mobile Menu-->
        <nav id="main-nav">
            {{ menu('header', 'menu.mobile_side_menu') }}
        </nav>
    </div>
</header>
