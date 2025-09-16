<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CourseCategory extends Model
{
    use HasFactory, LogsActivity, Sluggable, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
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
            default => ucfirst($eventName)." kategori kursus \"{$this->name}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

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
