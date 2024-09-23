<?php

use Inertia\Inertia;
use App\Models\Service;
use App\Models\Employee;
use App\Bookings\SlotRangeGenerator;
use Illuminate\Support\Facades\Route;
use App\Bookings\ScheduleAvailability;
use Illuminate\Foundation\Application;
use App\Bookings\ServiceSlotAvailability;
use App\Http\Controllers\ProfileController;

// Carbon::setTestNow(now()->setTimeFromTimeString('12:00'));

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    $availability = (new ServiceSlotAvailability(Employee::get(), Service::find(1)))
        ->forPeriod(now()->startOfDay(), now()->addDay()->endOfDay());

    dd(
        $availability
    );

    // dd(
    //     
    // );
    // $employee = Employee::find(1);
    // $service = Service::find(1);

    // $availability = (new ScheduleAvailability($employee, $service))
    //     ->forPeriod(
    //         now()->startOfDay(),
    //         now()->addMonth()->endOfDay(),
    //     );
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
