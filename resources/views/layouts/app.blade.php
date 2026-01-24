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
  <div class="min-h-screen" x-data="{ sidebarOpen:false }" @keydown.escape.window="sidebarOpen=false">

    {{-- Mobile backdrop --}}
    <div
      x-show="sidebarOpen"
      x-cloak
      class="fixed inset-0 bg-black/50 z-40 lg:hidden"
      @click="sidebarOpen=false"
      aria-hidden="true">
    </div>

    {{-- IMPORTANT: no overflow-hidden here (popover needs to overflow) --}}
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] min-h-[100dvh] lg:h-screen">

      {{-- LEFT SIDEBAR (becomes drawer on mobile) --}}
      @include('partials.sidebar')

      {{-- PAGE CONTENT --}}
      <main class="@yield('main_class', 'bg-app-page') min-h-[100dvh] lg:h-screen overflow-hidden">

        {{-- Mobile topbar (only on <lg) --}}
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
              @yield('title', 'PUPCOM')
            </div>

            <div class="flex-1"></div>
          </div>
        </div>

        @yield('content')
      </main>

    </div>
  </div>
</body>

</html>