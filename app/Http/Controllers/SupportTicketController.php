<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\Staff;
use App\Models\SupportTicket;
use App\Notifications\TicketUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Passenger') {
            $tickets = SupportTicket::where('passenger_id', $user->id)->latest()->get();
            return view('support-tickets.index', compact('tickets'));
        } else {
            $passengers = Passenger::all();
            $tickets = SupportTicket::latest()->get();
            $staff = Staff::all();
            return view('support-tickets.index', compact('tickets', 'passengers', 'staff'));
        }
    }

    public function create()
    {
        return view('support-tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'passenger_id' => 'required|exists:passengers,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:Complaint,Lost Baggage,Special Assistance',
        ]);

        SupportTicket::create($request->all());

        return redirect()->route('support-tickets.index')->with('success', 'Support ticket created successfully.');
    }

    public function edit(SupportTicket $supportTicket)
    {
        $staff = Staff::all();
        return view('support-tickets.edit', compact('supportTicket', 'staff'));
    }

    public function update(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:Complaint,Lost Baggage,Special Assistance',
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
            'assigned_staff_id' => 'nullable|exists:staff,id'
        ]);

        $supportTicket->update($request->all());

        return redirect()->route('support-tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(SupportTicket $supportTicket)
    {
        $supportTicket->delete();
        return redirect()->route('support-tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function assignStaff(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'assigned_staff_id' => 'required|exists:staff,id',
        ]);

        $ticket->update(['assigned_staff_id' => $request->assigned_staff_id]);

        return back()->with('success', 'Ticket assigned successfully.');
    }

    // Staff/Admin: respond to a ticket
    public function respond(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $supportTicket = SupportTicket::findOrFail($id);

        $supportTicket->responses()->create([
            'support_ticket_id' => $supportTicket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Optionally update status
        if ($request->has('status')) {
            $supportTicket->update(['status' => $request->status]);
        }

        // Notify ticket owner (passenger)
        // $supportTicket->user->notify(new TicketUpdated($supportTicket));

        return back()->with('success', 'Response added successfully.');
    }

    // Staff/Admin: mark ticket as resolved
    public function resolve(SupportTicket $supportTicket)
    {
        $supportTicket->update(['status' => 'Resolved']);
        return back()->with('success', 'Ticket resolved.');
    }
}
