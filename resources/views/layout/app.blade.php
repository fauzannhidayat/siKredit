<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pengajuan Kredit') - PT Capella Multidana</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            {{-- Tailwind CDN dihapus dari contoh ini agar ringkas. --}}
            {{-- Tetap gunakan blok <style> Tailwind bawaan Anda di sini, tidak diubah. --}}
        @endif

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between">
        <button @click="sidebarOpen = true" class="text-slate-600" aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="font-semibold text-slate-900">PT Capella Multidana</h1>
        <div class="w-6"></div>
    </div>

    <div
        x-cloak
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/40 z-30 lg:hidden">
    </div>

    <div class="flex min-h-screen">

        @include('layout.sidebar')

        <div class="flex-1 min-w-0">
            <main class="max-w-6xl mx-auto px-4 py-8">
            <main class="max-w-6xl mx-auto px-4 py-8">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>