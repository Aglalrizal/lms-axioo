<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function show_most_asked(): View
    {
        /**
         * Show the FAQ data.
         */
        return view('public.help-center.main', [
            'faqs' => Faq::all()->where('faq_category_id', 1)
        ]);
    }

    public function show(): View
    {
        /**
         * Show the guide data.
         */

        $categories = FaqCategory::with(['faqs' => fn($q) => $q->orderBy('order')])->orderBy('order')->get();
        return view('public.help-center.faq', compact('categories'));
    }
}
