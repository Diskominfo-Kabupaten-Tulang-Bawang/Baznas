<?php

namespace App\Services;

use App\Models\Donation;

class DonationService extends BaseService
{
    public function __construct(Donation $donation)
    {
        parent::__construct($donation);
    }

    public function search($keyword, $perPage = 10)
    {
        return Donation::where('id', 'LIKE', "%{$keyword}%")
            ->orWhere('status', 'LIKE', "%{$keyword}%")
            ->paginate($perPage);
    }

}
