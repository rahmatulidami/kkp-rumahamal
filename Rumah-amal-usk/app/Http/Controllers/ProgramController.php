<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        // Tidak perlu mengambil data dari API di sini
        return view('program.program');
    }
}
