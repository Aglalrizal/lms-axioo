<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('courseCategory');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat kategori kursus \"{$this->name}\"",
            'updated' => "[{$actor}] memperbarui kategori kursus \"{$this->name}\"",
            'deleted' => "[{$actor}] menghapus kategori kursus \"{$this->name}\"",
            default => ucfirst($eventName) . " kategori kursus \"{$this->name}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
        ];
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
