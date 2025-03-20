<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DonaturService;
use App\Services\CampaignService;
use App\Services\DonationService;
use App\Services\UserService;
use App\Models\Donatur;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use App\Models\Zakat;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DonaturService::class, function ($app) {
            return new DonaturService($app->make(Donatur::class));
        });

        $this->app->bind(CampaignService::class, function ($app) {
            return new CampaignService($app->make(Campaign::class));
        });

        $this->app->bind(DonationService::class, function ($app) {
            return new DonationService($app->make(Zakat::class));
        });

        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(User::class));
        });


    }

    public function boot()
    {
        //
    }
}
