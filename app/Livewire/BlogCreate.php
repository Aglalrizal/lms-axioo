<?php

namespace App\Livewire;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Livewire\Component;

class BlogCreate extends Component
{
    public $date;
    public $title;
    public $slug;
    public $category;
    public $content;

    public function submit()
    {

        dd($this->date, $this->title, $this->slug, $this->category, $this->content);
    }

    public function render()
    {
        return view(
            'livewire.blog-create',
            [
                'categories' => BlogCategory::get('name')
            ]
        );
    }
}
