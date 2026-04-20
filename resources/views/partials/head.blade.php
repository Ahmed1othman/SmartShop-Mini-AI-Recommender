<meta charset="utf-8" />
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
/>

<title>{{ $title ?? config('app.name') }}</title>

<link
    href="/favicon.ico"
    rel="icon"
    sizes="any"
>
<link
    type="image/svg+xml"
    href="/favicon.svg"
    rel="icon"
>
<link
    href="/apple-touch-icon.png"
    rel="apple-touch-icon"
>

<!-- Fonts -->
<link
    href="https://fonts.googleapis.com"
    rel="preconnect"
>
<link
    href="https://fonts.gstatic.com"
    rel="preconnect"
    crossorigin
>
<link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
    rel="stylesheet"
/>

<!-- Material Symbols -->
<link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet"
/>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
@livewireStyles
@livewireScripts
