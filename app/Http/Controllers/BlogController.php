<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function show(Blog $blog)
    {
        return view('public.blog.show', ['blog' => $blog]);
    }
}
