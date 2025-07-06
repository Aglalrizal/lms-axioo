<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        return view('public.help-center.faq', [
            'most_asked' => Faq::all()->where('faq_category_id', 1),
            'general' => Faq::all()->where('faq_category_id', 2),
            'support' => Faq::all()->where('faq_category_id', 3),
        ]);
    }
}
