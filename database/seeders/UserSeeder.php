<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Mrs',
                'first_name' => 'Fenni',
                'last_name' => 'Iren',
                'phone' => '082232389408',
                'email' => 'fenniirene04@gmail.com',
                'password' => bcrypt('admin123'),
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Rizky',
                'last_name' => 'Fauzia',
                'phone' => '087788715681',
                'email' => 'kamairafirst@gmail.com',
                'password' => bcrypt('admin123'),
            ]
        ];

        User::insert($data);
    }
}
