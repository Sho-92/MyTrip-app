<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'trip_plan_id'];

    // ChecklistはTripPlanに属する
    public function tripPlan()
    {
        return $this->belongsTo(TripPlan::class);
    }

    // Checklistは複数のTaskを持つ
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}