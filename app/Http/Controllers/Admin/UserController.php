<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Services\User\UserCommandServices;
use App\Services\User\UserDatatableServices;
use App\Services\User\UserQueryServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userQueryServices;

    protected $userCommandServices;

    protected $userDatatableServices;

    public function __construct(
        UserQueryServices $userQueryServices,
        UserDatatableServices $userDatatableServices,
        UserCommandServices $userCommandServices
    ) {
        $this->userQueryServices = $userQueryServices;
        $this->userDatatableServices = $userDatatableServices;
        $this->userCommandServices = $userCommandServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.user.index');
    }

    public function create()
    {
        return view('admin.pages.master-data.user.create');
    }

    public function store(UserStoreRequest $request)
    {
        dd($request->all());
    }

    public function datatable(Request $request)
    {
        return $this->userDatatableServices->datatable($request);
    }
}
