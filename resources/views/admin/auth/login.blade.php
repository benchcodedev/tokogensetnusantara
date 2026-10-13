<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Toko Genset Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: var(--bg); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px;">

    <div style="width: 100%; max-width: 440px;">
        <!-- Logo & Header -->
        <div style="text-align: center; margin-bottom: 32px;">
            <div class="brand-logo-circle" style="background-color: var(--yellow); color: var(--ink); width: 56px; height: 56px; font-size: 26px; margin: 0 auto 16px;">
                V
            </div>
            <h1 style="font-size: 1.8rem; margin-bottom: 6px;">Panel Admin</h1>
            <p style="font-size: 0.95rem; color: var(--muted);">Toko Genset Nusantara (V-GEN Jogja)</p>
        </div>

        <!-- Form Card -->
        <div class="admin-card" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Administrator</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', 'admin@tokogenset.com') }}" 
                        required 
                        class="form-control" 
                        placeholder="admin@tokogenset.com"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="form-control" 
                        placeholder="••••••••"
                    >
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-check">
                        <input type="checkbox" name="remember" value="1">
                        <span style="font-size: 0.9rem; color: var(--muted);">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; height: 50px;">
                    Masuk ke Admin Panel
                </button>
            </form>

            <div style="margin-top: 24px; text-align: center; border-top: var(--border-thin); padding-top: 16px;">
                <a href="{{ route('home') }}" style="font-size: 0.875rem; color: var(--muted);">
                    &larr; Kembali ke Halaman Depan
                </a>
            </div>
        </div>
    </div>

</body>
</html>
