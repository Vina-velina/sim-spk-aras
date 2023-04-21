<div class="nav nav-item  navbar-nav-right ml-auto">
    <div class="dropdown main-profile-menu nav nav-item nav-link">
        <a class="profile-user d-flex" href="#">
            @if (empty(Auth::user()->foto_profil))
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_user ?? 'No Name' }}&background=5066e0&color=fff"
                    alt="Profil">
            @else
                <img src="{{ asset('storage/foto-user/' . Auth::user()->foto_profil) }}" alt="Profil">
            @endif
            <div class="p-text d-none">
                <span class="p-name font-weight-bold">{{ Auth::user()->name }}</span>
                <small
                    class="p-sub-text">{{ Auth::user()->role_user == 'super_admin' ? 'Super Admin' : 'Admin' }}</small>
            </div>
        </a>
        <div class="dropdown-menu shadow">
            <div class="main-header-profile header-img">
                <div class="main-img-user">
                    @if (empty(Auth::user()->foto_profil))
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_user ?? 'No Name' }}&background=fff&color=5066e0"
                            alt="Profil">
                    @else
                        <img src="{{ asset('storage/foto-user/' . Auth::user()->foto_profil) }}" alt="Profil">
                    @endif
                </div>
                <h6>{{ Auth::user()->name }}</h6>
                <span>{{ Auth::user()->role_user == 'super_admin' ? 'Super Admin' : 'Admin' }}</span>
            </div>
            <a class="dropdown-item" href="{{ route('admin.account.index') }}"><i class="far fa-user"></i> Profil</a>
            <a class="dropdown-item" href="{{ route('admin.account.change-password') }}"><i
                    class="fas fa-sliders-h"></i> Keamanan</a>
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
