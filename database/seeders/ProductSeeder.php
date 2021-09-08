<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devMinute = Product::firstOrCreate([
            'name' => 'DevMinutes',
            'price' => 35.99,
        ]);
        $devMinute->save();

        $hrMinute = Product::firstOrCreate([
            'name' => 'HrMinutes',
            'price' => 23.50,
        ]);
        $hrMinute->save();

        $trainingMinute = Product::firstOrCreate([
            'name' => 'HrMinutes',
            'price' => 5.99,
        ]);
        $trainingMinute->save();
    }
}
