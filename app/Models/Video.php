<?php

namespace App\Models;

use App\Models\CourseContent;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;
        function getActivitylogOptions(): LogOptions
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
            default => ucfirst($eventName) . " video \"{$title}\"",
        };
    }
    protected $guarded = [];
    public function courseContent(){
        return $this->belongsTo(CourseContent::class);
    }
}
