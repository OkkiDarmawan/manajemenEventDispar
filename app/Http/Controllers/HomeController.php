<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Faq;
use App\Models\Workshop;

class HomeController extends Controller
{
    public function index()
    {
        $event = Event::with('lombas')
            ->where('is_active', true)
            ->first();

        $faqs = Faq::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $workshops = Workshop::with('event')
            ->latest()
            ->get();

        return view('public.home', compact('event', 'faqs', 'workshops'));
    }
}
