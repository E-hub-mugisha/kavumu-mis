<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FlightStatusUpdated extends Notification
{
    use Queueable;

    public $flight;

    public function __construct($flight)
    {
        $this->flight = $flight;
    }

    public function via($notifiable)
    {
        return ['database']; // Stores in notifications table
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Flight {$this->flight->flight_number} status updated to {$this->flight->status}",
            'link' => route('flights.show', $this->flight->id),
            'icon' => 'mdi mdi-airplane',
        ];
    }
}
