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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->foreignId('role_id')->nullable()->constrained()->restrictOnDelete()->comment('refers roles table');
            $table->foreignId('hotel_id')->nullable()->constrained()->on('hotels')->restrictOnDelete()->comment('refers hotels table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropForeign(['hotel_id']);
            $table->dropColumn('hotel_id');
        });
    }
};
