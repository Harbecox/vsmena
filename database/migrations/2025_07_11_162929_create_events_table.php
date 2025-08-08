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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('positions_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('color')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreign('positions_id')->references('id')->on('positions')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
