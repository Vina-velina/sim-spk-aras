<div class="nav nav-item  navbar-nav-right ml-auto">
    <div class="dropdown nav-item main-header-notification">
        <a class="new nav-link" href="#"><i class="fe fe-bell"></i><span class=" pulse"></span></a>
        <div class="dropdown-menu shadow">
            <div class="menu-header-content bg-primary text-left d-flex">
                <div class="">
                    <h6 class="menu-header-title text-white mb-0">7 new Notifications</h6>
                </div>
                <div class="my-auto ml-auto">
                    <span class="badge badge-pill badge-warning float-right">Mark All Read</span>
                </div>
            </div>
            <div class="main-notification-list Notification-scroll ps">
                <a class="d-flex p-3 border-bottom" href="#">
                    <div class="notifyimg bg-success-transparent">
                        <i class="la la-shopping-basket text-success"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">New Order Received</h5>
                        <div class="notification-subtext">1 hour ago</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
                <a class="d-flex p-3 border-bottom" href="#">
                    <div class="notifyimg bg-danger-transparent">
                        <i class="la la-user-check text-danger"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">22 verified registrations</h5>
                        <div class="notification-subtext">2 hour ago</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
                <a class="d-flex p-3 border-bottom" href="#">
                    <div class="notifyimg bg-primary-transparent">
                        <i class="la la-check-circle text-primary"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">Project has been approved</h5>
                        <div class="notification-subtext">4 hour ago</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
                <a class="d-flex p-3 border-bottom" href="#">
                    <div class="notifyimg bg-pink-transparent">
                        <i class="la la-file-alt text-pink"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">New files available</h5>
                        <div class="notification-subtext">10 hour ago</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
                <a class="d-flex p-3 border-bottom" href="#">
                    <div class="notifyimg bg-warning-transparent">
                        <i class="la la-envelope-open text-warning"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">New review received</h5>
                        <div class="notification-subtext">1 day ago</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
                <a class="d-flex p-3" href="#">
                    <div class="notifyimg bg-purple-transparent">
                        <i class="la la-gem text-purple"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">Updates Available</h5>
                        <div class="notification-subtext">2 days ago</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
                <div class="dropdown-footer">
                    <a href="#">VIEW ALL</a>
                </div>
            </div>
        </div>
    </div>
    <div class="dropdown main-profile-menu nav nav-item nav-link">
        <a class="profile-user d-flex" href="#">
            @if (empty(Auth::user()->foto_profil))
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_user ?? 'No Name' }}&background=5066e0&color=fff"
                    alt="Profil">
            @else
                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profil">
            @endif
            <div class="p-text d-none">
                <span class="p-name font-weight-bold">Mintrona Pechon</span>
                <small class="p-sub-text">Premium Member</small>
            </div>
        </a>
        <div class="dropdown-menu shadow">
            <div class="main-header-profile header-img">
                <div class="main-img-user">
                    @if (empty(Auth::user()->foto_profil))
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_user ?? 'No Name' }}&background=fff&color=5066e0"
                            alt="Profil">
                    @else
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profil">
                    @endif
                </div>
                <h6>Mintrona Pechon</h6><span>Premium Member</span>
            </div>
            <a class="dropdown-item" href="#"><i class="far fa-user"></i> Profil</a>
            <a class="dropdown-item" href="#"><i class="fas fa-sliders-h"></i> Keamanan</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
      document.getElementById('logout-form').submit();"><i
                    class="fas fa-sign-out-alt"></i> Keluar</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
