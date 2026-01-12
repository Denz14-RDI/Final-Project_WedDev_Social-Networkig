<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'PUPCOM')</title>

  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-[var(--bg)] text-black">
  @yield('content')
</body>
</html>
