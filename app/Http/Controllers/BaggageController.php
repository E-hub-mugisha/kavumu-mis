<?php

namespace App\Http\Controllers;

use App\Models\Baggage;
use App\Models\Flight;
use App\Models\Passenger;
use App\Notifications\BaggageUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BaggageController extends Controller
{
    public function index()
    {
        $baggages = Baggage::with(['passenger', 'flight'])->latest()->get();
        $passengers = Passenger::all();
        $flights = Flight::all();
        return view('baggages.index', compact('baggages', 'passengers', 'flights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'passenger_id' => 'required|exists:passengers,id',
            'flight_id' => 'required|exists:flights,id',
            'status' => 'required'
        ]);

        // Generate a unique tag number, e.g., BG-20250921-XXXX
        do {
            $tagNumber = 'BG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (Baggage::where('tag_number', $tagNumber)->exists());

        Baggage::create([
            'passenger_id' => $request->passenger_id,
            'flight_id' => $request->flight_id,
            'tag_number' => $tagNumber,
            'status' => $request->status,
            'weight' => $request->weight,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', "Baggage added successfully. Tag Number: $tagNumber");
    }

    public function update(Request $request, Baggage $baggage)
    {
        $request->validate([
            'passenger_id' => 'required|exists:passengers,id',
            'flight_id' => 'required|exists:flights,id',
            'tag_number' => 'required|unique:baggages,tag_number,' . $baggage->id,
            'status' => 'required'
        ]);

        $baggage->update($request->all());

        // Notify passenger
        $baggage->passenger->notify(new BaggageUpdated($baggage));

        return back()->with('success', 'Baggage updated successfully.');
    }

    public function destroy(Baggage $baggage)
    {
        $baggage->delete();
        return back()->with('success', 'Baggage deleted successfully.');
    }
}
