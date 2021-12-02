<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <br>    <br>
        <!-- End Logobar -->
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <ul class="vertical-menu">
                <li>
                    <a href="{{url('/dashboard')}}">
                        <img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>Dashboard</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/patients')}}">
                        <img src="assets/images/svg-icon/user.svg" class="img-fluid" alt="dashboard"><span>Patients</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/notif')}}">
                        <img src="assets/images/svg-icon/notifications.svg" class="img-fluid" alt="dashboard"><span>Notifications</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/settings')}}">
                        <img src="assets/images/svg-icon/settings.svg" class="img-fluid" alt="dashboard"><span>Settings</span>
                    </a>

                </li>
                <li>
                    <a href="{{route('logout')}}">
                        @csrf
                        <img src="assets/images/svg-icon/logout.svg" class="img-fluid" alt="dashboard"><span>Logout</span>
                    </a>

                </li>
            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>