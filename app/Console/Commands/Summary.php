<?php

namespace App\Console\Commands;

use \App\Models\Summary as SummaryModel;
use \App\Models\Invoice;
use \App\Models\InvoiceProduct;
use \App\Models\Product;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class Summary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:gen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Summaries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $i = Invoice::where('created_at','>=', Carbon::today() )->get()->load(['products', 'products.product']);
        echo Carbon::yesterday();
        SummaryModel::create(['data' => json_encode($i)]);
    }
}
