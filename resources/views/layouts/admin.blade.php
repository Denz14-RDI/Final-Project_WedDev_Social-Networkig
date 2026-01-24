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
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[320px_1fr]">

        @include('admin.partials.sidebar')

        <main class="min-h-screen overflow-hidden">
            <div class="h-screen overflow-y-auto px-4 sm:px-6 lg:px-10 py-8">

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
</body>

</html>