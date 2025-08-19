<?php

namespace App\Models;

use App\Models\CourseContent;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory, LogsActivity;
    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('assignment');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        $title = $this?->courseContent()->title ?? 'Assignment';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat assignment \"{$title}\"",
            'updated' => "[{$actor}] memperbarui assignment \"{$title}\"",
            'deleted' => "[{$actor}] menghapus assignment \"{$title}\"",
            default => ucfirst($eventName) . " assignment \"{$title}\"",
        };
    }
    protected $guarded = [];
    public function courseContent(){
        return $this->belongsTo(CourseContent::class);
    }
    public function submission()
    {
        return $this->hasOne(AssignmentSubmission::class)->where('student_id', Auth::id());
    }
}
