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
                        <img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>{{ __('Dashboard')}}</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/patients')}}">
                        <img src="assets/images/svg-icon/user.svg" class="img-fluid" alt="dashboard"><span>{{__('Patients')}}</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/test-status')}}">
                        <img src="assets/images/svg-icon/tables.svg" class="img-fluid" alt="dashboard"><span>{{__('Test Status')}}</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/notif')}}">
                        <img src="assets/images/svg-icon/notifications.svg" class="img-fluid" alt="dashboard"><span>{{__('Notifications')}}</span>
                    </a>

                </li>
                <li>
                    <a href="{{url('/settings')}}">
                        <img src="assets/images/svg-icon/settings.svg" class="img-fluid" alt="dashboard"><span>{{__('Settings')}}</span>
                    </a>

                </li>
                <li>
                    <a href="{{route('logout')}}">
                        @csrf
                        <img src="assets/images/svg-icon/logout.svg" class="img-fluid" alt="dashboard"><span>{{__('Logout')}}</span>
                    </a>

                </li>
            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>