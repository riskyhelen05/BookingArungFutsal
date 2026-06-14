<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockedSlot;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BlockedSlotController extends Controller
{
public function index(Request $request)
{
    $fields = Field::all();

$selectedDate =
    $request->block_date ??
    now()->format('Y-m-d');

$selectedField =
    $request->field_id ??
    $fields->first()?->id;

    $slots = [];

    for ($hour = 9; $hour <= 20; $hour++) {

        $start = sprintf('%02d:00:00', $hour);
        $end   = sprintf('%02d:00:00', $hour + 1);

        $status = 'available';

        // cek maintenance
$blocked = BlockedSlot::where('field_id', $selectedField)
    ->where('block_date', $selectedDate)
    ->where('start_time', $start)
    ->first();

if ($blocked) {
    $status = $blocked->status;
} else {

            $booking = Booking::where('field_id', $selectedField)
                ->where('booking_date', $selectedDate)
                ->where('start_time', $start)
                ->first();

            if ($booking) {

                if (
                    $booking->status === 'confirmed' ||
                    $booking->status === 'completed'
                ) {
                    $status = 'confirmed';
                }

                if (
                    $booking->status === 'pending' ||
                    $booking->status === 'waiting_confirmation'
                ) {
                    $status = 'pending';
                }
            }
        }

        $slots[] = [
            'start' => substr($start,0,5),
            'end'   => substr($end,0,5),
            'status'=> $status
        ];
    }

    $blockedSlots = BlockedSlot::with('field')
        ->latest()
        ->get();

    return view(
        'admin.blocked.index',
        compact(
            'fields',
            'slots',
            'blockedSlots',
            'selectedDate',
            'selectedField'
        )
    );
}
public function review(Request $request)
{
    $request->validate([
        'field_id' => 'required',
        'block_date' => 'required',
        'slots' => 'required|array|min:1',
        'status' => 'required'
    ]);

    $field = Field::findOrFail($request->field_id);

    return view(
        'admin.blocked.review',
        [
            'field'  => $field,
            'date'   => $request->block_date,
            'slots'  => $request->slots,
            'status' => $request->status,
            'notes'  => $request->notes,
        ]
    );
}

public function confirm(Request $request)
{
    $request->validate([
        'field_id'   => 'required',
        'block_date' => 'required|date',
        'slots'      => 'required|array|min:1',
        'status'     => 'required'
    ]);

foreach ($request->slots as $slot) {

    [$start, $end] = explode(' - ', $slot);

    $exists = BlockedSlot::where([
        'field_id'   => $request->field_id,
        'block_date' => $request->block_date,
        'start_time' => $start . ':00'
    ])->exists();

    if (!$exists) {

        BlockedSlot::create([
            'field_id'   => $request->field_id,
            'block_date' => $request->block_date,
            'start_time' => $start . ':00',
            'end_time'   => $end . ':00',
            'status'     => $request->status,
            'notes'      => $request->notes,
            'created_by' => Auth::id(),
        ]);

    }
}

    return redirect()
        ->route('admin.jadwal')
        ->with('success', 'Jadwal berhasil diblokir');
}

    public function store(Request $request)
    {
        $request->validate([
            'field_id'   => 'required|exists:fields,id',
            'block_date' => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required',
            'notes'      => 'nullable|string'
        ]);

        if ($request->start_time >= $request->end_time) {
            return back()->withErrors(['error' => 'Jam tidak valid']);
        }

        BlockedSlot::create([
            'field_id'   => $request->field_id,
            'block_date' => $request->block_date,
            'start_time' => $request->start_time . ':00',
            'end_time'   => $request->end_time . ':00',
            'status' => 'maintenance',
            'notes'      => $request->notes,
            'created_by' => Auth::id()
        ]);

        return back()->with('success', 'Jadwal berhasil diblokir');
    }

public function manage(Request $request)
{
    $query = BlockedSlot::with(['field', 'creator']);

    if ($request->filled('date')) {
        $query->whereDate('block_date', $request->date);
    }

    if ($request->filled('field')) {
        $query->where('field_id', $request->field);
    }

    $blockedSlots = $query
        ->latest('block_date')
        ->paginate(10)
        ->withQueryString();

    $fields = Field::all();

    // Statistik kartu atas
    $statsQuery = BlockedSlot::query();

    if ($request->filled('date')) {
        $statsQuery->whereDate('block_date', $request->date);
    }

    if ($request->filled('field')) {
        $statsQuery->where('field_id', $request->field);
    }

    $totalBlocked = (clone $statsQuery)->count();

    $maintenanceCount = (clone $statsQuery)
        ->where('status', 'maintenance')
        ->count();

    $closedCount = (clone $statsQuery)
        ->where('status', 'closed')
        ->count();

    return view(
        'admin.blocked.manage',
        compact(
            'blockedSlots',
            'fields',
            'totalBlocked',
            'maintenanceCount',
            'closedCount'
        )
    );
}

    public function destroy($id)
    {
        BlockedSlot::findOrFail($id)->delete();
        return back()->with('success', 'Blokir dihapus');
    }
}