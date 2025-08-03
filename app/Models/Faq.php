<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Faq extends Model
{
    /** @use HasFactory<\Database\Factories\FaqFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll()
        ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $user = Auth::user()?->username ?? 'Sistem';
        $category = $this->category?->name ?? '-';

        return match ($eventName) {
            'created' => "[{$user}] menambahkan FAQ \"{$this->question}\" ke kategori \"{$category}\"",
            'updated' => "[{$user}] memperbarui FAQ \"{$this->question}\"",
            'deleted' => "[{$user}] menghapus FAQ \"{$this->question}\" dari kategori \"{$category}\"",
            default => ucfirst($eventName).' FAQ'
        };
    }

    protected $fillable = [
        'question', 'answer', 'order', 'faq_category_id', 'is_active'
    ];

    public function categories (){
        return $this->belongsTo(FaqCategory::class);
    }
}
