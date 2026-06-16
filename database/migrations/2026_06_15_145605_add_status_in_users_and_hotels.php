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
            $table->unsignedTinyInteger('status')
                ->default(0)
                ->after('password')
                ->comment('0 = Inactive, 1 = Active');

            $table->index('status', 'users_status_idx');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')
                ->default(1)
                ->after('postal_code')
                ->comment('0 = Inactive, 1 = Active');

            $table->index('status', 'hotels_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_status_idx');
            $table->dropColumn('status');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropIndex('hotels_status_idx');
            $table->dropColumn('status');
        });
    }
};
