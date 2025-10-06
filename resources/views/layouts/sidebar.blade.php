<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item sidebar-category">
            <p>Navigation</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-view-quilt menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
            <p>Components</p>
            <span></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="mdi mdi-view-headline menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.index') }}">
                <i class="mdi mdi-chart-pie menu-icon"></i>
                <span class="menu-title">Staff</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('shifts.index') }}">
                <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
                <span class="menu-title">Shifts</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('attendances.index') }}">
                <i class="mdi mdi-calendar-clock menu-icon"></i>
                <span class="menu-title">Attendance</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('leave-requests.index') }}">
                <i class="mdi mdi-calendar-remove menu-icon"></i>
                <span class="menu-title">Leave</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('airlines.index') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Airlines</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('flights.index') }}">
                <i class="mdi mdi-emoticon menu-icon"></i>
                <span class="menu-title">Flights</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('flights.history') }}">
                <i class="mdi mdi-emoticon menu-icon"></i>
                <span class="menu-title">Flight History</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('passengers.index') }}">
                <i class="mdi mdi-emoticon menu-icon"></i>
                <span class="menu-title">Passengers</span>
            </a>
        </li>
        {{-- Customer Support Tickets --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('support-tickets.index') }}">
                <i class="mdi mdi-headset menu-icon"></i>
                <span class="menu-title">Support Tickets</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('baggages.index') }}">
                <i class="mdi mdi-emoticon menu-icon"></i>
                <span class="menu-title">Baggages</span>
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout')}}" class="btn bg-danger btn-sm menu-title" onclick="event.preventDefault(); this.closest('form').submit();">
                    Log out
                </a>
            </form>
        </li>

    </ul>
</nav>