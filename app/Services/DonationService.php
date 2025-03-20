<?php

namespace App\Services;

use App\Models\Zakat;

class DonationService extends BaseService
{
    public function __construct(Zakat $donation)
    {
        parent::__construct($donation);
    }

    public function search($keyword, $perPage = 10)
    {
        return Zakat::where('id', 'LIKE', "%{$keyword}%")
            ->orWhere('status', 'LIKE', "%{$keyword}%")
            ->paginate($perPage);
    }

}
