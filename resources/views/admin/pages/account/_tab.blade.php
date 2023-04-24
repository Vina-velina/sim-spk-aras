<div class="row pb-3">
    <div class="col-md-6 pt-2">
        <a href="{{ route('admin.account.index') }}">
            <button
                class="btn btn-outline-primary btn-with-icon btn-block btn-rounded {{ Route::is('admin.account.index') ? 'btn-primary text-white' : 'btn-white' }}">
                <i class="fe fe-user"></i> Profil
            </button>
        </a>
    </div>
    <div class="col-md-6 pt-2">
        <a href="{{ route('admin.account.change-password') }}">
            <button
                class="btn btn-outline-primary btn-with-icon btn-block btn-rounded {{ Route::is('admin.account.change-password') ? 'btn-primary text-white' : 'btn-white' }}">
                <i class="fe fe-lock"></i> Kemananan
            </button>
        </a>
    </div>
</div>
