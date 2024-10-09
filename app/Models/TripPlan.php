<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPlan extends Model
{
    use HasFactory;

    protected $table = 'trip_plans';

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'country',
        'city',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tripLists()
    {
        return $this->hasMany(TripList::class);
    }

    public function transportations()
    {
        return $this->hasMany(Transportation::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

}