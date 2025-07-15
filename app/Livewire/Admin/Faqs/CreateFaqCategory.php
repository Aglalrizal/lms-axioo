<?php

namespace App\Livewire\Admin\Faqs;

use Livewire\Component;
use App\Models\FaqCategory;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class CreateFaqCategory extends Component
{
    #[Rule('required')]
    public $name = '';
    #[Rule('boolean')]
    public $is_active = false;
    public $formtitle = 'Buat FAQ Kategori';
    public $editform=false;

    public $faqCategory;
    public function render()
    {
        return view('livewire.admin.faqs.create-faq-category');
    }

    public function save(){
        $this->name = trim($this->name);
        $data = $this->validate();
        $data['order'] = FaqCategory::max('order') + 1;
        FaqCategory::create($data);
        $this->dispatch('refresh-faqs');
        $this->dispatch('refresh-categories')->to(CreateFaqs::class);
        flash()->success('Berhasil menambah FAQ kategori!');
        $this->reset();
    }

    #[On('reset-category-modal')]
    public function close(){
        $this->reset();
    }
    #[On('edit-category-mode')]
    public function edit($id){
        //dd($id);
        $this->editform=true;
        $this->formtitle='Edit FAQ Kategori';
        $this->faqCategory=FaqCategory::findOrfail($id);
        $this->name=$this->faqCategory->name;
        $this->is_active= (bool) $this->faqCategory->is_active;
    }
    public function update(){
        $validated=$this->validate();
        $fc=FaqCategory::findOrFail($this->faqCategory->id);
        try {
            $fc->update($validated);
        } catch (\Throwable $th) {
            dd($th);
        }
        $this->dispatch('refresh-faqs');
        $this->dispatch('refresh-categories')->to(CreateFaqs::class);
        flash()->success('Berhasil memperbarui FAQ Kategori!');
        $this->reset();
    }
}
