<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $donations = Donation::paginate(10);
        $total = Donation::sum('amount');
        $allDonations = Donation::all();
        return view('admin.donation.index', compact('donations', 'total', 'allDonations'));
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {
        $this->validate($request, [
            'date_from'  => 'required',
            'date_to'    => 'required',
        ]);

        $date_from  = $request->date_from;
        $date_to    = $request->date_to;

        // Get data donation by range date
        $donations = Donation::where('status', 'success')
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to)
            ->get();

        // Get total donation by range date
        $total = Donation::where('status', 'success')
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to)
            ->sum('amount');

        // Get all donations
        $allDonations = Donation::all();

        return view('admin.donation.index', compact('donations', 'total', 'allDonations'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $donation = Donation::findOrFail($id);
        $donation->update($request->all());

        return redirect()->route('admin.donation.index')
            ->with('success', 'Donation updated successfully');
    }


    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $donation = Donation::find($id);

        if (!$donation) {
            return response()->json(['error' => 'Donation not found'], 404);
        }

        $donation->delete();

        return response()->json(['success' => 'Donation deleted successfully']);
    }


}
