<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Debitur\DebiturCommandServices;
use App\Services\Debitur\DebiturDatatableServices;
use App\Services\Debitur\DebiturQueryServices;
use Illuminate\Http\Request;

class DebiturController extends Controller
{
    protected $debiturCommandServices;

    protected $debiturDatatableServices;

    protected $debiturQueryServices;

    public function __construct(
        DebiturQueryServices $debiturQueryServices,
        DebiturDatatableServices $debiturDatatableServices,
        DebiturCommandServices $debiturCommandServices
    ) {
        $this->debiturCommandServices = $debiturCommandServices;
        $this->debiturDatatableServices = $debiturDatatableServices;
        $this->debiturQueryServices = $debiturQueryServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.debitur.index');
    }

    public function datatable(Request $request)
    {
        return $this->debiturDatatableServices->datatable($request);
    }
}
