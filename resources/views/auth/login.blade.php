<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name', 'Hotel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 800: '#1B2A4A', 900: '#0f1b30' },
                        gold: { 400: '#D4AF37', 500: '#c4a030', 600: '#b08d28' },
                    },
                    fontFamily: {
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Cormorant Garamond', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .login-input {
            transition: all 0.2s ease;
        }
        .login-input:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }
        .btn-submit {
            transition: all 0.35s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(212, 175, 55, 0.35);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .bg-pattern {
            background-image: radial-gradient(rgba(212, 175, 55, 0.06) 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>
<body class="min-h-screen bg-[#09090f] flex items-center justify-center p-4 bg-pattern">
    <div class="w-full max-w-md">
        {{-- Logo & Title --}}
        <div class="text-center mb-8 reveal">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center shadow-lg shadow-gold-400/20">
                <i class="fa-solid fa-hotel text-navy-900 text-2xl"></i>
            </div>
            <h1 class="font-display text-3xl font-bold text-gold-400 mb-1">{{ config('app.name', 'Hotel') }}</h1>
            <p class="text-gray-400 text-sm">Admin Panel Login</p>
        </div>

        {{-- Login Card --}}
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm flex items-center gap-2" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-300 mb-1.5">Username atau Email</label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username"
                           class="login-input w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 outline-none">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="login-input w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 outline-none">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer hover:text-gray-300 transition-colors">
                        <input type="checkbox" name="remember"
                               class="rounded border-white/20 bg-white/5 text-gold-400 focus:ring-gold-400/50 focus:ring-offset-0"
                               style="accent-color: #D4AF37">
                        Remember me
                    </label>
                </div>
                <button type="submit" class="btn-submit w-full bg-gradient-to-r from-gold-400 to-gold-500 hover:to-gold-600 text-navy-900 font-semibold py-3.5 rounded-xl transition text-sm uppercase tracking-wider">
                    <i class="fa-solid fa-lock-open mr-2"></i> Sign In
                </button>
            </form>
        </div>

        {{-- Back Link --}}
        <p class="text-center text-gray-500 text-sm mt-6">
            <a href="/" class="hover:text-gold-400 transition inline-flex items-center gap-1.5 group">
                <i class="fa-solid fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                Back to Website
            </a>
        </p>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal { animation: fadeInUp 0.8s ease both; }
    </style>
</body>
</html>
