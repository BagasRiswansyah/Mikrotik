<?php

namespace App\Http\Controllers;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::orderBy('created_at', 'desc')->get();
        return view('history.index', compact('histories'));
    }
}

