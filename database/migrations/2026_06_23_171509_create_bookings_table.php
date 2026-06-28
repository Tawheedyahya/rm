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
        Schema::create('bookings', function (Blueprint $table) {
              $table->id();

            $table->foreignId('hotel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('table_id')
                ->nullable()
                ->constrained('tables')
                ->nullOnDelete();

            $table->foreignId('pqueue_id')
                ->nullable()
                ->constrained('pqueues')
                ->nullOnDelete();

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->unsignedInteger('party_size');

            $table->enum('status', [
                'pending',
                'confirmed',
                'seated',
                'completed',
                'cancelled',
                'no_show'
            ])->default('pending');

            $table->timestamp('booked_at')->useCurrent();
            $table->timestamp('reservation_at')->nullable();
            $table->timestamp('seated_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
