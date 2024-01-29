<header class="@if(request()->routeIs('website')) nav-bg-b @else nav-bg-w @endif main-header navfix fixed-top menu-white">
    <div class="container-fluid m-pad">
        <div class="menu-header">
            <div class="dsk-logo"><a class="nav-brand" href="./">
                    <img src="{{asset('uploads/'.getSetting('site_dark_logo'))}}" alt="{{getSetting('site_title')}}" class="mega-white-logo"/>
                    <img src="{{asset('uploads/'.getSetting('site_logo'))}}" alt="{{getSetting('site_title')}}" class="mega-darks-logo"/>
                </a>
            </div>
            <div class="custom-nav" role="navigation">
                <ul class="nav-list">
                    <li><a href="#." class="menu-links">Home</a></li>
                    <li class="sbmenu rpdropdown">
                        <a href="#" class="menu-links">Portfolio</a>
                        <div class="nx-dropdown menu-dorpdown">
                            <div class="sub-menu-section">
                                <div class="sub-menu-center-block">
                                    <div class="sub-menu-column smfull">
                                        <ul>
                                            <li><a href="portfolio.html">Portfolio Grid 1</a> </li>
                                            <li><a href="portfolio-2.html">Portfolio Grid 2</a> </li>
                                            <li><a href="portfolio-block.html">Portfolio Wide Block</a> </li>
                                            <li><a href="portfolio-block-2.html">Portfolio Wide Block v2</a> </li>
                                            <li><a href="portfolio-details.html">Portfolio Details</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="sbmenu rpdropdown">
                        <a href="#" class="menu-links">Blog</a>
                        <div class="nx-dropdown menu-dorpdown">
                            <div class="sub-menu-section">
                                <div class="sub-menu-center-block">
                                    <div class="sub-menu-column smfull">
                                        <ul>
                                            <li><a href="blog-grid-1.html">Blog Grid 1</a> </li>
                                            <li><a href="blog-grid-2.html">Blog Grid 2</a> </li>
                                            <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a> </li>
                                            <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a> </li>
                                            <li><a href="blog-single.html">Blog Single</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- mobile + desktop - sidebar menu- dark mode witch and button -->
                <ul class="nav-list right-end-btn">
                    <li class="hidemobile"><a data-bs-toggle="offcanvas" href="#offcanvasExample" class="btn-round- btn-br bg-btn2"><i class="fas fa-user"></i></a></li>
                    <li class="hidedesktop darkmodeswitch"><div class="switch-wrapper">
                            <label class="switch" for="niwax"> <input type="checkbox" id="niwax"/>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </li>
                    <li class="hidedesktop"><a data-bs-toggle="offcanvas" href="#offcanvasExample" class="btn-round- btn-br bg-btn2"><i class="fas fa-user"></i></a></li>
                    <li class="navm- hidedesktop"> <a class="toggle" href="#"><span></span></a></li>
                </ul>
            </div>
        </div>

        <!--Mobile Menu-->
        <nav id="main-nav">
            <ul class="first-nav">
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Blog</a>
                    <ul>
                        <li><a href="blog-grid-1.html">Blog Grid 1</a> </li>
                        <li><a href="blog-grid-2.html">Blog Grid 2</a> </li>
                        <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a> </li>
                        <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a> </li>
                        <li><a href="blog-single.html">Blog Single</a></li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>
</header>
