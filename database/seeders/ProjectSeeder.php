<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'id' => 1,
            'userid' => 69,
            'adminid' => 1,
            'name' => "Help JS",
            'progress' => 0,
            'start' => "2002-12-12 00:00:00",
            'end' => "2002-12-12 00:00:00",
            'created_at' => '2002-12-12 00:00:00',
            'updated_at' => '2002-12-12 00:00:00'
        ]);
    }
}
