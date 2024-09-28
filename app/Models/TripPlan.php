<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPlan extends Model
{
    use HasFactory;
    /**
     * モデルで操作するテーブル名
     *
     * @var string
     */
    protected $table = 'trip_plans';

    /**
     * 更新可能なフィールド（カラム）
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'country',
        'city',
    ];

    /**
     * 日付として扱うカラム
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TripPlan は 複数の TripList を持つ
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
    
}