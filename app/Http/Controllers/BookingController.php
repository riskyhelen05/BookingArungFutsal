<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    /**
     * Halaman pilih lapangan & jadwal (Step 1)
     */
    public function index(Request $request)
    {
        $fields = Field::where('status', 'available')->get();

        $selectedDate    = $request->get('date', now()->format('Y-m-d'));
        $selectedFieldId = $request->get('field_id', optional($fields->first())->id);
        $selectedDuration = (int) $request->get('duration', 1);

        $selectedField = $fields->firstWhere('id', $selectedFieldId) ?? $fields->first();

        // Build schedule: 07:00 - 23:00
        $schedule = [];
        if ($selectedField) {
            for ($h = 7; $h < 23; $h++) {
                $slotData = $selectedField->getSlotStatus($selectedDate, $h);
                $schedule[] = [
                    'hour'   => $h,
                    'label'  => sprintf('%02d:00 - %02d:00', $h, $h + 1),
                    'status' => $slotData['status'],
                    'text'   => $slotData['label'],
                ];
            }
        }

        return view('booking.index', compact(
            'fields', 'selectedField', 'selectedDate', 'selectedDuration', 'schedule'
        ));
    }

    /**
     * Preview ringkasan booking (AJAX / form post)
     */
    public function preview(Request $request)
    {
        $request->validate([
            'field_id'  => 'required|exists:fields,id',
            'date'      => 'required|date|after_or_equal:today',
            'start_hour'=> 'required|integer|min:7|max:22',
            'duration'  => 'required|integer|min:1|max:8',
        ]);

        $field     = Field::findOrFail($request->field_id);
        $startHour = (int) $request->start_hour;
        $duration  = (int) $request->duration;
        $endHour   = $startHour + $duration;

        if ($endHour > 23) {
            return back()->withErrors(['duration' => 'Durasi melebihi jam operasional.']);
        }

        // Check all slots
        for ($h = $startHour; $h < $endHour; $h++) {
            $slot = $field->getSlotStatus($request->date, $h);
            if ($slot['status'] !== 'tersedia') {
                return back()->withErrors(['slot' => "Slot jam $h:00 tidak tersedia ({$slot['label']})."]);
            }
        }

        $total = $field->price_per_hour * $duration;

        return view('booking.preview', [
            'field'      => $field,
            'date'       => $request->date,
            'startTime'  => sprintf('%02d:00', $startHour),
            'endTime'    => sprintf('%02d:00', $endHour),
            'duration'   => $duration,
            'total'      => $total,
            'userName'   => Auth::check() ? Auth::user()->name : 'Tamu',
        ]);
    }

    /**
     * Simpan booking ke database (Step 2 → Step 3)
     */
    public function store(Request $request)
    {
        $request->validate([
            'field_id'   => 'required|exists:fields,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required',
            'duration'   => 'required|integer|min:1',
        ]);

        $field    = Field::findOrFail($request->field_id);
        $startH   = (int) explode(':', $request->start_time)[0];
        $endH     = (int) explode(':', $request->end_time)[0];
        $duration = $endH - $startH;

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id'       => Auth::id() ?? '00000000-0000-0000-0000-000000000001',
                'field_id'      => $field->id,
                'booking_date'  => $request->date,
                'start_time'    => $request->start_time . ':00',
                'end_time'      => $request->end_time . ':00',
                'duration_hours'=> $duration,
                'price_per_hour'=> $field->price_per_hour,
                'total_amount'  => $field->price_per_hour * $duration,
                'status'        => 'pending',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        return redirect()->route('user.payment.show', $booking->id);
    }

    /**
     * Daftar booking milik user
     */
    public function myBookings()
    {
        $bookings = Booking::with(['field', 'payment'])
            ->where('user_id', Auth::id() ?? '00000000-0000-0000-0000-000000000001')
            ->latest()
            ->paginate(10);

        return view('booking.my-bookings', compact('bookings'));
    }

    /**
     * Detail booking
     */
    public function show(string $id)
    {
        $booking = Booking::with(['field', 'payment'])->findOrFail($id);
        return view('booking.show', compact('booking'));
    }

    /**
     * AJAX: get slots for a date + field
     */
    public function slots(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date'     => 'required|date',
        ]);

        $field    = Field::findOrFail($request->field_id);
        $schedule = [];

        for ($h = 7; $h < 23; $h++) {
            $slot      = $field->getSlotStatus($request->date, $h);
            $schedule[] = [
                'hour'   => $h,
                'label'  => sprintf('%02d:00 - %02d:00', $h, $h + 1),
                'status' => $slot['status'],
                'text'   => $slot['label'],
            ];
        }

        return response()->json($schedule);
    }
}
