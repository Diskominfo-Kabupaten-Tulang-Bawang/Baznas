<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DonaturService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class DonaturController extends Controller
{
    protected $donaturService;

    public function __construct(DonaturService $donaturService)
    {
        $this->donaturService = $donaturService;
    }

    /**
     * Menampilkan daftar donatur dengan pencarian
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request)
    {
        $conditions = [];

        if ($request->has('q')) {
            $conditions[] = ['name', 'like', '%' . $request->q . '%'];
        }

        $donaturs = $this->donaturService->getPaginate(10, $conditions);

        if ($request->ajax()) {
            return view('admin.donatur._data_table', compact('donaturs'));
        }

        return view('admin.donatur.index', compact('donaturs'));
    }
}
