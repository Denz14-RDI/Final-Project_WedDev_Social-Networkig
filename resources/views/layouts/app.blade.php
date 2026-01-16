<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'PUPCOM')</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-[#F2EADA]">

  <div class="min-h-screen">
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] min-h-screen">

      {{-- ONE SIDEBAR FOR ALL PAGES --}}
      @include('partials.sidebar')

      {{-- PAGE CONTENT --}}
      <main class="@yield('main_class', 'bg-[#F3F3F3]')">
        @yield('content')
      </main>

    </div>
  </div>

</body>
</html>
