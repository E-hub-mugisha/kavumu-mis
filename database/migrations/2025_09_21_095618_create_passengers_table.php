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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade'); // relation to flights
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('passport_number')->unique();
            $table->string('seat_number')->nullable();
            $table->text('special_requests')->nullable();
            $table->enum('status', ['Booked', 'Checked-in', 'Boarded', 'Cancelled'])->default('Booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
