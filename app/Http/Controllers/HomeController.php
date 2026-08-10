<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
     public function index()
    {
       $event = Event::with('lombas')
    ->where('is_active', true)
    ->first();
        
       

        return view('public.home', compact('event'));
    }
}
