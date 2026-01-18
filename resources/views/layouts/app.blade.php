<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'PUPCOM')</title>

  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Alpine (for popouts/modals) --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-app-page text-app-text">
  <div class="min-h-screen">
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] h-screen overflow-hidden">

      {{-- LEFT SIDEBAR --}}
      @include('partials.sidebar')

      {{-- PAGE CONTENT --}}
      <main class="@yield('main_class', 'bg-app-page') h-screen overflow-hidden">
        @yield('content')
      </main>

    </div>
  </div>
</body>

</html>