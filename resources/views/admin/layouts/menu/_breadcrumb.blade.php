<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <h4 class="content-title mb-2">Selamat Datang {{ Auth::user()->name }} !</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ $page }}</a></li>
                @if (isset($active))
                    <li class="breadcrumb-item active" aria-current="page">{{ $active }}</li>
                @endif

            </ol>
        </nav>
    </div>
</div>
