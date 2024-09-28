<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_plan_id',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'hotel_name',
        'address',
        'notes',
    ];

    public function tripPlan()
    {
        return $this->belongsTo(TripPlan::class);
    }
    
}