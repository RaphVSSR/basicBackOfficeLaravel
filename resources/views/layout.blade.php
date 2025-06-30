<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'EauPure')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite("resources/css/app.css")

</head>
<body class="bg-[var(--evian-gris-tres-clair)] font-sans min-h-screen text-[var(--evian-bleu)] flex flex-col">

    {{-- Navbar personnalisable --}}
    <header class="w-full sticky top-0 z-9999">
        @yield("navbar")
    </header>

    {{-- Contenu principal --}}
    <main class="flex-1 w-full">
        @yield("content")
    </main>

    {{-- Footer Evian style --}}
    <footer class="w-full bg-white text-[var(--evian-bleu)] py-8 drop-shadow-sm">
        
        @yield("footer")

    </footer>
</body>
</html>
