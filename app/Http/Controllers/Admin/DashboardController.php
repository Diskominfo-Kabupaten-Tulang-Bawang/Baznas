<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donatur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * index
     *
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Count the number of donaturs
        $donaturs = Donatur::count();

        // Count the number of campaigns
        $campaigns = Campaign::count();

        // Sum the amount of successful donations
        $donations = Donation::where('status', 'success')->sum('amount');

        // Retrieve all donations with pagination of 10
        $allDonations = Donation::whereIn('status', ['pending', 'failed'])->paginate(10);

        // Return the view with the retrieved data
        return view('admin.dashboard.index', compact('donaturs', 'campaigns', 'donations', 'allDonations'));
    }

  }
