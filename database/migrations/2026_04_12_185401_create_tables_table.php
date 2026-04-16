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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('table_number');
            $table->smallInteger('capacity');
            $table->string('description')->nullable();
            $table->enum('status',['available','occupied','reserved'])->default('available')->index('table_status');
            $table->timestamps();
            $table->unique(['hotel_id','table_number'],'hotel_table_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('tables',function(Blueprint $table){
        //     $table->dropIndex('table_status');
        //     $table->dropUnique('hotel_table_unique');
        //     $table->dropForeign(['hotel_id']);
        // });
        Schema::dropIfExists('tables');
    }
};
