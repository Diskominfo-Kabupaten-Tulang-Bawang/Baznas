<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\DonaturService;
use App\Services\CampaignService;
use App\Services\DonationService;
use App\Services\CategoryService;
use App\Services\SliderService;

class SearchService
{
    protected $donaturService;
    protected $campaignService;
    protected $donationService;
    protected $categoryService;
    protected $sliderService;

    public function __construct(
        DonaturService $donaturService,
        CampaignService $campaignService,
        DonationService $donationService,
        CategoryService $categoryService,
        SliderService $sliderService
    ) {
        $this->donaturService = $donaturService;
        $this->campaignService = $campaignService;
        $this->donationService = $donationService;
        $this->categoryService = $categoryService;
        $this->sliderService = $sliderService;
    }

    public function search($type, $keyword, $perPage = 10)
    {
        return match ($type) {
            'donatur' => $this->donaturService->search($keyword, $perPage),
            'campaign' => $this->campaignService->search($keyword, $perPage),
            'donation' => $this->donationService->search($keyword, $perPage),
            'category' => $this->categoryService->search($keyword, $perPage),
            'slider' => $this->sliderService->search($keyword, $perPage),
            default => collect([]),
        };
    }
}
