<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        sweetalert()->success('Your submission has been received successfully.');
        $categories = FaqCategory::with(['faqs' => fn($q) => $q->orderBy('order')])->orderBy('order')->get();
        return view('admin.faq.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        $request->validate([
        'question' => 'required|string',
        'answer' => 'required|string',
        'faq_category_id' => 'required|exists:faq_categories,id',
    ]);

    $lastOrder = Faq::where('faq_category_id', $request->faq_category_id)->max('order') ?? 0;

    Faq::create([
        'question' => $request->question,
        'answer' => $request->answer,
        'faq_category_id' => $request->faq_category_id,
        'order' => $lastOrder + 1,
    ]);
    flash()->option('position', 'bottom-right')->success('Berhasil menambahkan faq baru.');
    return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'faq_category_id' => 'required|exists:faq_categories,id',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'faq_category_id' => $request->faq_category_id,
        ]);

        return back()->with('success', 'FAQ updated successfully.');
    }

    public function reorder(Request $request)
{
    foreach ($request->data as $item) {
        Faq::where('id', $item['id'])->update(['order' => $item['order']]);
    }
    
    return flash()->option('position', 'bottom-right')->success('Berhasil mengubah urutan FAQ!');;
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted successfully.');
    }
}
