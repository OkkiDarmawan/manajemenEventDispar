<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Faq;
use App\Models\Workshop;

class HomeController extends Controller
{
    public function index()
    {
       $events = Event::whereDate(
                'tanggal_selesai',
                '>=',
                now()->toDateString()
            )
            ->orderBy('tanggal_mulai')
            ->get();

        $faqs = Faq::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view(
            'public.home',
            compact('events', 'faqs')
        );
    }
}
