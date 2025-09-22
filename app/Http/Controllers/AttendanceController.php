<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index() {
        $attendances = Attendance::with('staff')->latest()->paginate(10);
        $staffs = Staff::all();
        return view('attendances.index', compact('attendances','staffs'));
    }

    public function checkIn(Request $request, Staff $staff) {
        $today = now()->toDateString();
        Attendance::updateOrCreate(
            ['staff_id' => $staff->id, 'date' => $today],
            ['check_in' => now()->toTimeString(), 'status' => 'Present']
        );
        return back()->with('success','Check-in recorded for '.$staff->name);
    }

    public function checkOut(Request $request, Staff $staff) {
        $today = now()->toDateString();
        $attendance = Attendance::where('staff_id',$staff->id)->where('date',$today)->first();
        if ($attendance) {
            $attendance->update(['check_out'=>now()->toTimeString()]);
        }
        return back()->with('success','Check-out recorded.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id'=>'required',
            'date'=>'required|date',
            'status'=>'required'
        ]);

        Attendance::create($request->all());
        return back()->with('success','Attendance recorded.');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $attendance->update($request->all());
        return back()->with('success','Attendance updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('success','Deleted successfully.');
    }
}
