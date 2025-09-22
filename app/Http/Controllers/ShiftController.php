<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Staff;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index() {
        $shifts = Shift::with('staff')->latest()->paginate(10);
        $staff = Staff::all();
        return view('shifts.index', compact('shifts','staff'));
    }

    public function store(Request $request) {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);
        Shift::create($request->all());
        return back()->with('success','Shift scheduled successfully.');
    }

    public function update(Request $request, Shift $shift) {
        $request->validate([
            'status' => 'required|in:Scheduled,Completed,Missed'
        ]);
        $shift->update(['status'=>$request->status]);
        return back()->with('success','Shift updated.');
    }
}
