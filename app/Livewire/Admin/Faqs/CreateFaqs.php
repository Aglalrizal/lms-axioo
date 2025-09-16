<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use App\Models\FaqCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateFaqs extends Component
{
    public $faq;

    public $categories = [];

    public $formtitle = 'Buat FAQ';

    public $editform = false;

    public $question;

    public $answer;

    public $is_active = false;

    public $faq_category_id = 1;

    protected function rules()
    {
        return [
            'question' => ['required', 'string', 'min:10'],
            'answer' => ['required', 'string', 'min:10'],
            'is_active' => ['boolean'],
            'category_id' => ['required', 'integer', 'exists:faq_categories,id'],
        ];
    }

    protected function messages()
    {
        return [
            'question.required' => 'Pertanyaan tidak boleh kosong.',
            'question.string' => 'Pertanyaan harus berupa teks.',
            'question.min' => 'Pertanyaan minimal :min karakter.',

            'answer.required' => 'Jawaban tidak boleh kosong.',
            'answer.string' => 'Jawaban harus berupa teks.',
            'answer.min' => 'Jawaban minimal :min karakter.',

            'is_active.boolean' => 'Status aktif harus bernilai true atau false.',

            'category_id.required' => 'Kategori FAQ wajib dipilih.',
            'category_id.integer' => 'Kategori FAQ tidak valid.',
            'category_id.exists' => 'Kategori FAQ yang dipilih tidak ditemukan.',
        ];
    }

    public function mount()
    {
        $this->categories = FaqCategory::with(['faqs' => fn ($q) => $q->orderBy('order')])->orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.admin.faqs.create-faqs');
    }

    public function save()
    {
        $this->validate();
        $data = $this->validate();
        $lastOrder = Faq::where('faq_category_id', $this->faq_category_id)->max('order') ?? 0;
        $data['order'] = $lastOrder + 1;
        Faq::create($data);
        $this->dispatch('refresh-faqs');
        flash()->success('Berhasil menambah FAQ!', [], 'Sukses');
        $this->reset();
    }

    #[On('reset-faq-item-modal')]
    public function close()
    {
        $this->resetValidation();
        $this->reset();
    }

    #[On('edit-faq-item-mode')]
    public function edit($id)
    {
        // dd($id);
        $this->editform = true;
        $this->formtitle = 'Edit FAQ';
        $this->faq = Faq::findOrfail($id);
        $this->question = $this->faq->question;
        $this->answer = $this->faq->answer;
        $this->is_active = (bool) $this->faq->is_active;
        $this->faq_category_id = $this->faq->faq_category_id;
    }

    public function update()
    {
        $this->validate();
        $validated = $this->validate();
        $f = Faq::findOrFail($this->faq->id);
        $f->update($validated);
        $this->dispatch('refresh-faqs');
        flash()->success('Berhasil memperbarui FAQ!');
        $this->dispatch('refresh-faqs');
        $this->reset();
    }

    #[On('refresh-categories')]
    public function refreshCategories()
    {
        $this->categories = FaqCategory::with(['faqs' => fn ($q) => $q->orderBy('order')])->orderBy('order')->get();
    }
}
