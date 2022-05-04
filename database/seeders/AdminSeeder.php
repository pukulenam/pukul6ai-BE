<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::insert(
            [
                [
                    'id' => 1,
                    'full_name' => "Vincentius Arnold Fridolin",
                    'username' => 'vincentiusar',
                    'email' => 'vincentiusar@gmail.com',
                    'password' => Hash::make('doomhammer'),
                    'role' => 'admin',
                    'image' => 'Tius.jpg',
                    'description' => "Fullstack Dev., Competitve Programmer, Data Engineer",
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ], 
                [
                    'id' => 2,
                    'full_name' => "Wahyu Hauzan Rafi",
                    'username' => 'wahyuh',
                    'email' => 'wahyu@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Wahyu.JPG',
                    'description' => 'UI/UX Engineer, Web Specialist, Technical Writter',
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 3,
                    'full_name' => "Farel Arden",
                    'username' => 'farel',
                    'email' => 'farel@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Farel.jpg',
                    'description' => 'Cloud Engineer, Google Certified AI Engineer',
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 4,
                    'full_name' => "Abiyyu Didar Haq",
                    'username' => 'abiyyu',
                    'email' => 'abiyyu@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Abi.jpg',
                    'description' => 'Junior Doctor, Medical Data Specialist, Academic Writer, CPO of PukulEnam.id',
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 5,
                    'full_name' => "Christopher Alvin Buana",
                    'username' => 'christopher',
                    'email' => 'christopher@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Alvin.jpg',
                    'description' => 'Google Certified AI Engineer, Web Specialist, UI/UX Engineer, Cloud Engineer',
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 6,
                    'full_name' => "Iga Narendra",
                    'username' => 'iga',
                    'email' => 'iga@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Iga.jpeg',
                    'description' => 'CEO of PukulEnam.AI, Academic Writer, Telco Engineer, Google AI Engineer',
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 7,
                    'full_name' => "Bagja 9102 Kurniawan",
                    'username' => 'bagja',
                    'email' => 'bagja@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Bagja.jpg',
                    'description' => "Google Certified AI Engineer, Analyst, \nData Specialist",
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 8,
                    'full_name' => "M. Naufal Syawali \"Wallski\" A.",
                    'username' => 'naufal',
                    'email' => 'naufal@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Syawal.jpg',
                    'description' => "Lead AI Engineer, Technical Writer, Academic Writer",
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 9,
                    'full_name' => "Yowan N. Suparta",
                    'username' => 'yowan',
                    'email' => 'yowan@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Yowan.jpg',
                    'description' => "Project Manager, Academic Writer, Domain Specialist, Telco Engineer",
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
                [
                    'id' => 10,
                    'full_name' => "Nym. Satiya Nanjaya S.",
                    'username' => 'satiya',
                    'email' => 'satiya@gmail.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'image' => 'Evan.jpg',
                    'description' => "Cloud Specialist, Junior Doctor, Web Specialist, CTO Of PukulEnam.id",
                    'created_at' => '2002-12-12 00:00:00',
                    'updated_at' => '2002-12-12 00:00:00'
                ],
            ]
        );
    }
}
