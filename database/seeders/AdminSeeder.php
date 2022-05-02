<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'full_name' => "Vincentius Arnold Fridolin",
            'username' => 'vincentiusar',
            'email' => 'vincentiusar@gmail.com',
            'password' => Hash::make('doomhammer'),
            'role' => 'admin',
            'image' => 'https://awsimages.detik.net.id/community/media/visual/2019/09/25/fe853eb5-e5f8-453d-915e-63c71ce0cdc6.jpeg?w=750&q=90',      
            'created_at' => '2002-12-12 00:00:00',
            'updated_at' => '2002-12-12 00:00:00'
        ]);
    }
}
