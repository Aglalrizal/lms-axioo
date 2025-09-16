<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('video');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'Sistem';
        $title = $this?->courseContent()->title ?? 'Video';

        return match ($eventName) {
            'created' => "[{$actor}] membuat video \"{$title}\"",
            'updated' => "[{$actor}] memperbarui video \"{$title}\"",
            'deleted' => "[{$actor}] menghapus video \"{$title}\"",
            default => ucfirst($eventName)." video \"{$title}\"",
        };
    }

    protected $guarded = [];

    public function courseContent()
    {
        return $this->belongsTo(CourseContent::class);
    }
}
