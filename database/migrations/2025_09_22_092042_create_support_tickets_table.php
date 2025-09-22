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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')
                ->constrained('passengers')
                ->onDelete('cascade');
            $table->string('subject');
            $table->text('description');
            $table->enum('type', ['Complaint', 'Lost Baggage', 'Special Assistance'])->default('Complaint');
            $table->enum('status', ['Open', 'In Progress', 'Resolved', 'Closed'])->default('Open');
            $table->foreignId('assigned_staff_id')
                ->nullable()
                ->constrained('staff')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
