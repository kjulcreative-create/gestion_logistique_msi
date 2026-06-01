<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tableau de bord') — MSI BF Logistique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex">

{{-- ===== SIDEBAR ===== --}}
<aside class="w-64 bg-gray-900 flex flex-col flex-shrink-0 h-screen sticky top-0 overflow-y-auto">
    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-bold leading-tight">MSI Burkina Faso</p>
                <p class="text-gray-400 text-xs">Gestion Logistique</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">
        <p class="sidebar-group">Principal</p>
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
            Tableau de bord
        </a>

        <p class="sidebar-group">Achats</p>
        <a href="{{ route('fournisseurs.index') }}" class="sidebar-link {{ request()->routeIs('fournisseurs.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Fournisseurs
        </a>
        <a href="{{ route('commandes.index') }}" class="sidebar-link {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Bons de commande
        </a>

        <p class="sidebar-group">Stocks</p>
        <a href="{{ route('articles.index') }}" class="sidebar-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Articles / Stock
        </a>
        <a href="{{ route('mouvements.index') }}" class="sidebar-link {{ request()->routeIs('mouvements.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Mouvements de stock
        </a>

        <p class="sidebar-group">Équipements</p>
        <a href="{{ route('equipements.index') }}" class="sidebar-link {{ request()->routeIs('equipements.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
            Équipements
        </a>

        <p class="sidebar-group">Parc automobile</p>
        <a href="{{ route('vehicules.index') }}" class="sidebar-link {{ request()->routeIs('vehicules.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17H5a2 2 0 01-2-2V8a2 2 0 012-2h3m5 10h3a2 2 0 002-2V8a2 2 0 00-2-2h-3m-5 0V4a1 1 0 011-1h4a1 1 0 011 1v3M8 17v-5h8v5"/></svg>
            Véhicules
        </a>
        <a href="{{ route('missions.index') }}" class="sidebar-link {{ request()->routeIs('missions.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Missions / Déplacements
        </a>
        <a href="{{ route('carburant.index') }}" class="sidebar-link {{ request()->routeIs('carburant.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6l-3 9h3l1-3h6l1 3h3L14 7h-3m-2 0V4m4 3V4M8 13l1-3h6l1 3"/></svg>
            Carburant
        </a>

        @if(auth()->user()->isAdmin())
        <p class="sidebar-group">Administration</p>
        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Utilisateurs
        </a>
        @endif
    </nav>

    {{-- User info --}}
    <div class="px-4 py-4 border-t border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-gray-400 text-xs truncate">{{ auth()->user()->role_libelle }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-white transition-colors" title="Déconnexion">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ===== MAIN CONTENT ===== --}}
<div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
    {{-- Top bar --}}
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Tableau de bord')</h1>
            @hasSection('breadcrumb')
            <div class="flex items-center gap-1 text-sm text-gray-500 mt-0.5">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600">Accueil</a>
                @yield('breadcrumb')
            </div>
            @endif
        </div>
        <div class="flex items-center gap-3 text-sm text-gray-500">
            <span>{{ now()->isoFormat('dddd D MMMM YYYY') }}</span>
        </div>
    </header>

    {{-- Flash messages --}}
    <div class="px-8 pt-4">
        @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            <svg class="w-5 h-5 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif
    </div>

    {{-- Page content --}}
    <main class="flex-1 px-8 py-4 pb-10">
        @yield('content')
    </main>
</div>

</body>
</html>
