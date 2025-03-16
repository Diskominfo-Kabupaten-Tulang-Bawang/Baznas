<?php

namespace App\Services;

use App\Models\Donatur;

class DonaturService extends BaseService
{
    public function __construct(Donatur $donatur)
    {
        parent::__construct($donatur);
    }
}
