<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Passenger;
use App\Notifications\PassengerCheckIn;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index()
    {
        $passengers = Passenger::with('flight')->latest()->paginate(10);
        $flights = Flight::all();
        return view('passengers.index', compact('passengers', 'flights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email',
            'phone' => 'nullable|string|max:20',
            'passport_number' => 'required|string|unique:passengers,passport_number',
            'seat_number' => 'nullable|string|max:10',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:Booked,Checked-in,Boarded,Cancelled',
        ]);

        Passenger::create($request->all());
        return back()->with('success', 'Passenger added successfully.');
    }

    public function update(Request $request, Passenger $passenger)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:passengers,email,' . $passenger->id,
            'passport_number' => 'required|unique:passengers,passport_number,' . $passenger->id,
            'seat_number' => 'nullable',
            'status' => 'required'
        ]);

        $passenger->update($request->all());
        return back()->with('success', 'Passenger updated successfully.');
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return back()->with('success', 'Passenger deleted successfully.');
    }

    public function show(Passenger $passenger)
    {
        return response()->json($passenger->load('flight'));
    }

    // Check-in a passenger
    public function checkIn(Request $request, Passenger $passenger)
    {
        // Only allow if booked or not yet boarded
        if (!in_array($passenger->status, ['Booked', 'Checked-in'])) {
            return back()->with('error', 'Passenger cannot check-in.');
        }

        $passenger->status = 'Checked-in';
        $passenger->checkin_time = now();
        $passenger->save();

        // Notify passenger
        $passenger->notify(new PassengerCheckIn($passenger));

        return back()->with('success', 'Passenger checked in successfully.');
    }

    public function boardingPass(Passenger $passenger)
    {
        // Ensure seat fallback
        $seat = $passenger->seat_number ?? 'Auto Assigned';

        // Generate QR code (SVG) with your style
        $qrDir = public_path('qr_codes');
        $qrPath = $qrDir . '/' . $passenger->flight->flight_number . '.svg';

        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        if (!file_exists($qrPath)) {
            $qrImage = QrCode::format('svg')
                ->size(200)
                ->generate("Passenger: {$passenger->name}\nFlight: {$passenger->flight->flight_number}\nSeat: {$seat}");
            file_put_contents($qrPath, $qrImage);
        }

        $qrUrl = asset('qr_codes/' . $passenger->flight->flight_number  . '.svg');

        // Load PDF view
        $pdf = Pdf::loadView('passengers.boarding-pass', [
            'passenger' => $passenger,
            'seat' => $seat,
            'qr' => $qrUrl,
            'boarding_time' => Carbon::parse($passenger->flight->departure_time)->subMinutes(45)->format('h:i A'),
        ]);

        // Stream PDF to browser
        return $pdf->stream("boarding_pass_{$passenger->id}.pdf");
    }
}
