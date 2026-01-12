@extends('layouts.guest')
@section('title', 'Welcome')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
  <!-- Left panel -->
  <div class="bg-[var(--brand)] text-white flex items-center justify-center p-10">
    <div class="max-w-sm">
      <div class="w-16 h-16 rounded-2xl bg-[var(--accent)] flex items-center justify-center font-bold text-2xl text-[var(--brand)]">
        P
      </div>

      <h1 class="mt-6 text-3xl font-semibold">Welcome to PUPCOM</h1>
      <p class="mt-3 text-white/80 text-sm">
        Connect with the PUP community. Share updates, discover events, and collaborate.
      </p>
    </div>
  </div>

  <!-- Right panel -->
  <div class="bg-[var(--bg)] flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold">Get started</h2>
      <p class="text-sm text-[var(--muted)] mb-6">Sign in or create an account.</p>

      <div class="space-y-3">
        <a href="{{ route('login') }}" class="block text-center rounded-lg bg-[var(--brand)] text-white py-2 font-medium">
          Sign in
        </a>
        <a href="{{ route('register') }}" class="block text-center rounded-lg border border-black/10 py-2 font-medium">
          Create account
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
