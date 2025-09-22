<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'subject',
        'description',
        'type',
        'status',
        'assigned_staff_id',
    ];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }
}
