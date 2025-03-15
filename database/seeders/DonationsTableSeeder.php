<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonationsTableSeeder extends Seeder
{
    public function run()
    {
        $donations = [
            [
                'invoice' => 'INV-1001',
                'campaign_id' => 1,
                'donatur_id' => 1,
                'amount' => 500000,
                'pray' => 'Semoga sukses!',
                'bukti_dukung' => 'bukti1.jpg',
                'status' => 'success',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'invoice' => 'INV-1002',
                'campaign_id' => 2,
                'donatur_id' => 2,
                'amount' => 750000,
                'pray' => 'Semoga berkah!',
                'bukti_dukung' => 'bukti2.jpg',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'invoice' => 'INV-1003',
                'campaign_id' => 3,
                'donatur_id' => 3,
                'amount' => 1000000,
                'pray' => 'Semoga lancar!',
                'bukti_dukung' => 'bukti3.jpg',
                'status' => 'failed',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'invoice' => 'INV-1004',
                'campaign_id' => 4,
                'donatur_id' => 4,
                'amount' => 200000,
                'pray' => 'Semoga diterima!',
                'bukti_dukung' => 'bukti4.jpg',
                'status' => 'success',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'invoice' => 'INV-1005',
                'campaign_id' => 5,
                'donatur_id' => 5,
                'amount' => 300000,
                'pray' => 'Semoga berkah dan bermanfaat!',
                'bukti_dukung' => 'bukti5.jpg',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        // Tambahkan 15 data dummy untuk pending dan failed
        for ($i = 6; $i <= 20; $i++) {
            $donations[] = [
                'invoice' => 'INV-10' . $i,
                'campaign_id' => rand(1, 10),
                'donatur_id' => rand(1, 10),
                'amount' => rand(100000, 1000000),
                'pray' => 'Semoga diberikan kemudahan!',
                'bukti_dukung' => 'bukti' . $i . '.jpg',
                'status' => $i % 2 == 0 ? 'pending' : 'failed', // Gantian antara pending dan failed
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now()->subDays(rand(1, 10)),
            ];
        }

        DB::table('donations')->insert($donations);
    }
}
