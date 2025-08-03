<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class FaqCategory extends Model
{
    /** @use HasFactory<\Database\Factories\FaqCategoryFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'is_active'])
        ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $user = Auth::user()?->username ?? 'Sistem';
        return match ($eventName) {
            'created' => "[{$user}] menambahkan kategori FAQ \"{$this->name}\"",
            'updated' => "[{$user}] memperbarui kategori FAQ \"{$this->name}\"",
            'deleted' => "[{$user}] menghapus kategori FAQ \"{$this->name}\"",
            default => ucfirst($eventName) . " kategori FAQ",
        };
    }


    protected $guarded = [];
    public function faqs(){
        return $this->hasMany(Faq::class)->orderBy('order');
    }
}
