<div class="rightbar">
    <!-- Start Topbar Mobile -->
    <div class="topbar-mobile">
        <div class="row align-items-center">
            <div class="col-md-12">

                <div class="mobile-togglebar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="topbar-toggle-icon">
                                <a class="topbar-toggle-hamburger" href="javascript:void();">
                                    <img src="assets/images/svg-icon/horizontal.svg" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                    <img src="assets/images/svg-icon/verticle.svg" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                </a>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="menubar">
                                <a class="menu-hamburger" href="javascript:void();">
                                    <img src="assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                    <img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Topbar -->
    <div class="topbar">
        <!-- Start row -->
        <div class="row align-items-center">
            <!-- Start col -->
            <div class="col-md-12 align-self-center">
                <div class="togglebar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="menubar">
                                <a class="menu-hamburger" href="javascript:void();">
                                    <img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                    <img src="assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-close" alt="close">
                                </a>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="searchbar">
                                <form>
                                    <div class="input-group">
                                        <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn" type="submit" id="button-addon2"><img src="assets/images/svg-icon/search.svg" class="img-fluid" alt="search"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </li>

                    </ul>
                </div>

                <li class="list-inline-item" style="float: right; margin-top: 14px;">
                    <div class="profilebar">
                        <div class="dropdown">
                            
                            <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/profile_pic.png" class="img-fluid" alt="profile"><span class="feather icon-chevron-down live-icon"></span> </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                <div class="dropdown-item">
                                    <div class="profilename">
                                        <h5>{{auth()->user()->name}}</h5>
                                    </div>
                                </div>
                                <div class="userbox">
                                    <ul class="list-unstyled mb-0">
                                        <li class="media dropdown-item">
                                            <a href="#" class="profile-icon"><img src="assets/images/svg-icon/user.svg" class="img-fluid" alt="user">My Profile</a>
                                        </li>
                                        <li class="media dropdown-item">
                                            <a href="#" class="profile-icon"><img src="assets/images/svg-icon/email.svg" class="img-fluid" alt="email">Email</a>
                                        </li>
                                        <li class="media dropdown-item">
                                            <a href="{{route('logout')}}" class="profile-icon"><img src="assets/images/svg-icon/logout.svg" class="img-fluid" alt="logout">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Topbar -->
    <!-- Start Breadcrumbbar -->

    <!-- End Breadcrumbbar -->
    @yield('rightbar-content')
    <!-- Start Footerbar -->

    <!-- End Footerbar -->
</div>