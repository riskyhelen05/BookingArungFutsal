<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;

class AuthController extends Controller
{
    // ==================
    // Show Login Page
    // ==================
    public function showLogin()
    {
        return view('auth.login');
    }

    // ==================
    // Show Register Page
    // ==================
    public function showRegister()
    {
        return view('auth.register');
    }

    // ==================
    // Login
    // ==================
public function login(Request $request)
{
    $request->validate([
        'login'    => 'required|string',
        'password' => 'required|string',
    ]);

    $field = filter_var($request->login, FILTER_VALIDATE_EMAIL)
        ? 'email'
        : 'username';

    $credentials = [
        $field     => $request->login,
        'password' => $request->password,
    ];

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
    return back()
        ->withInput($request->only('login', 'remember'))
        ->withErrors([
            'login' => 'Email/username atau password salah.'
        ]);
}

$request->session()->regenerate();

$user = Auth::user();

// ActivityLog sementara jangan dulu

return match($user->role) {
    'admin' => redirect()->route('admin.dashboard'),
    default => redirect()->route('user.beranda'),
};
}

    // ==================
    // Register (role user saja)
    // ==================
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|max:150|unique:users,email',
            'phone'                 => 'required|string|max:20',
            'username'              => 'required|string|max:50|unique:users,username|alpha_dash',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'phone.required'        => 'Nomor HP wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'username.alpha_dash'   => 'Username hanya boleh huruf, angka, strip, dan underscore.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'user', // register selalu role user
        ]);

        // Catat activity log
        ActivityLog::record(
        action: 'auth.register',
        description: $user->name . ' berhasil mendaftar',
        subjectType: 'User',
        subjectId: $user->id,
        userId: $user->id // 🔥 WAJIB TAMBAH INI
        );

        Auth::login($user);

        return redirect()->route('user.beranda')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function beranda()
{
    $user = auth()->user();

    $notifications = Notification::where('user_id', $user->id)
        ->latest('created_at')
        ->limit(5)
        ->get();

    $unreadCount = Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->count();

    view()->share('notifications', $notifications);
    view()->share('unreadCount', $unreadCount);

    return view('user.beranda', compact('notifications', 'unreadCount'));
}

    // ==================
    // Logout
    // ==================
    public function logout(Request $request)
    {
        ActivityLog::record(
            action: 'auth.logout',
            description: Auth::user()->name . ' logout',
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout.');
    }
}