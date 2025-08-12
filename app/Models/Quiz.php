<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('quiz');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat quiz \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui quiz \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus quiz \"{$this->title}\"",
            default => ucfirst($eventName) . " quiz \"{$this->title}\"",
        };
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_content_id',
        'title',
        'duration',
        'number_of_questions',
        'created_by',
        'modified_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'course_content_id' => 'integer',
        ];
    }

    public function courseContent(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CourseContent::class);
    }
    public function questions() {
        return $this->hasMany(\App\Models\QuizQuestion::class);
    }
}
