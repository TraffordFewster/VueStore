<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Summary;

class SummaryController extends Controller
{

    public function index()
    {
        $data = Summary::select('id','created_at')->get();
        return view('summary.index', compact("data"));
    }

    public function view(Summary $summary)
    {
        return $summary->data;
    }

}
