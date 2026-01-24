<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - PUPCOM</title>

    {{-- set theme before paint (prevents flash) --}}
    <script>
        (() => {
            const saved = localStorage.getItem('theme'); // "dark" | "light" | null
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const useDark = saved ? saved === 'dark' : prefersDark;
            document.documentElement.classList.toggle('dark', useDark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-app-page text-app">
    <div class="min-h-screen" x-data="{ sidebarOpen:false }" @keydown.escape.window="sidebarOpen=false">

        {{-- Mobile backdrop --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"
            @click="sidebarOpen=false"
            aria-hidden="true">
        </div>

        <div class="min-h-[100dvh] lg:h-screen grid grid-cols-1 lg:grid-cols-[320px_1fr]">

            @include('admin.partials.sidebar')

            <main class="min-h-[100dvh] lg:h-screen overflow-hidden">

                {{-- Mobile topbar --}}
                <div class="lg:hidden border-b border-app bg-app-sidebar/95 backdrop-blur">
                    <div class="px-4 py-3 flex items-center gap-3">
                        <button
                            type="button"
                            class="h-10 w-10 rounded-xl bg-app-input border border-app text-app inline-flex items-center justify-center"
                            @click="sidebarOpen=true"
                            aria-label="Open menu">
                            ☰
                        </button>

                        <div class="font-extrabold text-app truncate">
                            @yield('title', 'Admin')
                        </div>

                        <div class="flex-1"></div>
                    </div>
                </div>

                <div class="h-[calc(100dvh-56px)] lg:h-screen overflow-y-auto px-4 sm:px-6 lg:px-10 py-8">

                    {{-- Flash Messages (match app style) --}}
                    @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-xl">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-xl">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>