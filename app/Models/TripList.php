<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripList extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'destination',
        'notes',
        'trip_plan_id',
        'start_time',
        'end_time',
    ];

    public function tripPlan()
    {
        return $this->belongsTo(TripPlan::class);
    }

}
