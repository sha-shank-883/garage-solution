<?php
namespace App\Http\Controllers\ViewController;

use App\Booking;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Booking::all();
        $bookingDetails = session('booking_details', []);

        return view('view.calendar', ['events' => json_encode($events), 'bookingDetails' => $bookingDetails]);
    }

    public function saveBooking(Request $request)
    {

        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        session(['booking_details' => $request->only('start', 'end')]);

        return response()->json([
            'success' => true,
            'message' => 'Booking details saved to session.',
        ]);
    }


}
