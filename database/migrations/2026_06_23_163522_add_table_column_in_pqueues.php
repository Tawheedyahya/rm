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
        Schema::table('pqueues', function (Blueprint $table) {
            //
            $table->foreignId('table_id')->constrained('tables')->after('hotel_id')->elete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pqueues', function (Blueprint $table) {
            //
            $table->dropForeign(['table_id']);
            $table->dropColumn('table_id');
        });
    }
};
