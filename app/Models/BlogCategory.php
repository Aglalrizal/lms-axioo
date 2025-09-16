<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('blogCategory');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';

        return match ($eventName) {
            'created' => "[{$actor}] membuat kategori blog \"{$this->name}\"",
            'updated' => "[{$actor}] memperbarui kategori blog \"{$this->name}\"",
            'deleted' => "[{$actor}] menghapus kategori blog \"{$this->name}\"",
            default => ucfirst($eventName)." kategori blog \"{$this->name}\"",
        };
    }

    protected $guarded = [];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
