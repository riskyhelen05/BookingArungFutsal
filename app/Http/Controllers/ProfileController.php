<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile.index');
    }

    public function edit()
    {
        return view('user.profile.edit');
    }

    public function update(Request $request)
    {
       $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required|min:10|max:15',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = auth()->user();

    $avatarPath = $user->avatar_url;

    if ($request->hasFile('avatar')) {

        if (
            $user->avatar_url &&
            \Storage::disk('public')->exists($user->avatar_url)
        ) {
            \Storage::disk('public')->delete($user->avatar_url);
        }

        $avatarPath = $request->file('avatar')
            ->store('avatars', 'public');
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'avatar_url' => $avatarPath,
    ]);

    return redirect()
        ->route('user.profile.edit')
        ->with('success', 'Perubahan berhasil disimpan');
    }

    public function username()
    {
        return view('user.profile.change-username');
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|max:50|unique:users,username,' . Auth::id(),
        ]);

        Auth::user()->update([
            'username' => $request->username,
        ]);

        return redirect()
            ->route('user.profile')
            ->with('success', 'Username berhasil diubah.');
    }

    public function password()
    {
        return view('user.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Password lama salah.'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()
            ->route('user.profile')
            ->with('success', 'Password berhasil diubah.');
    }

    public function privacy()
    {
        return view('user.profile.privacy-policy');
    }

    public function terms()
    {
        return view('user.profile.terms');
    }

    public function support()
    {
        return view('user.profile.support');
    }

    public function maps()
    {
        return view('user.profile.maps');
    }
}