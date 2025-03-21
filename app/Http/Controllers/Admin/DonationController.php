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
    public function index(Request $request)
    {
        $donations = $this->donationService->getPaginate(10);
        $total = $this->donationService->sum('amount', [['status', '=', 'success']]);
        $allDonations = $this->donationService->getPaginate(10);


        // if ($request->ajax()) {
        //     return response()->json([
        //         'html' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
        //         'pagination' => $allDonations->links('pagination::bootstrap-4')->toHtml()
        //     ]);
        // }

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
                'pagination' => $allDonations->links('pagination::bootstrap-4')->toHtml()
            ]);
        }

        // if ($request->ajax()) {
        //     return response()->json([
        //         'html' => view('admin.donation._data_table', compact('donations', 'total', 'allDonations'))->render(),
        //     ]);
        // }

        return view('admin.donation.index', compact('donations', 'total', 'allDonations'));
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

    /**
     * Memperbarui donasi (AJAX support).
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    // public function update(Request $request, $id): JsonResponse
    // {
    //     $request->validate([

    //         'status' => 'required|string',
    //     ]);

    //     $donation = $this->donationService->find($id);

    //     if (!$donation) {
    //         return response()->json(['error' => 'Donation not found'], 404);
    //     }

    //     $this->donationService->update($donation, $request->all());

    //     return response()->json(['success' => 'Donation updated successfully']);
    // }


    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:success,failed',
            'alasan_penolakan' => $request->status == 'failed' ? 'required|string' : 'nullable|string',
        ]);

        $donation =  $this->donationService->find($id);
        $donation->status = $request->status;
        $donation->alasan_penolakan = $request->status == 'failed' ? $request->alasan_penolakan : null;
        $donation->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
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
