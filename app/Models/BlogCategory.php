<?php

namespace App\Models;

use App\Models\Blog;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory, SoftDeletes, LogsActivity;
    function getActivitylogOptions(): LogOptions
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
            default => ucfirst($eventName) . " kategori blog \"{$this->name}\"",
        };
    }
    protected $guarded = [];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
