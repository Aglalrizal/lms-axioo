<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /** @use HasFactory<\Database\Factories\FaqFactory> */
    use HasFactory;

    protected $fillable = [
        'question', 'answer', 'order', 'faq_category_id'
    ];

    public function categories (){
        return $this->belongsTo(FaqCategory::class);
    }
}
