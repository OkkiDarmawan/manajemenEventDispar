<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::whereDate(
            'tanggal_selesai',
            '>=',
            now()->toDateString()
        )
            ->orderBy('tanggal_mulai')
            ->get();

        $faqQuery = Faq::where('is_active', true);

        // Search FAQ
        if ($request->filled('faq_search')) {
            $search = $request->faq_search;

            $faqQuery->where(function ($query) use ($search) {
                $query->where('pertanyaan', 'like', "%{$search}%")
                    ->orWhere('jawaban', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('faq_kategori')) {
            $faqQuery->where('kategori', $request->faq_kategori);
        }

        $faqs = $faqQuery
            ->orderBy('urutan')
            ->orderBy('id')
            ->paginate(6, ['*'], 'faq_page')
            ->withQueryString();

        return view(
            'public.home',
            compact('events', 'faqs')
        );
    }
}
