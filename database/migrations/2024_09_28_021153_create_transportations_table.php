<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_plan_id')->constrained()->onDelete('cascade'); // 旅行プランとのリレーション
            $table->date('date'); //移動の日付
            $table->time('departure_time'); //出発時間
            $table->time('arrival_time')->nullable(); // 到着時間はオプション
            $table->string('departure_location'); //出発地
            $table->string('arrival_location'); //到着地
            $table->string('transportation_mode'); //移動手段（例: 飛行機、電車、バス、車、徒歩、自転車、その他）
            $table->text('notes')->nullable(); // 備考欄
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
};