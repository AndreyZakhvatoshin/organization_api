<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent_id', 'level'];

    protected static function boot()
    {
        parent::boot();
        // Автоматическое определение уровня
        static::creating(function ($activity) {
            if ($activity->parent_id) {
                $parentLevel = Activity::find($activity->parent_id)->level;
                $activity->level = $parentLevel + 1;
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(
            Organization::class,
            'organization_activity',
            'activity_id',
            'organization_id'
        );
    }
}
