<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassengerPanelController extends Controller
{
    public function index()
    {
        $upcomingFlights = Passenger::with(['flight','baggage'])
            ->where('email', Auth::user()->email)
            ->whereHas('flight', fn($q)=>$q->where('departure_time','>=',now()))
            ->orderBy('flight_id','desc')
            ->get();

        $pastFlights = Passenger::with('flight')
            ->where('email', Auth::user()->email)
            ->whereHas('flight', fn($q)=>$q->where('departure_time','<',now()))
            ->orderBy('flight_id','desc')
            ->get();

        return view('passengers.panel', compact('upcomingFlights','pastFlights'));
    }
}
