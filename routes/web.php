<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BaggageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markRead'])->name('notifications.markRead');
});


Route::middleware(['auth', 'role:Admin|Staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('airlines', AirlineController::class);
    Route::resource('flights', FlightController::class);
    Route::resource('passengers', PassengerController::class);
    Route::resource('baggages', BaggageController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('users', UsersController::class);

    // Flight operations
    Route::put('flights/{id}/assign-gate', [FlightController::class, 'assignGate'])->name('flights.assignGate');
    Route::put('flights/{id}/update-boarding-status', [FlightController::class, 'updateBoardingStatus'])->name('flights.updateBoardingStatus');

    Route::get('/flights/get/history', [FlightController::class, 'indexFlightHistory'])->name('flights.history');
    Route::get('/flights/history/{flight}', [FlightController::class, 'showFlightHistory'])->name('flights.history.show');

    // Passenger check-in
    Route::post('/passengers/{passenger}/checkin', [PassengerController::class, 'checkIn'])
        ->name('passengers.checkin');
    // Generate boarding pass (PDF)
    Route::get('/passengers/{passenger}/boarding-pass', [PassengerController::class, 'boardingPass'])
        ->name('passengers.boarding-pass');

    Route::resource('shifts', ShiftController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::post('attendances/{staff}/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.checkin');
    Route::post('attendances/{staff}/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.checkout');
    Route::resource('leave-requests', LeaveRequestController::class);

    Route::resource('support-tickets', SupportTicketController::class);
    Route::put('support-tickets/{ticket}/assign', [SupportTicketController::class, 'assignStaff'])->name('support-tickets.assign');
    Route::post('support-tickets/{ticket}/respond', [SupportTicketController::class, 'respond'])->name('support-tickets.respond');
    Route::put('support-tickets/{ticket}/resolve', [SupportTicketController::class, 'resolve'])->name('support-tickets.resolve');
});

require __DIR__ . '/auth.php';
