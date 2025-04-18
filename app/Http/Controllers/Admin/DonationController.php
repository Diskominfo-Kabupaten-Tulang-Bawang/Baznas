<?php

namespace App\Http\Controllers\Admin;

use App\Services\DonationService;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
class DonationController extends Controller
{
    protected $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    /**
     * Menampilkan daftar donasi (AJAX support).
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    // public function index(Request $request)
    // {
    //     $donations = $this->donationService->getPaginate(10);
    //     $total = $this->donationService->sum('amount', [['status', '=', 'success']]);
    //     $allDonations = $this->donationService->getPaginate(10);


    //     // if ($request->ajax()) {
    //     //     return response()->json([
    //     //         'html' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
    //     //         'pagination' => $allDonations->links('pagination::bootstrap-4')->toHtml()
    //     //     ]);
    //     // }

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'table' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
    //             'pagination' => $allDonations->links('pagination::bootstrap-4')->toHtml()
    //         ]);
    //     }

    //     // if ($request->ajax()) {
    //     //     return response()->json([
    //     //         'html' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
    //     //     ]);
    //     // }

    //     return view('admin.donation.index', compact('donations', 'total', 'allDonations'));
    // }

    public function index(Request $request)
    {
        $donations = $this->donationService->getPaginate(10);
        $total = $this->donationService->sum('amount', [['status', '=', 'success']]);
        $allDonations = $this->donationService->getPaginate(10);
        $categories = \App\Models\Category::all(); // Ambil semua kategori

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
                'pagination' => $allDonations->links('pagination::bootstrap-4')->toHtml()
            ]);
        }

        return view('admin.donation.index', compact('donations', 'total', 'allDonations', 'categories'));
    }


    /**
     * Menyaring donasi berdasarkan rentang tanggal (AJAX support).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        $request->validate([
            'date_from'  => 'required|date',
            'date_to'    => 'required|date|after_or_equal:date_from',
        ]);

        $conditions = [
            ['status', '=', 'success'],
            ['created_at', '>=', $request->date_from . ' 00:00:00'],
            ['created_at', '<=', $request->date_to . ' 23:59:59'],
        ];

        $donations = $this->donationService->getPaginate(10, $conditions);
        $total = $this->donationService->sum('amount', $conditions);

        return response()->json([
            'table' => view('admin.donation._data_table', compact('donations', 'total'))->render()
        ]);


    }

    public function filterCategory(Request $request): JsonResponse
    {
        $request->validate([
            'category' => 'nullable|exists:categories,id',
        ]);

        if ($request->filled('category')) {
            $conditions[] = ['category_id', '=', $request->category];
        }

        $donations = $this->donationService->getPaginate(10, $conditions);
        $total = $this->donationService->sum('amount', $conditions);

        return response()->json([
            'table' => view('admin.donation._data_table', compact('donations', 'total'))->render(),
            'pagination' => $donations->links('pagination::bootstrap-4')->render(),
        ]);
    }



    /**
     * Menghapus donasi (AJAX support).
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
{
    $donation = $this->donationService->find($id);

    if (!$donation) {
        return response()->json(['message' => 'Donasi tidak ditemukan'], 404);
    }

    try {
        $donation->delete();
        return response()->json(['message' => 'Donasi berhasil dihapus'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan saat menghapus donasi', 'error' => $e->getMessage()], 500);
    }
}

}
