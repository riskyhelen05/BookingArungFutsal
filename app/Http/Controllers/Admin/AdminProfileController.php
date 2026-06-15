<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function account()
    {
        return view('admin.profile.account');
    }

    public function confirmAccount(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check(
            $request->password,
            Auth::user()->password
        )) {
            return back()->withErrors([
                'password' => 'Password yang dimasukkan salah.'
            ]);
        }

        return redirect()
            ->route('admin.profile.account')
            ->with('success', 'Akun berhasil dikonfirmasi.');
    }

    public function password()
    {
        return view('admin.profile.password');
    }

    public function updateLocation(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'operational_hours' => 'required',
    ]);

    Setting::updateOrCreate(
        ['id' => 1],
        [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,

            'google_maps' => 'https://maps.google.com/?q=Arung+Futsal',

            'operational_hours' => $request->operational_hours,
        ]
    );

    return redirect()
        ->route('admin.profile.location')
        ->with('success', 'Data berhasil diperbarui.');
    }   

    public function location()
    {
    $setting = Setting::first();

    return view(
        'admin.profile.location',
        compact('setting')
    );
    }

    public function payment()
    {
    $setting = Setting::first();

    return view(
        'admin.profile.payment',
        compact('setting')
    );
    }

public function updatePayment(Request $request)
{
    $request->validate([
        'bank_name' => 'required',
        'account_number' => 'required',
        'account_holder' => 'required',
    ]);

    Setting::updateOrCreate(
        ['id' => 1],
        [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
        ]
    );

    return redirect()
        ->route('admin.profile.payment')
        ->with('success', 'Data pembayaran berhasil diperbarui.');
}


     public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check(
            $request->current_password,
            auth()->user()->password
        )) {

            return back()->withErrors([
                'current_password' => 'Password lama salah.'
            ]);
        }

        auth()->user()->update([
            'password' => bcrypt($request->new_password)
        ]);

        return redirect()
            ->route('admin.profile.password')
            ->with('success', 'Password berhasil diperbarui.');
    }
}