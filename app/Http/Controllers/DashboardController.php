<?php

namespace App\Http\Controllers;

use App\Models\Baggage;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Flights
        $totalFlights = Flight::count();
        $delayedFlights = Flight::where('status', 'Delayed')->count();
        $cancelledFlights = Flight::where('status', 'Cancelled')->count();
        $completedFlights = Flight::where('status', 'Completed')->count();
        $scheduledFlights = Flight::where('status', 'Scheduled')->count();
        $averageOccupancy = Flight::withCount('passengers')
            ->get()
            ->avg(fn($f) => $f->passengers_count / $f->available_seats * 100);

        // Passengers
        $totalPassengers = Passenger::count();
        $frequentRoutes = Passenger::select('origin', 'destination')
            ->join('flights', 'passengers.flight_id', '=', 'flights.id')
            ->selectRaw('flights.origin, flights.destination, COUNT(*) as count')
            ->groupBy('flights.origin', 'flights.destination')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Baggage
        $totalBaggage = Baggage::count();
        $lostBaggage = Baggage::where('status', 'Lost')->count();
        $inTransitBaggage = Baggage::where('status', 'In-Transit')->count();
        $arrivedBaggage = Baggage::where('status', 'Arrived')->count();
        $averageBaggageWeight = Baggage::whereNotNull('weight')->avg('weight');

        // Revenue
        $totalRevenue = Passenger::count();

        return view('dashboard.index', compact(
            'totalFlights',
            'delayedFlights',
            'cancelledFlights',
            'completedFlights',
            'scheduledFlights',
            'averageOccupancy',
            'totalPassengers',
            'frequentRoutes',
            'totalBaggage',
            'lostBaggage',
            'inTransitBaggage',
            'arrivedBaggage',
            'averageBaggageWeight',
            'totalRevenue'
        ));
    }
}
