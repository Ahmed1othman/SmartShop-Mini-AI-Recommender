<!DOCTYPE html>
<html
    class="light"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ $title ?? 'SmartShop Mini' }}</title>

    {{-- Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @livewireScripts
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-background text-on-background selection:bg-primary-container selection:text-on-primary-container antialiased"
>
    <!-- Flash Messages -->
    @if (session('success'))
        <div
            class="fixed right-6 top-24 z-[100] flex items-center gap-3 rounded-xl bg-green-600 px-6 py-3 text-white shadow-2xl transition-all"
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
        >
            <span class="material-symbols-outlined">check_circle</span>
            <p class="font-headline font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Top Navigation Bar -->
    <nav class="font-headline fixed top-0 z-50 w-full bg-slate-50/80 shadow-sm backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a
                class="text-xl font-bold tracking-tight text-slate-900"
                href="{{ route('home') }}"
            >
                SmartShop Mini
            </a>
            <div class="hidden items-center gap-8 md:flex">
                <a
                    class="{{ request()->routeIs('home') ? 'text-primary font-semibold border-b-2 border-primary' : 'text-slate-600 hover:text-primary' }} transition-colors"
                    href="{{ route('home') }}"
                >Home</a>
                <a
                    class="{{ request()->routeIs('cart.index') ? 'text-primary font-semibold border-b-2 border-primary' : 'text-slate-600 hover:text-primary' }} transition-colors"
                    href="{{ route('cart.index') }}"
                >Cart</a>
            </div>
            <div class="flex items-center gap-4">
                <a
                    class="hover:text-primary relative p-2 text-slate-600 duration-200 active:scale-95"
                    href="{{ route('cart.index') }}"
                >
                    <span class="material-symbols-outlined">shopping_cart</span>
                    @if (session()->has('cart') && count(session('cart')) > 0)
                        <span
                            class="bg-primary absolute right-0 top-0 flex size-4 items-center justify-center rounded-full text-[10px] font-bold text-white"
                        >{{ count(session('cart')) }}</span>
                    @endif
                </a>
                @auth
                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf
                        <button
                            class="hover:text-error p-2 text-slate-600 duration-200 active:scale-95"
                            type="submit"
                        >
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
                @else
                    <a
                        class="hover:text-primary p-2 text-slate-600 duration-200 active:scale-95"
                        href="{{ route('login') }}"
                    >
                        <span class="material-symbols-outlined">login</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-16">
        {{ $slot }}
    </main>

    <!-- Footer Section -->
    <footer class="font-body w-full rounded-t-3xl bg-slate-100 text-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-8 py-12 md:flex-row">
            <div class="text-lg font-semibold text-slate-800">
                SmartShop Mini
            </div>
            <div class="text-slate-500">
                © {{ date('Y') }} SmartShop Mini. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>
