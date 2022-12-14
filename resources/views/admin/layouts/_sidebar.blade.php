<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-dark active" href="{{ route('admin.home') }}"><img
                src="{{ config('general.icon-text-white') }}" class="main-logo dark-theme" alt="logo"></a>
        <div class="app-sidebar__toggle" data-toggle="sidebar">
            <a class="open-toggle" href="#"><i class="header-icon fe fe-chevron-left"></i></a>
            <a class="close-toggle" href="#"><i class="header-icon fe fe-chevron-right"></i></a>
        </div>
    </div>
    <div class="main-sidemenu sidebar-scroll">
        @include('admin.layouts.menu._sidebar_menu')
        <div class="app-sidefooter">
            <a class="side-menu__item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"
                    height="24" viewBox="0 0 24 24" width="24">
                    <g>
                        <rect fill="none" height="24" width="24" />
                    </g>
                    <g>
                        <path
                            d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z" />
                    </g>
                </svg> <span class="side-menu__label">Logout</span>
            </a>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</aside>
