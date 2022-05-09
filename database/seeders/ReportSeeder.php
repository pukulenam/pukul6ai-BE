<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->insert([
            'id' => 1,
            'project_id' => 1,
            'description' => "template literal",
            'start' => '2022-01-12 00:00:00',
            'end' => '2022-12-12 00:00:00',
            'admin' => '1',
            'attachment' => 'https://awsimages.detik.net.id/community/media/visual/2019/09/25/fe853eb5-e5f8-453d-915e-63c71ce0cdc6.jpeg?w=750&q=90',
            'created_at' => '2002-12-12 00:00:00',
            'updated_at' => '2002-12-12 00:00:00'
        ]);
    }
}
