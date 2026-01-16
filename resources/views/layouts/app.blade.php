<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'PUPCOM')</title>

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
  <div class="min-h-screen">
    {{-- IMPORTANT: no overflow-hidden here (popover needs to overflow) --}}
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] h-screen">

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