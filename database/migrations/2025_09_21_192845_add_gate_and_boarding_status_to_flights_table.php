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
        Schema::table('flights', function (Blueprint $table) {
            $table->string('gate')->nullable()->after('available_seats');
            $table->enum('boarding_status', ['Not Boarded', 'Boarding', 'Closed'])->default('Not Boarded')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn('gate');
            $table->dropColumn('boarding_status');
        });
    }
};
