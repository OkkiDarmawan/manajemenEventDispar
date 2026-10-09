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

        // Pagination
        $faqs = $faqQuery
            ->orderBy('urutan')
            ->orderBy('id')
            ->paginate(6, ['*'], 'faq_page')
            ->withQueryString();

        // Semua kategori FAQ aktif
        $kategoriFaq = Faq::where('is_active', true)
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        // Kalau request AJAX, hanya kirim bagian FAQ
        if ($request->ajax()) {
            return view('public.partials.faq-content', compact(
                'faqs',
                'kategoriFaq'
            ));
        }

        return view(
            'public.home',
            compact('events', 'faqs', 'kategoriFaq')
        );
    }
}
