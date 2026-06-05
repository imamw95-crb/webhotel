<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name', 'Hotel') }}</title>
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
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Skip to content -->
    <a href="#admin-main" class="fixed -top-full left-4 z-[99999] px-6 py-3 bg-gold-400 text-navy-900 font-semibold rounded-lg transition-[top] duration-300 focus:top-4">
        Skip to main content
    </a>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 bg-black/50 z-20 lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-navy-900 text-white transform transition-transform duration-200 lg:translate-x-0 flex flex-col">
            <div class="p-5 border-b border-white/10">
                <h1 class="text-xl font-bold text-gold-400"><i class="fa-solid fa-hotel mr-2"></i>{{ config('app.name', 'Hotel') }}</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-gauge w-5"></i> Dashboard
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-calendar-check w-5"></i> Bookings
                </a>
                <a href="{{ route('admin.room-types.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.room-types.*') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-bed w-5"></i> Room Types
                </a>
                <a href="{{ route('admin.facilities.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.facilities.*') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-star w-5"></i> Facilities
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.gallery.*') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-images w-5"></i> Gallery
                </a>
                <a href="{{ route('admin.sections.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.sections.*') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-pager w-5"></i> Page Sections
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-gold-400 text-navy-900 font-semibold' : 'text-gray-300 hover:bg-white/10' }}">
                    <i class="fa-solid fa-gear w-5"></i> Settings
                </a>
            </nav>
            <div class="p-4 border-t border-white/10">
                <a href="/" target="_blank" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-300 hover:bg-white/10 text-sm">
                    <i class="fa-solid fa-external-link w-5"></i> View Website
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white shadow-sm border-b px-6 py-3 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page content -->
            <main id="admin-main" class="flex-1 overflow-y-auto p-6" tabindex="-1">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
