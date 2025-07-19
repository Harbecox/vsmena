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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('price_shifts', 10, 2);
            $table->decimal('price_hour', 10, 2);
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique();
            $table->unsignedBigInteger('users_id');
            $table->tinyInteger('order')->default(0)->index();
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('restaurants_id')->index()->nullable();
            $table->foreign('restaurants_id')->references('id')->on('restaurants')
                ->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
