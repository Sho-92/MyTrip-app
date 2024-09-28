<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    // テーブル名の指定（Laravelではモデル名の複数形がテーブル名になるため、必要に応じて指定）
    protected $table = 'transportations';

    // マスアサインメント可能な属性の指定
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

    // 関連モデルとのリレーションの定義（例えば、TripPlanモデルとのリレーション）
    public function tripPlan()
    {
        return $this->belongsTo(TripPlan::class);
    }
    
}