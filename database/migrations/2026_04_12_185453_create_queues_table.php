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
        Schema::create('pqueues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('customer_name',100);
            $table->smallInteger('members_count');
            $table->enum('status',['waiting','called','seated','cancelled','no_show'])->default('waiting');
            $table->timestamp('seated_at')->nullable();
            $table->timestamp('called_at')->nullable();
            $table->timestamps();
            $table->index(['hotel_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
