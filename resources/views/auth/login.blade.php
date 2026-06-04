<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name', 'Hotel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 800: '#1B2A4A', 900: '#0f1b30' },
                        gold: { 400: '#D4AF37', 500: '#c4a030' },
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-navy-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="font-display text-3xl font-bold text-gold-400 mb-2"><i class="fa-solid fa-hotel mr-2"></i>{{ config('app.name', 'Hotel') }}</h1>
            <p class="text-gray-400">Admin Panel Login</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username atau Email</label>
                    <input type="text" name="login" value="{{ old('login') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 outline-none">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-gold-400 focus:ring-gold-400">
                        Remember me
                    </label>
                </div>
                <button type="submit" class="w-full bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold py-3 rounded-xl transition">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-gray-500 text-sm mt-6">
            <a href="/" class="hover:text-gold-400 transition"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Website</a>
        </p>
    </div>
</body>
</html>
