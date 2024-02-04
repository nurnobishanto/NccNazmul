<header class="@if(request()->routeIs('website') && !request()->query('search')) nav-bg-b @else nav-bg-w @endif main-header navfix fixed-top menu-white">
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
                    <li class="hidemobile"><a  href="{{ route('profile') }}" class="btn-round- btn-br bg-btn2"><i class="fas fa-user"></i></a></li>
                    <li class="hidedesktop darkmodeswitch"><div class="switch-wrapper">
                            <label class="switch" for="niwax"> <input type="checkbox" id="niwax"/>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </li>
                    <li class="hidedesktop"><a  href="{{ route('profile') }}" class="btn-round- btn-br bg-btn2"><i class="fas fa-user"></i></a></li>
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
