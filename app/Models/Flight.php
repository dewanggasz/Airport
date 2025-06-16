<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = ['airline_id', 'flight_number', 'direction', 'city', 'scheduled_time', 'actual_time', 'status'];
    protected $casts = ['scheduled_time' => 'datetime', 'actual_time' => 'datetime'];

    public function airline() {
        return $this->belongsTo(Airline::class);
    }
}
