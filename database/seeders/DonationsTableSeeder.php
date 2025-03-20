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
                'category_id' => 1,
                'muzakki_id' => 1,
                'amount' => 500000,
                'pray' => 'Semoga sukses!',
                'struk' => 'bukti1.jpg',
                'status' => 'success',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'invoice' => 'INV-1002',
                'category_id' => 2,
                'muzakki_id' => 2,
                'amount' => 750000,
                'pray' => 'Semoga berkah!',
                'struk' => 'bukti2.jpg',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'invoice' => 'INV-1003',
                'category_id' => 3,
                'muzakki_id' => 3,
                'amount' => 1000000,
                'pray' => 'Semoga lancar!',
                'struk' => 'bukti3.jpg',
                'status' => 'failed',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'invoice' => 'INV-1004',
                'category_id' => 4,
                'muzakki_id' => 4,
                'amount' => 200000,
                'pray' => 'Semoga diterima!',
                'struk' => 'bukti4.jpg',
                'status' => 'success',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'invoice' => 'INV-1005',
                'category_id' => 5,
                'muzakki_id' => 5,
                'amount' => 300000,
                'pray' => 'Semoga berkah dan bermanfaat!',
                'struk' => 'bukti5.jpg',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        // Tambahkan 15 data dummy untuk pending dan failed
        for ($i = 6; $i <= 20; $i++) {
            $donations[] = [
                'invoice' => 'INV-10' . $i,
                'category_id' => rand(1, 10),
                'muzakki_id' => rand(1, 10),
                'amount' => rand(100000, 1000000),
                'pray' => 'Semoga diberikan kemudahan!',
                'struk' => 'bukti' . $i . '.jpg',
                'status' => $i % 2 == 0 ? 'pending' : 'failed', // Gantian antara pending dan failed
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now()->subDays(rand(1, 10)),
            ];
        }

        DB::table('zakats')->insert($donations);
    }
}
