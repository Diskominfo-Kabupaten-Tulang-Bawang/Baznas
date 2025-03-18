<?php

namespace App\Services;

use App\Models\Donatur;

class DonaturService extends BaseService
{
    public function __construct(Donatur $donatur)
    {
        parent::__construct($donatur);
    }

    public function search($keyword, $perPage = 10)
    {
        return Donatur::where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('email', 'LIKE', "%{$keyword}%")
            ->paginate($perPage);
    }
}
