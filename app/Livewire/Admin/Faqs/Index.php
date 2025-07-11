<?php

namespace App\Livewire\Admin\Faqs;

use Livewire\Component;
use App\Models\FaqCategory;
use App\Models\Faq;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;


#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $categories = [];
    public $faqToDelete = null;

    public $faq = [];

    #[On('delete-faq')]
    public function confirmDelete($id)
    {
        $this->faqToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, delete it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id) 
            ->warning('Are you sure you want to delete this faq?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function deleteTask(array $payload)
    {
        $faq = Faq::find($this->faqToDelete);

        if ($faq) {
            $faq->delete();
            $this->faq = Faq::latest()->get();
            flash()->success('Faq deleted successfully!');
        } else {
            flash()->error('Faq not found.');
        }

        $this->faqToDelete = null;
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        $this->faqToDelete = null;
        flash()->info('Faq deletion cancelled.');
    }

    public function mount(){
        $this->categories=FaqCategory::with(['faqs' => fn($q) => $q->orderBy('order')])->orderBy('order')->get();
    }
    public function render()
    {
        return view('livewire.admin.faqs.index');
    }
    #[On('refresh-faqs')]
    public function refreshProducts(){
        $this->categories=FaqCategory::with(['faqs' => fn($q) => $q->orderBy('order')])->orderBy('order')->get();
    }
}

