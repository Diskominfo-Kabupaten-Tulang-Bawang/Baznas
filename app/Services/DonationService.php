<?php

namespace App\Services;

use App\Models\Donation;

class DonationService extends BaseService
{
    public function __construct(Donation $donation)
    {
        parent::__construct($donation);
    }

}
