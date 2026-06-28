<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    //
    public $guarded = [];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function pqueue(): BelongsTo
    {
        return $this->belongsTo(Pqueue::class);
    }
}
