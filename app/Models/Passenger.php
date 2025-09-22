<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id',
        'name',
        'email',
        'phone',
        'passport_number',
        'seat_number',
        'status'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // Passenger.php
    public function baggage()
    {
        return $this->hasMany(Baggage::class);
    }
    public function assignSeat($seatNumber)
    {
        $this->seat_number = $seatNumber;
        $this->save();
    }
}
