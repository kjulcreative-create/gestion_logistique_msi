<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — MSI BF Gestion Logistique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center">
<div class="w-full max-w-md px-4">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">MSI Burkina Faso</h1>
        <p class="text-gray-500 text-sm mt-1">Système de Gestion Logistique</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Connexion</h2>

        @if(session('status'))
        <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 px-4 py-3 rounded-lg">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600">
                    Se souvenir de moi
                </label>
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 text-white font-medium py-2.5 rounded-lg hover:bg-emerald-700 transition-colors text-sm">
                Se connecter
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <p class="text-xs text-gray-400 font-medium mb-2">Comptes de démonstration :</p>
            <div class="space-y-1 text-xs text-gray-500">
                <p>Admin : <span class="font-mono text-gray-700">admin@msi-bf.org</span> / <span class="font-mono text-gray-700">Admin@2026</span></p>
                <p>Gestionnaire : <span class="font-mono text-gray-700">i.kone@msi-bf.org</span> / <span class="font-mono text-gray-700">MSIbf@2026</span></p>
            </div>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        MSI Burkina Faso · Système de gestion logistique interne<br>
        Référence : MSI BF/LOG 2026/001
    </p>
</div>
</body>
</html>
