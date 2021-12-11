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



                    </ul>
                </div>
                <li class="list-inline-item" style="float: right; margin-top: 14px;">
                    
                    <div class="profilebar">
                        <div class="dropdown">
                            <div class="profilename">
                                <h5>{{auth()->user()->name}}</h5>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                <div class="dropdown-item">

                                </div>

                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-inline-item" style="float: right; margin-top: 10px; margin-right:10px;">
                    
                    <div class="profilebar">
                    
                        <select id="lang" onchange="chnge()" style="background-color: lightgrey;" class="select2-single form-control" required>
                            <optgroup>
                                <option disabled hidden selected>{{Config::get('app.locale')}}</option>
                                <option  value="en">En</option>
                                <option  value="fr">Fr</option>

                            </optgroup>

                        </select>
                    
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
<script>
    function chnge() {
        var x = document.getElementById("lang").value;
        window.location.href = "{{url('/set')}}" + "/" + x;
    }
</script>