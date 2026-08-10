<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;

class LombaController extends Controller
{
      public function show(Lomba $lomba)
    {
        $lomba->load('event');

        return view('public.lomba', compact('lomba'));
    }
}
