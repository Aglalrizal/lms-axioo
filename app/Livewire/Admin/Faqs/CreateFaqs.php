<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class CreateFaqs extends Component
{
    public $faq;
    public $formtitle = 'Buat FAQ';

    public $editform=false;

    #[Rule('required')]
    public $question;
    #[Rule('required')]
    public $answer;
    #[Rule('boolean')]
    public $is_active = true;
    #[Rule('required')]
    public $faq_category_id = 1;
    public function render()
    {
        return view('livewire.admin.faqs.create-faqs');
    }
        public function save(){
        $data = $this->validate();
        $lastOrder = Faq::where('faq_category_id', $this->faq_category_id)->max('order') ?? 0;
        $data['order'] = $lastOrder + 1;
        Faq::create($data);
        $this->dispatch('refresh-faqs');
        flash()->success('Berhasil menambah FAQ!');
        $this->reset();
    }
    #[On('reset-modal')]
    public function close(){
        $this->reset();
    }

    #[On('edit-mode')]
    public function edit($id){
        //dd($id);
        $this->editform=true;
        $this->formtitle='Edit FAQ';
        $this->faq=Faq::findOrfail($id);
        $this->question=$this->faq->question;
        $this->answer=$this->faq->answer;
        $this->is_active= (bool) $this->faq->is_active;
        $this->faq_category_id=$this->faq->faq_category_id;
    }
    public function update(){
        $validated=$this->validate();
        $f=Faq::findOrFail($this->faq->id);
        $f->update($validated);
        $this->dispatch('refresh-faqs');
        flash()->success('Berhasil memperbarui FAQ!');
        $this->dispatch('refresh-faqs');
        $this->reset();
    }
}
