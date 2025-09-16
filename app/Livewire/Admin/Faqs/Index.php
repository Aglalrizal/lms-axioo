<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use App\Models\FaqCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $categories = [];

    public $faqToDelete = null;

    public $categoryToDelete = null;

    public $faq = [];

    public function updateFaqOrder($groups)
    {
        foreach ($groups as $group) {
            // Update urutan kategori jika ada
            if ($group['order'] !== null) {
                FaqCategory::where('id', $group['value'])->update(['order' => $group['order']]);
            }
            // Update FAQ
            foreach ($group['items'] as $item) {
                Faq::where('id', $item['value'])->update([
                    'order' => $item['order'],
                    'faq_category_id' => $group['value'],
                ]);
            }
        }
        flash()->success('Berhasil mengubah urutan FAQ', [], 'Sukses');
        $this->dispatch('refresh-faqs');
    }

    public function updateCategoryFaqOrder($groups)
    {
        $changed = false;

        foreach ($groups as $group) {
            $category = FaqCategory::find($group['value']);
            if ($category && $category->order != $group['order'] && $group['order'] !== null) {
                $category->update(['order' => $group['order']]);
                $changed = true; // tandai ada perubahan
            }
        }

        if ($changed) {
            flash()->success('Berhasil mengubah urutan kategori FAQ', [], 'Sukses');
            $this->dispatch('refresh-faqs');
        }
    }

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
    public function delete(array $payload)
    {
        if ($this->categoryToDelete) {
            $category = FaqCategory::find($this->categoryToDelete);
            if ($category) {
                $category->delete();
                flash()->success('FAQ Category deleted successfully!');
            } else {
                flash()->error('FAQ Category not found.');
            }

            $this->categoryToDelete = null;
            $this->refreshFaqs();

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
            $this->refreshFaqs();
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if ($this->categoryToDelete) {
            $this->categoryToDelete = null;
            $this->dispatch('refresh-categories')->to(CreateFaqs::class);
            flash()->info('Category Faq deletion cancelled.');
        }
        if ($this->faqToDelete) {
            $this->faqToDelete = null;
            flash()->info('Faq deletion cancelled.');
        }
    }

    public function mount()
    {
        $this->categories = FaqCategory::with(['faqs' => fn ($q) => $q->orderBy('order')])->orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.admin.faqs.index');
    }

    #[On('refresh-faqs')]
    public function refreshFaqs()
    {
        $this->categories = FaqCategory::with(['faqs' => fn ($q) => $q->orderBy('order')])->orderBy('order')->get();
    }
}
