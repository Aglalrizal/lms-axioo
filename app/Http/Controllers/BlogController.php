<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index_public()
    {
        return view('public.blog.index');
    }

    public function index_admin()
    {
        return view('admin.blog.index');
    }

    public function show(Blog $blog)
    {
        return view('public.blog.show', ['blog' => $blog]);
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function edit(Blog $blog)
    {
        $blog->load('author');
        return view('admin.blog.edit', ['blog' => $blog]);
    }
}
