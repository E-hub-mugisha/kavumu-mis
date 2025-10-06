<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::latest()->get();
        $users = User::all();
        return view('staff.index', compact('staffs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'nullable',
            'position' => 'required',
            'department' => 'nullable',
            'hire_date' => 'nullable',
            'status' => 'required',
        ]);

        // Generate a random 10-character password
        $randomPassword = Str::random(10);

        // 1️⃣ Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomPassword),
            'role' => 'Staff',
        ]);

        // 2️⃣ Create the staff and link to user_id
        Staff::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'department' => $request->department,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
        ]);

        // Optional: Return or email the password to the staff
        return redirect()->back()->with('success', 'Staff created successfully. Generated password: ' . $randomPassword);
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:staff,email,' . $staff->id,
            'phone'     => 'nullable',
            'position'  => 'required',
            'department' => 'nullable',
            'hire_date' => 'nullable|date',
            'status'    => 'required'
        ]);

        $staff->update($request->all());
        return back()->with('success', 'Staff details updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return back()->with('success', 'Staff record deleted successfully.');
    }
}
