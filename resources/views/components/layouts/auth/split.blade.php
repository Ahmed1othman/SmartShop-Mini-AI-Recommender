@props(['title' => null, 'description' => null])
<!DOCTYPE html>
<html
    class="light"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>

<head>
    @include('partials.head')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface flex min-h-screen items-center justify-center p-4 antialiased md:p-8">
    <main
        class="bg-surface-container-lowest shadow-on-surface/5 grid w-full max-w-6xl grid-cols-1 overflow-hidden rounded-xl shadow-2xl lg:grid-cols-2"
    >
        <!-- Left Side: Editorial Branding -->
        <section class="bg-primary relative hidden flex-col justify-between overflow-hidden p-12 lg:flex">
            <!-- Decorative Elements -->
            <div class="bg-primary-container/20 absolute right-0 top-0 -mr-20 -mt-20 h-96 w-96 rounded-full blur-3xl">
            </div>
            <div class="bg-tertiary-container/10 absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full blur-2xl">
            </div>

            <div class="relative z-10">
                <a
                    class="group mb-16 flex items-center gap-3"
                    href="{{ route('home') }}"
                >
                    <div
                        class="bg-surface-container-lowest flex h-10 w-10 items-center justify-center rounded-lg transition-transform group-hover:scale-110">
                        <span
                            class="material-symbols-outlined text-primary text-2xl"
                            style="font-variation-settings: 'FILL' 1;"
                        >shopping_bag</span>
                    </div>
                    <span class="font-headline text-2xl font-extrabold tracking-tight text-white">SmartShop Mini</span>
                </a>

                <h1 class="font-headline mb-6 text-5xl font-bold leading-tight text-white">
                    The Curated <br />
                    <span class="text-secondary-fixed">Shopping Experience.</span>
                </h1>
                <p class="text-primary-fixed-dim max-w-md text-lg leading-relaxed">
                    Step into our Digital Atelier—a space where every item is hand-picked for quality and aesthetic
                    excellence.
                </p>
            </div>

            <div class="relative z-10">
                <div class="mb-4 flex -space-x-3">
                    <img
                        class="border-primary h-10 w-10 rounded-full border-2 object-cover"
                        src="https://i.pravatar.cc/100?u=1"
                        alt="User 1"
                    />
                    <img
                        class="border-primary h-10 w-10 rounded-full border-2 object-cover"
                        src="https://i.pravatar.cc/100?u=2"
                        alt="User 2"
                    />
                    <img
                        class="border-primary h-10 w-10 rounded-full border-2 object-cover"
                        src="https://i.pravatar.cc/100?u=3"
                        alt="User 3"
                    />
                </div>
                <p class="text-sm font-medium text-white">Joined by 10k+ curators worldwide</p>
            </div>

            <!-- Foreground Graphic -->
            <div
                class="pointer-events-none absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 scale-150 transform opacity-20">
                <span
                    class="material-symbols-outlined text-[300px] text-white"
                    style="font-variation-settings: 'FILL' 1;"
                >store</span>
            </div>
        </section>

        <!-- Right Side: Auth Forms -->
        <section class="bg-surface-container-lowest flex flex-col justify-center p-8 md:p-16">
            <!-- Mobile Logo -->
            <div class="mb-10 flex items-center gap-2 lg:hidden">
                <span
                    class="material-symbols-outlined text-primary text-3xl"
                    style="font-variation-settings: 'FILL' 1;"
                >shopping_bag</span>
                <span class="font-headline text-on-surface text-xl font-bold tracking-tight">SmartShop Mini</span>
            </div>

            <div class="mx-auto w-full max-w-sm">
                <header class="mb-10">
                    <h2 class="font-headline text-on-surface mb-2 text-3xl font-bold">{{ $title }}</h2>
                    <p class="text-on-surface-variant">{{ $description }}</p>
                </header>

                {{ $slot }}
            </div>
        </section>
    </main>

    <!-- Floating Background Details for Desktop -->
    <div class="pointer-events-none fixed right-20 top-20 hidden h-32 w-32 opacity-20 xl:block">
        <div class="border-primary-container h-full w-full rounded-full border-[10px]"></div>
    </div>
    <div class="pointer-events-none fixed bottom-20 left-20 hidden h-48 w-48 opacity-10 xl:block">
        <div class="border-tertiary-fixed-dim h-full w-full rotate-45 rounded-xl border-[20px]"></div>
    </div>
</body>

</html>
