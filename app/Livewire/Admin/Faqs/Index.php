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

    public $categoryToDelete = null;

    public $faq = [];

    #[On('delete-faq-category')]
    public function confirmDeleteCategory($id)
    {
        $this->categoryToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, delete it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id)
            ->warning('Are you sure you want to delete this FAQ category?', ['Confirm Deletion']);
    }


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
        if ($this->categoryToDelete) {
            $category = FaqCategory::find($this->categoryToDelete);
            if ($category) {
                $category->delete(); // Akan error kalau ada relasi FAQ yang masih nyangkut, hati-hati
                flash()->success('FAQ Category deleted successfully!');
            } else {
                flash()->error('FAQ Category not found.');
            }

            $this->categoryToDelete = null;
            $this->refreshProducts();
            return;
        }
        if ($this->faqToDelete) {
            $faq = Faq::find($this->faqToDelete);
            if ($faq) {
                $faq->delete();
                flash()->success('FAQ deleted successfully!');
            } else {
                flash()->error('FAQ not found.');
            }

            $this->faqToDelete = null;
            $this->refreshProducts();
        }
    }


    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if($this->categoryToDelete){
            $this->categoryToDelete = null;
            flash()->info('Category Faq deletion cancelled.');
        }
        if($this->faqToDelete){
            $this->faqToDelete = null;
            flash()->info('Faq deletion cancelled.');
        }
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

