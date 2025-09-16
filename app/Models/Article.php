<?php

namespace App\Models;

use App\Models\CourseContent;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('artikel');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        $title = $this?->courseContent()->title ?? 'Artikel';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat artikel \"{$title}\"",
            'updated' => "[{$actor}] memperbarui artikel \"{$title}\"",
            'deleted' => "[{$actor}] menghapus artikel \"{$title}\"",
            default => ucfirst($eventName) . " artikel \"{$title}\"",
        };
    }
    protected $guarded = [];

    public function courseContent(){
        return $this->belongsTo(CourseContent::class);
    }
}
