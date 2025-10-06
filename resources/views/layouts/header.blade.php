<nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="navbar-brand-wrapper">
            <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
        </div>
        <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">Welcome back, {{ Auth::user()->name }}</h4>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
                <h4 class="mb-0 font-weight-bold d-none d-xl-block">{{ \Carbon\Carbon::now()->format('l, d M Y h:i A') }}</h4>
            </li>
            <li class="nav-item dropdown me-1">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="mdi mdi-calendar mx-0"></i>
                    <span class="count bg-info">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                New product launch
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown me-2">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="mdi mdi-bell-outline mx-0"></i>
                    @if($unreadCount > 0)
                    <span class="count bg-danger">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" style="width:300px;">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                    @forelse($unreadNotifications as $notification)
                    <a class="dropdown-item preview-item" href="{{ route('notifications.index') }}">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="mdi mdi-information mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">{{ $notification->data['message'] ?? 'No message' }}</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                    @empty
                    <span class="dropdown-item">No new notifications.</span>
                    @endforelse
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-center text-primary" href="{{ route('notifications.index') }}">
                        View All
                    </a>
                </div>
            </li>


        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center">
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Here..." aria-label="search" aria-describedby="search">
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                    <img src="{{ asset('assets/images/faces/face5.jpg') }}" alt="profile" />
                    <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                        <i class="mdi mdi-settings text-primary"></i>
                        Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout')}}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link icon-link">
                    <i class="mdi mdi-plus-circle-outline"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link icon-link">
                    <i class="mdi mdi-web"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link icon-link">
                    <i class="mdi mdi-clock-outline"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>