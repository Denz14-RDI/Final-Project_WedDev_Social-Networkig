<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - PUPCOM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F6F6F6] text-gray-900">
    {{-- ✅ match user sidebar width --}}
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[320px_1fr]">
        @include('admin.partials.sidebar')

        <main class="min-h-screen">
            <div class="px-6 py-8 lg:px-10">

                {{-- ✅ Flash Messages --}}
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 text-green-800 font-semibold flex items-center gap-2">
                         {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 text-red-800 font-semibold flex items-center gap-2">
                         {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>