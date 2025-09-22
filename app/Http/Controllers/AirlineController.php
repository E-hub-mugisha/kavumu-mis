<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    // List all airlines
    public function index()
    {
        $airlines = Airline::latest()->paginate(10);
        return view('airlines.index', compact('airlines'));
    }

    // Show create form
    public function create()
    {
        return view('airlines.create');
    }

    // Store new airline
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'code'  => 'required|string|max:10|unique:airlines',
            'country' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        Airline::create($request->all());

        return redirect()->route('airlines.index')
            ->with('success', 'Airline added successfully.');
    }

    // Edit form
    public function edit(Airline $airline)
    {
        return view('airlines.edit', compact('airline'));
    }

    // Update airline
    public function update(Request $request, Airline $airline)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'code'  => 'required|string|max:10|unique:airlines,code,' . $airline->id,
            'country' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $airline->update($request->all());

        return redirect()->route('airlines.index')
            ->with('success', 'Airline updated successfully.');
    }

    // Delete airline
    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect()->route('airlines.index')
            ->with('success', 'Airline deleted successfully.');
    }
}
