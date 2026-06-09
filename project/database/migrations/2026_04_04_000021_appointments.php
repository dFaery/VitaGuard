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
        Schema::create('appointments', function (Blueprint $table){
            $table->id();
            $table->string('patient', 50);
            $table->foreign('patient')->references('username')->on('members');
            $table->unsignedBigInteger('doctor_schedule_id');
            $table->foreign('doctor_schedule_id')->references('id')->on('doctor_schedules');
            $table->date('date');
            $table->time('time');
            $table->integer('queue_order');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'])->nullable();
            $table->text('notes')->nullable();
            $table->datetime("check_in_time")->nullable();
            $table->datetime("completed_time")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('appointments');
        Schema::enableForeignKeyConstraints();
    }
};
