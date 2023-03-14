<ul class="side-menu">
    <li>
        <h3>General</h3>
    </li>
    <li class="slide">
        <a class="side-menu__item {{ Route::is('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">
            <div class="side-angle1"></div>
            <div class="side-angle2"></div>
            <div class="side-arrow"></div>
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                width="24">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
            </svg>
            <span class="side-menu__label">Dashboard</span>
        </a>
    </li>
    <li>
        <h3>Main</h3>
    </li>
    <li class="slide">
        <a class="side-menu__item {{ Route::is('admin.master-data.*') ? 'active' : '' }}" data-toggle="slide"
            href="#">
            <div class="side-angle1"></div>
            <div class="side-angle2"></div>
            <div class="side-arrow"></div>
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                width="24">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z"
                    opacity=".3" />
                <path
                    d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z" />
            </svg>
            <span class="side-menu__label">Master Data</span><i class="angle fe fe-chevron-right"></i>
        </a>
        <ul class="slide-menu">
            <li>
                <a class="sub-side-menu__item" href="{{ route('admin.master-data.user.index') }}"><span
                        class="sub-side-menu__label {{ Route::is('admin.master-data.user.*') ? 'text-white text-bold' : '' }}">Data
                        User</span></a>
            </li>
            <li>
                <a class="sub-side-menu__item" href="{{ route('admin.master-data.debitur.index') }}"><span
                        class="sub-side-menu__label {{ Route::is('admin.master-data.debitur.*') ? 'text-white text-bold' : '' }}">Data
                        Debitur</span></a>
            </li>
            <li>
                <a class="sub-side-menu__item" href="#"><span class="sub-side-menu__label">Data Periode</span></a>
            </li>
            <li>
                <a class="sub-side-menu__item" href="#"><span class="sub-side-menu__label">Data
                        Kriteria</span></a>
            </li>
        </ul>
    </li>
</ul>
