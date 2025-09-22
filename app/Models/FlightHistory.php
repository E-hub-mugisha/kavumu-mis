<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightHistory extends Model
{
    use HasFactory;

    protected $fillable = ['flight_id', 'passenger_status','baggage_id','passenger_id'];
    
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function baggage()
    {
        return $this->belongsTo(Baggage::class);
    }
}
