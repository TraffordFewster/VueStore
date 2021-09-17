<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Summary;

class SummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dummyData = [
            "invoices" => [
                ["billToName" => "John Smith",
                "billToAddr1" => "Some Street",
                "billToAddr2" => "Some City",
                "dueDate" => "2022-01-01",
                "products" => [
                    ["id" => 1, "amount" => 20],
                    ["id" => 2, "amount" => 40],
                    ["id" => 3, "amount" => 20],
                    ]
                ]
            ]
        ];

        $summary = Summary::create(
            ['data' => json_encode($dummyData)]
        );
    }
}
