<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
        }

        .avatar {
            width: 72px;
            height: 72px;
            background: #4f46e5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin: 0 auto 20px;
        }

        h1 {
            font-size: 22px;
            color: #1e1e2e;
            margin-bottom: 6px;
        }

        .role-badge {
            display: inline-block;
            background: #ede9fe;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 99px;
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            padding: 6px 0;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .info-row:last-child { border-bottom: none; }
        .info-row span:first-child { color: #999; }
        .info-row span:last-child { font-weight: 500; color: #222; }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-logout {
            display: block;
            width: 100%;
            padding: 12px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-logout:hover { background: #dc2626; }
    </style>
</head>
<body>

<div class="card">

    {{-- Flash success (dari register / login) --}}
    @if (session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="avatar">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>

    <h1>Halo, {{ Auth::user()->name }}!</h1>

    <div class="role-badge">{{ Auth::user()->role }}</div>

    <div class="info-box">
        <div class="info-row">
            <span>Username</span>
            <span>{{ Auth::user()->username }}</span>
        </div>
        <div class="info-row">
            <span>Email</span>
            <span>{{ Auth::user()->email }}</span>
        </div>
        <div class="info-row">
            <span>No. HP</span>
            <span>{{ Auth::user()->phone }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>

</div>

</body>
</html>