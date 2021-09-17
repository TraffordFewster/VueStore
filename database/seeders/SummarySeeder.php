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

        \Artisan::call('summary:gen');
    }
}
