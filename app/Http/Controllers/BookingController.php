<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\BlockedSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $fields = Field::where('status', 'available')->get();

        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        $selectedFieldId = $request->get('field_id', optional($fields->first())->id);

        $selectedField = $fields->firstWhere('id', $selectedFieldId) ?? $fields->first();

        $schedule = [];

        if ($selectedField) {
            for ($h = 7; $h < 23; $h++) {

                $start = sprintf('%02d:00:00', $h);
                $end   = sprintf('%02d:00:00', $h + 1);

                if (BlockedSlot::isBlocked($selectedField->id, $selectedDate, $start, $end)) {
                    $schedule[] = [
                        'hour' => $h,
                        'label' => sprintf('%02d:00 - %02d:00', $h, $h + 1),
                        'status' => 'blocked',
                        'text' => 'Diblokir Admin'
                    ];
                } else {
                    $slot = $selectedField->getSlotStatus($selectedDate, $h);

                    $schedule[] = [
                        'hour' => $h,
                        'label' => sprintf('%02d:00 - %02d:00', $h, $h + 1),
                        'status' => $slot['status'],
                        'text' => $slot['label'],
                    ];
                }
            }
        }

        return view('booking.index', compact(
            'fields', 'selectedField', 'selectedDate', 'schedule'
        ));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'field_id'  => 'required|exists:fields,id',
            'date'      => 'required|date',
            'start_hour'=> 'required|integer|min:7|max:22',
            'duration'  => 'required|integer|min:1|max:8',
        ]);

        $field     = Field::findOrFail($request->field_id);
        $startHour = $request->start_hour;
        $duration  = $request->duration;
        $endHour   = $startHour + $duration;

        for ($h = $startHour; $h < $endHour; $h++) {

            $start = sprintf('%02d:00:00', $h);
            $end   = sprintf('%02d:00:00', $h + 1);

            if (BlockedSlot::isBlocked($request->field_id, $request->date, $start, $end)) {
                return back()->withErrors([
                    'slot' => "Jam $h:00 diblokir admin"
                ]);
            }

            $slot = $field->getSlotStatus($request->date, $h);

            if ($slot['status'] !== 'tersedia') {
                return back()->withErrors([
                    'slot' => "Jam $h:00 tidak tersedia"
                ]);
            }
        }

        $total = $field->price_per_hour * $duration;

        return view('booking.preview', compact(
            'field','total','duration'
        ) + [
            'date' => $request->date,
            'startTime' => sprintf('%02d:00', $startHour),
            'endTime' => sprintf('%02d:00', $endHour),
            'userName' => Auth::user()->name ?? 'Tamu'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id'   => 'required|exists:fields,id',
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required',
        ]);

        $field = Field::findOrFail($request->field_id);

        $startH = (int) explode(':', $request->start_time)[0];
        $endH   = (int) explode(':', $request->end_time)[0];
        $duration = $endH - $startH;

        if ($request->start_time >= $request->end_time) {
            return back()->withErrors(['error' => 'Jam tidak valid']);
        }

        $start = $request->start_time . ':00';
        $end   = $request->end_time . ':00';

        if (BlockedSlot::isBlocked($request->field_id, $request->date, $start, $end)) {
            return back()->withErrors(['error' => 'Jadwal diblokir admin']);
        }

        DB::beginTransaction();
        try {

            $booking = Booking::create([
                'user_id'       => Auth::id() ?? '00000000-0000-0000-0000-000000000001',
                'field_id'      => $field->id,
                'booking_date'  => $request->date,
                'start_time'    => $start,
                'end_time'      => $end,
                'duration_hours'=> $duration,
                'price_per_hour'=> $field->price_per_hour,
                'total_amount'  => $field->price_per_hour * $duration,
                'status'        => 'pending',
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('user.payment.show', $booking->id);
    }

    public function slots(Request $request)
    {
        $field = Field::findOrFail($request->field_id);
        $schedule = [];

        for ($h = 7; $h < 23; $h++) {

            $start = sprintf('%02d:00:00', $h);
            $end   = sprintf('%02d:00:00', $h + 1);

            if (BlockedSlot::isBlocked($request->field_id, $request->date, $start, $end)) {
                $schedule[] = [
                    'hour' => $h,
                    'label' => sprintf('%02d:00 - %02d:00', $h, $h + 1),
                    'status' => 'blocked',
                    'text' => 'Diblokir Admin'
                ];
            } else {
                $slot = $field->getSlotStatus($request->date, $h);

                $schedule[] = [
                    'hour' => $h,
                    'label' => sprintf('%02d:00 - %02d:00', $h, $h + 1),
                    'status' => $slot['status'],
                    'text' => $slot['label'],
                ];
            }
        }

        return response()->json($schedule);
    }
}