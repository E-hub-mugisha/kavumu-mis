<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'flight_number',
        'origin',
        'destination',
        'departure_time',
        'arrival_time',
        'available_seats',
        'status'
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function assignGate($gate)
    {
        $this->gate = $gate;
        $this->save();
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
    }
}
