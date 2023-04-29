<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
            [
                [
                    'store_id' => 1,
                    'name' => 'Product1',
                    'description' => 'Description1'
                ],
                [
                    'store_id' => 2,
                    'name' => 'Product2',
                    'description' => 'Description2'
                ],
                [
                    'store_id' => 3,
                    'name' => 'Product3',
                    'description' => 'Description3'
                ],
                [
                    'store_id' => 4,
                    'name' => 'Product4',
                    'description' => 'Description4'
                ],
                [
                    'store_id' => 5,
                    'name' => 'Product5',
                    'description' => 'Description5'
                ]
            ]
        );
    }
}
