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
        Schema::table('tables', function (Blueprint $table) {
            //
            $table->smallInteger('occupied_seats')->default(0); // Optional
        });
         Schema::table('bookings', function (Blueprint $table) {
            //
            $table->enum('booking_type',['reservation','walk_in'])->default('walk_in'); // Optional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
            $table->dropColumn('occupied_seats');
        });
    }
};
