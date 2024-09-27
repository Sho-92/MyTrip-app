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
        Schema::create('trip_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();  // 旅行プランの名前
            $table->text('description')->nullable();  // 詳細説明
            $table->date('start_date');  // 旅行開始日
            $table->date('end_date');  // 旅行終了日
            $table->string('country');  // 国
            $table->string('city');  // 市
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_plans');
    }
};
