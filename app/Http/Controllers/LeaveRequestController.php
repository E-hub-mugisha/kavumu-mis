<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Staff;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index() {
        $leaveRequests = LeaveRequest::with('staff')->latest()->paginate(10);
        $staffs = Staff::all();
        return view('leaves.index', compact('leaveRequests','staffs'));
    }

    public function store(Request $request) {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
            'leave_type' => 'required'
        ]);
        LeaveRequest::create($request->all());
        return back()->with('success','Leave Requestrequest submitted.');
    }

    public function update(Request $request, LeaveRequest $leaveRequest) {
        $request->validate(['status' => 'required|in:Pending,Approved,Rejected']);
        $leaveRequest->update(['status'=>$request->status]);
        return back()->with('success','Leave Requestrequest updated.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return back()->with('success', 'LeaveRequest record deleted successfully.');
    }
}
