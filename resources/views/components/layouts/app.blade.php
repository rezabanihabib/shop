<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- The navbar with `sticky` and `full-width` --}}
    <x-nav sticky full-width>

        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>App</div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                <x-button label="dashboard" link="{{ route('dashboard.index') }}" class="btnost btn-sm" responsive />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    @method("Post")
                    <x-button label="logout" class="btn btn-sm" type="submit" responsive />
                </form>
                @else
                <x-button label="login" link="{{ route('login') }}" class="btn btn-sm" responsive />
                @if (Route::has('register'))
                <x-button label="register" link="{{ route('register') }}" class="btn btn-sm" responsive />
                @endif
                @endauth
            </nav>
            @endif
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
</body>

</html>