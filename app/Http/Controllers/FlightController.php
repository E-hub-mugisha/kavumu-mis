<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Flight;
use App\Notifications\FlightStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FlightController extends Controller
{
    public function index()
    {
        $flights = Flight::with('airline')->latest()->paginate(10);
        $airlines = Airline::all();
        return view('flights.index', compact('flights', 'airlines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'origin' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'available_seats' => 'required|integer|min:1',
            'status' => 'required|in:Scheduled,Delayed,Cancelled,Completed',
        ]);

        // Auto-generate flight number: AirlineCode + Random 4 digits
        $airline = Airline::findOrFail($request->airline_id);
        $flightNumber = $airline->code . rand(1000, 9999);

        Flight::create([
            'airline_id' => $request->airline_id,
            'flight_number' => $flightNumber,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'available_seats' => $request->available_seats,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "Flight created successfully with Flight Number: $flightNumber");
    }

    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'flight_number' => 'required|unique:flights,flight_number,' . $flight->id,
            'origin' => 'required',
            'destination' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'available_seats' => 'required|integer|min:1',
            'status' => 'required',
        ]);

        $flight->update($request->all());

        // Notify all staff/admin
        $adminsAndStaff = \App\Models\User::whereIn('role', ['Admin', 'Staff'])->get();
        foreach ($adminsAndStaff as $user) {
            $user->notify(new FlightStatusUpdated($flight));
        }
        return back()->with('success', 'Flight updated and notifications sent successfully.');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return back()->with('success', 'Flight deleted successfully.');
    }

    public function show(Flight $flight)
    {
        return response()->json($flight->load('airline'));
    }

    // Assign gate to a flight
    public function assignGate(Request $request, $id)
    {
        $request->validate([
            'gate' => 'required|string|max:5'
        ]);

        $flight = Flight::findOrFail($id);
        $flight->gate = strtoupper($request->gate); // store as uppercase
        $flight->update();

        return back()->with('success', "Gate {$flight->gate} assigned to flight {$flight->flight_number}");
    }

    // Update flight boarding status
    public function updateBoardingStatus(Request $request, $id)
    {
        $request->validate([
            'boarding_status' => 'required|in:Not Boarded,Boarding,Closed'
        ]);

        $flight = Flight::findOrFail($id);
        $flight->boarding_status = $request->boarding_status;
        $flight->update();

        return back()->with('success', "Flight {$flight->flight_number} boarding status updated to {$flight->boarding_status}");
    }

    public function updateStatus(Request $request, Flight $flight)
    {
        $request->validate([
            'status' => 'required|in:Scheduled,Delayed,Cancelled,Completed'
        ]);

        $flight->updateStatus($request->status);
        return back()->with('success', "Flight {$flight->flight_number} status updated to {$request->status}");
    }

    public function autoAssignSeats(Flight $flight)
    {
        $rows = range(1, 30); // rows 1-30
        $seats = ['A', 'B', 'C', 'D', 'E', 'F']; // seats per row

        foreach ($flight->passengers as $index => $passenger) {
            $row = $rows[$index % count($rows)];
            $seat = $seats[$index % count($seats)];
            $passenger->assignSeat($row . $seat);
        }

        return back()->with('success', "Seats assigned automatically for flight {$flight->flight_number}");
    }

    /**
     * Display a list of past flights with passengers and baggage.
     */
    public function indexFlightHistory()
    {
        // Get flights that are Completed or Cancelled (past flights)
        $flights = Flight::with(['airline', 'passengers.baggage'])
            ->whereIn('status', ['Completed', 'Cancelled'])
            ->orderBy('departure_time', 'desc')
            ->get();

        return view('flights.history', compact('flights'));
    }

    /**
     * Show details of a specific past flight.
     */
    public function showFlightHistory(Flight $flight)
    {
        $flight->load('airline', 'passengers.baggage');

        return view('flights.history-show', compact('flight'));
    }
}
