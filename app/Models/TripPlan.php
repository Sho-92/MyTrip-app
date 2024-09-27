<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'country',
        'city',
        'user_id',  // user_id を追加する場合は、ここにも入れる
    ];

    // ユーザーとのリレーションシップを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}