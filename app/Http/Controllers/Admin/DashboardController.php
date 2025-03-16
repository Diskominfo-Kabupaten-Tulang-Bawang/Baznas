<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DonaturService;
use App\Services\CampaignService;
use App\Services\DonationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $donaturService;
    protected $campaignService;
    protected $donationService;

    public function __construct(
        DonaturService $donaturService,
        CampaignService $campaignService,
        DonationService $donationService
    ) {
        $this->donaturService = $donaturService;
        $this->campaignService = $campaignService;
        $this->donationService = $donationService;
    }

    public function index(Request $request)
    {
        $donaturs = $this->donaturService->count();
        $campaigns = $this->campaignService->count();
        $donations = $this->donationService->sum('amount', [['status', '=', 'success']]);


        $allDonations = $this->donationService->getPaginate(10, [['status', 'IN', ['pending', 'failed']]]);

        if ($request->ajax()) {
            return view('admin.dashboard._donation_table', compact('allDonations'));
        }

        return view('admin.dashboard.index', compact('donaturs', 'campaigns', 'donations', 'allDonations'));
    }

}
