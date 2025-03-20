<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'devkh',
            'email'     => 'devkh@gmail.com',
            'password'  => Hash::make('devkh123'),
        ]);
        DB::table('muzakkis')->insert([
            'name'      => 'Muzakki',
            'email'     => 'muzakki@gmail.com',
            'password'  => Hash::make('devkh123'),
        ]);
        // DB::table('donaturs')->insert([
        //     'name'      => 'Muzakki',
        //     'email'     => 'muzakki@gmail.com',
        //     'password'  => Hash::make('devkh123'),
        // ]);
    }
}
