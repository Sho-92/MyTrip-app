<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    protected $table = 'transportations';

    protected $fillable = [
        'trip_plan_id',
        'date',
        'departure_time',
        'arrival_time',
        'departure_location',
        'arrival_location',
        'transportation_mode',
        'notes',
    ];

    public function tripPlan()
    {
        return $this->belongsTo(TripPlan::class);
    }

}