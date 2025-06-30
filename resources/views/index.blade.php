@extends('layout')

@section('title', 'Notre gamme de bouteilles')

<style>
    /* Chrome, Safari, Opera */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* IE, Edge, Firefox */
    .no-scrollbar {
        -ms-overflow-style: none;
        /* IE et Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>

@section("navbar")

    <nav class="w-full shadow-md bg-[var(--evian-blanc)] flex justify-between items-center pl-20 pr-10 py-4">
        <!-- Colonne gauche : Logo + nom du site, qui ramène à la racine -->
        <div class="flex items-center flex-1">
            <a href="{{ route('articles.index') }}" class="flex items-center">
                <span class="text-2xl font-bold tracking-wide text-[var(--evian-bleu)]">EauPure</span>
            </a>
        </div>

        <section aria-label="Catégories" class="relative max-w-[60vw]">
            <!-- Gradient gauche -->
            <div id="cat-gradient-left"
                class="pointer-events-none absolute left-0 top-0 h-full w-8 bg-gradient-to-l from-transparent to-[var(--evian-blanc)] z-10 transition-opacity duration-200 opacity-0">
            </div>
            <!-- Gradient droite -->
            <div id="cat-gradient-right"
                class="pointer-events-none absolute right-0 top-0 h-full w-8 bg-gradient-to-r from-transparent to-[var(--evian-blanc)] z-10 transition-opacity duration-200 opacity-0">
            </div>

            <ul class="flex items-center w-full overflow-y-hidden overflow-x-scroll no-scrollbar gap-5" id="categories-list"
                style="scroll-behavior: smooth; white-space: nowrap;">
                @foreach($categories as $categorie)
                        <li class="shrink-0">
                            <a href="{{ route('categorie.filter', $categorie->id) }}" class="will-change-transform transition-all duration-200 ease-in-out hover:scale-110 text-md py-1
                                        {{ (isset($selected) && $selected == $categorie->id)
                    ? 'text-[var(--evian-bleu)] text-lg'
                    : 'text-[var(--evian-rouge)] hover:text-lg hover:text-[var(--evian-bleu)]' }}">

                                {{ $categorie->name }}

                            </a>

                        </li>
                @endforeach
            </ul>
        </section>

        <!-- Colonne droite : Bouton login -->
        <div class="flex-1 flex justify-end items-center gap-4">
            @if(backpack_auth()->check())
                <a href="{{ backpack_url('dashboard') }}"
                    class="px-3 py-2 rounded-full font-medium shadow transition-colors duration-200 bg-[var(--evian-rouge)] text-[var(--evian-blanc)] hover:bg-[var(--evian-bleu)]">
                    {{ backpack_user()->name }}
                </a>
                <form method="POST" action="{{ backpack_url('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-3 py-2 rounded-full font-medium shadow transition-colors duration-200 bg-[var(--evian-gris-clair)] text-[var(--evian-bleu)] hover:bg-[var(--evian-bleu)] hover:text-[var(--evian-blanc)] cursor-pointer">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ backpack_url('login') }}"
                    class="px-6 py-2 rounded-full font-medium shadow transition-colors duration-200 bg-[var(--evian-rouge)] text-[var(--evian-blanc)] hover:bg-[var(--evian-bleu)]">
                    S'identifier
                </a>
            @endif
        </div>
    </nav>
@endsection

@section('content')

    <section class="w-full bg-[var(--evian-blanc)] pt-14 pb-10 shadow-sm">
        <div class="max-w-3xl mx-auto text-center px-4 align-items-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-[var(--evian-bleu)] leading-tight drop-shadow-sm">
                Notre gamme de bouteilles
            </h1>
            <p class="text-lg md:text-xl text-[var(--evian-bleu)] max-w-2xl mx-auto mb-8">
                Nous vous proposons une large gamme de bouteilles d'eau minérale naturelle pour vous hydrater et vous
                rafraîchir tout au long de la journée.<br>
                Que vous soyez au bureau, en déplacement ou que vous receviez, vous trouverez le format evian qui vous
                convient.
            </p>
            <div class="flex justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </section>

    {{-- Ici ta grille d'articles --}}
    <div class="max-w-6xl mx-auto py-16 px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 w-full justify-items-center">
            @forelse($articles as $article)
                <div
                    class="shadow-lg transition duration-200 hover:shadow-2xl flex flex-col items-center p-6 w-full max-w-xs aspect-square rounded-xl">
                    <div class="w-full flex-1 flex items-center justify-center mb-4">
                        <img src="{{ $article->image_src ? asset('storage/' . $article->image_src) : asset('storage/images/default.jpg') }}"
                            alt="{{ $article->name }}" class="w-50 h-50 object-cover rounded-xl
                    {{ $article->image_src ? '' : 'bg-[var(--evian-gris-clair)] shadow-sm' }}">
                    </div>


                    {{-- Tag catégorie --}}
                    @if($article->categorie)
                        <span
                            class="inline-block mb-2 px-3 py-1 rounded-full text-xs text-[var(--evian-bleu)] border border-[var(--evian-bleu)]">
                            {{ $article->categorie->name }}
                        </span>
                    @endif

                    <h2 class="text-lg font-semibold mb-1 text-center text-[var(--evian-bleu)]">{{ $article->name }}</h2>

                    <p class="font-bold text-lg mb-4 text-[var(--evian-rouge)]">
                        {{ number_format($article->price, 2, ',', ' ') }} €
                    </p>

                    <button
                        class="px-6 py-2 rounded-full font-medium shadow transition-all duration-200
                                                                bg-[var(--evian-bleu)] text-white hover:bg-[var(--evian-rouge)] hover:scale-110 mt-auto cursor-pointer">
                        Ajouter au panier
                    </button>
                </div>
            @empty
                <p>Aucun article trouvé pour cette catégorie.</p>
            @endforelse
        </div>
    </div>

@endsection

@section("footer")

    <div class="max-w-7xl mx-auto px-6 flex flex-row justify-between gap-8">
        <!-- Branding -->
        <section class="flex-1 min-w-[160px]">
            <h2 class="text-2xl font-bold mb-2">EauPure</h2>
            <p class="text-sm opacity-90">
                Inspiré par Evian, nous vous proposons une gamme de bouteilles d'eau minérale naturelle.
            </p>
        </section>

        <!-- Navigation -->
        <nav class="flex-1 min-w-[120px]">
            <h3 class="font-semibold mb-2">Navigation</h3>
            <ul class="space-y-1 text-sm opacity-90">
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">Accueil</a></li>
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">Produits</a></li>
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">À propos</a></li>
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">Contact</a></li>
            </ul>
        </nav>

        <!-- Support -->
        <section class="flex-1 min-w-[120px]">
            <h3 class="font-semibold mb-2">Support</h3>
            <ul class="space-y-1 text-sm opacity-90">
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">FAQ</a></li>
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">Livraison & Retours</a></li>
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">Politique de confidentialité</a></li>
                <li><a href="#" class="hover:underline text-[var(--evian-bleu)]">Conditions d'utilisation</a></li>
            </ul>
        </section>

        <!-- Social & Newsletter -->
        <section class="!flex-1 !min-w-[180px] !flex !flex-col !items-end">
            <h3 class="!font-semibold !mb-2">Restez connecté</h3>
            <div class="!flex !space-x-4 !mb-4 !text-[var(--evian-bleu)]">
                <a href="#" aria-label="Facebook" class="!hover:text-blue-700">
                    <svg class="!w-6 !h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2c0-2 1-3 3-3h2v3h-1c-1 0-1 .5-1 1v1h2l-1 3h-1v7A10 10 0 0022 12z" />
                    </svg>
                </a>
                <a href="#" aria-label="Twitter" class="!hover:text-blue-700">
                    <svg class="!w-6 !h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23 3a10.9 10.9 0 01-3.14.86 4.48 4.48 0 001.98-2.48 9.18 9.18 0 01-2.9 1.1A4.52 4.52 0 0016.5 2c-2.5 0-4.5 2-4.5 4.5 0 .35.04.7.12 1.03A12.94 12.94 0 013 4.1a4.48 4.48 0 001.4 6 4.5 4.5 0 01-2-.55v.05c0 2.2 1.56 4 3.63 4.4a4.5 4.5 0 01-2 .08 4.5 4.5 0 004.2 3.13A9 9 0 013 19.54 12.7 12.7 0 008.29 21c7.55 0 11.68-6.25 11.68-11.66 0-.18 0-.35-.01-.53A8.18 8.18 0 0023 3z" />
                    </svg>
                </a>
                <a href="#" aria-label="Instagram" class="!hover:text-blue-700">
                    <svg class="!w-6 !h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2a1 1 0 110 2 1 1 0 010-2zm-5 3a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                </a>
            </div>
            <form class="!w-full !max-w-xs">
                <label for="email" class="!sr-only">Adresse email</label>
                <input type="email" id="email" placeholder="Votre email"
                    class="!w-full !px-3 !py-2 !rounded-md !border !border-[var(--evian-bleu)] !text-[var(--evian-bleu)] !focus:outline-none !focus:ring-2 !focus:ring-[var(--evian-bleu)]" />
                <button type="submit"
                    class="!mt-2 !w-full !bg-[var(--evian-bleu)] !text-white !font-semibold !rounded-md !py-2 !transition cursor-pointer">
                    S'inscrire
                </button>
            </form>
        </section>
    </div>
    <div class="!mt-8 !pt-4 !text-center !text-xs !opacity-70">
        &copy; {{ date('Y') }} EauPure. Inspiré par Evian.</div>

@endsection

<script>

    //Inversion axe scroll molette
    document.addEventListener('DOMContentLoaded', function () {

        const el = document.getElementById('categories-list');
        if (!el) return;
        el.addEventListener('wheel', function (e) {
            // Si l'utilisateur scrolle verticalement
            if (e.deltaY !== 0) {
                e.preventDefault();
                el.scrollLeft += e.deltaY;
            }
        }, { passive: false });

        //Gradients
        const list = document.getElementById('categories-list');
        const gradLeft = document.getElementById('cat-gradient-left');
        const gradRight = document.getElementById('cat-gradient-right');

        function updateGradients() {
            // Si le contenu déborde horizontalement
            if (list.scrollWidth > list.clientWidth + 1) {
                // Affiche à droite si pas tout à droite
                if (list.scrollLeft + list.clientWidth < list.scrollWidth - 1) {
                    gradRight.style.opacity = 1;
                } else {
                    gradRight.style.opacity = 0;
                }
                // Affiche à gauche si pas tout à gauche
                if (list.scrollLeft > 1) {
                    gradLeft.style.opacity = 1;
                } else {
                    gradLeft.style.opacity = 0;
                }
            } else {
                gradLeft.style.opacity = 0;
                gradRight.style.opacity = 0;
            }
        }

        // Sur scroll et resize
        list.addEventListener('scroll', updateGradients);
        window.addEventListener('resize', updateGradients);
        updateGradients();
    });


</script>