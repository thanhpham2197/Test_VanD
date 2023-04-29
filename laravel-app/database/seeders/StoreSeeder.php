<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Store1',
                'address' => 'Address1'
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'name' => 'Store2',
                'address' => 'Address2'
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'name' => 'Store3',
                'address' => 'Address3'
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'name' => 'Store4',
                'address' => 'Address4'
            ],
            [
                'id' => 5,
                'user_id' => 5,
                'name' => 'Store5',
                'address' => 'Address5'
            ]
            ]);
    }
}
