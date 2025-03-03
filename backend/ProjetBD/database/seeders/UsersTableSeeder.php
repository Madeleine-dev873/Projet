<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Membre 1',
                'email' => 'membre1@dge.com',
                'password' => Hash::make('passer'),
                'role' => 'DGE',
            ],
            [
                'name' => 'Membre 2',
                'email' => 'membre2@dge.com',
                'password' => Hash::make('passer'),
                'role' => 'DGE',
            ],
            [
                'name' => 'Membre 3',
                'email' => 'membre3@dge.com',
                'password' => Hash::make('passer'),
                'role' => 'DGE',
            ],
            [
                'name' => 'Membre 4',
                'email' => 'membre4@dge.com',
                'password' => Hash::make('passer'),
                'role' => 'DGE',
            ],
        ]);
    }
}
