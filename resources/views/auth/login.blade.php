<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — MSI BF Gestion Logistique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ===== GUIDE INTERACTIF ===== */
        #guide-overlay {
            position: fixed;
            inset: 0;
            z-index: 9000;
            pointer-events: none;
        }
        #guide-overlay.active {
            pointer-events: all;
        }
        /* Fond sombre avec découpe "spotlight" via SVG */
        #guide-mask {
            position: fixed;
            inset: 0;
            z-index: 9001;
            transition: opacity 0.3s ease;
        }
        /* Bordure lumineuse autour de l'élément ciblé */
        #guide-highlight {
            position: fixed;
            z-index: 9002;
            border-radius: 10px;
            box-shadow: 0 0 0 4px #10b981, 0 0 0 6px rgba(16,185,129,0.3);
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            pointer-events: none;
        }
        /* Bulle de tooltip */
        #guide-tooltip {
            position: fixed;
            z-index: 9010;
            width: 320px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25), 0 4px 16px rgba(0,0,0,0.1);
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            opacity: 0;
            transform: scale(0.95);
        }
        #guide-tooltip.visible {
            opacity: 1;
            transform: scale(1);
        }
        /* Flèche du tooltip */
        #guide-arrow {
            position: absolute;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
        }
        /* Animation d'entrée */
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 4px #10b981, 0 0 0 6px rgba(16,185,129,0.4); }
            50%  { box-shadow: 0 0 0 4px #10b981, 0 0 0 12px rgba(16,185,129,0.15); }
            100% { box-shadow: 0 0 0 4px #10b981, 0 0 0 6px rgba(16,185,129,0.4); }
        }
        #guide-highlight.pulse {
            animation: pulse-ring 1.8s ease infinite;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center">

{{-- ===== PAGE DE CONNEXION ===== --}}

<div class="w-full max-w-md px-4">
    {{-- Logo --}}
    <div id="guide-logo" class="text-center mb-8">
        <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">MSI Burkina Faso</h1>
        <p class="text-gray-500 text-sm mt-1">Système de Gestion Logistique</p>
    </div>

    <div id="guide-card" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Connexion</h2>
            <button id="btn-start-guide" onclick="startGuide()"
                class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Guide rapide
            </button>
        </div>

        @if(session('status'))
        <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 px-4 py-3 rounded-lg">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div id="guide-email-field">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Adresse email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                    placeholder="votre@msi-bf.org">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div id="guide-password-field">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Mot de passe
                </label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div id="guide-remember" class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600">
                    Se souvenir de moi
                </label>
            </div>

            <button id="guide-submit" type="submit"
                class="w-full bg-emerald-600 text-white font-medium py-2.5 rounded-lg hover:bg-emerald-700 active:scale-[0.98] transition-all text-sm shadow-sm">
                Se connecter
            </button>
        </form>

        <div id="guide-demo-creds" class="mt-6 pt-6 border-t border-gray-100">
            <p class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider">Comptes de démonstration</p>
            <div class="space-y-2">
                <button onclick="fillLogin('admin@msi-bf.org','Admin@2026')"
                    class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 border border-gray-100 transition-all group">
                    <div>
                        <p class="text-xs font-semibold text-gray-700 group-hover:text-emerald-700">Administrateur</p>
                        <p class="text-xs text-gray-400 font-mono">admin@msi-bf.org</p>
                    </div>
                    <span class="text-xs text-gray-300 group-hover:text-emerald-500">Cliquer pour remplir →</span>
                </button>
                <button onclick="fillLogin('i.kone@msi-bf.org','MSIbf@2026')"
                    class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 border border-gray-100 transition-all group">
                    <div>
                        <p class="text-xs font-semibold text-gray-700 group-hover:text-emerald-700">Gestionnaire Achats</p>
                        <p class="text-xs text-gray-400 font-mono">i.kone@msi-bf.org</p>
                    </div>
                    <span class="text-xs text-gray-300 group-hover:text-emerald-500">Cliquer pour remplir →</span>
                </button>
                <button onclick="fillLogin('r.sawadogo@msi-bf.org','MSIbf@2026')"
                    class="w-full text-left flex items-center justify-between px-3 py-2 rounded-lg bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 border border-gray-100 transition-all group">
                    <div>
                        <p class="text-xs font-semibold text-gray-700 group-hover:text-emerald-700">Gestionnaire Flotte</p>
                        <p class="text-xs text-gray-400 font-mono">r.sawadogo@msi-bf.org</p>
                    </div>
                    <span class="text-xs text-gray-300 group-hover:text-emerald-500">Cliquer pour remplir →</span>
                </button>
            </div>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        MSI Burkina Faso · Gestion Logistique<br>
        Réf. appel d'offres : <strong>MSI BF/LOG 2026/001</strong>
    </p>
</div>

{{-- ===== GUIDE INTERACTIF ===== --}}
<div id="guide-overlay">
    <!-- Masque SVG avec découpe spotlight -->
    <svg id="guide-mask" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <mask id="spotlight-mask">
                <rect width="100%" height="100%" fill="white"/>
                <rect id="spotlight-hole" x="0" y="0" width="0" height="0" rx="10" fill="black"/>
            </mask>
        </defs>
        <rect width="100%" height="100%" fill="rgba(0,0,0,0.65)" mask="url(#spotlight-mask)"/>
    </svg>

    <!-- Contour lumineux -->
    <div id="guide-highlight"></div>

    <!-- Bulle tooltip -->
    <div id="guide-tooltip">
        <div id="guide-arrow"></div>
        <div class="p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span id="guide-step-badge" class="text-xs font-bold text-white bg-emerald-600 px-2 py-0.5 rounded-full">1/5</span>
                    <span id="guide-title" class="text-sm font-bold text-gray-900"></span>
                </div>
                <button onclick="endGuide()" class="text-gray-300 hover:text-gray-500 transition-colors" title="Ignorer le guide">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p id="guide-desc" class="text-sm text-gray-600 leading-relaxed mb-4"></p>

            <!-- Barre de progression -->
            <div class="flex gap-1 mb-4">
                <div id="prog-0" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                <div id="prog-1" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                <div id="prog-2" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                <div id="prog-3" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                <div id="prog-4" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
            </div>

            <div class="flex items-center justify-between">
                <button id="guide-prev" onclick="prevStep()"
                    class="text-sm text-gray-400 hover:text-gray-600 font-medium transition-colors disabled:opacity-30">
                    ← Précédent
                </button>
                <button id="guide-skip" onclick="endGuide()"
                    class="text-xs text-gray-300 hover:text-gray-500 transition-colors">
                    Ignorer
                </button>
                <button id="guide-next" onclick="nextStep()"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-1.5 rounded-lg transition-colors">
                    Suivant <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ===== AUTO-REMPLISSAGE IDENTIFIANTS =====
function fillLogin(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
    document.getElementById('email').focus();
}

// ===== DÉFINITION DES ÉTAPES DU GUIDE =====
const steps = [
    {
        target: 'guide-logo',
        title: 'Bienvenue',
        desc: 'Bienvenue sur le Système de Gestion Logistique de MSI Burkina Faso. Ce guide va vous montrer comment accéder à la plateforme en quelques secondes.',
        position: 'bottom',
        padding: 20,
    },
    {
        target: 'guide-email-field',
        title: 'Votre adresse email',
        desc: 'Saisissez votre adresse email professionnelle MSI BF. Exemple : <strong>admin@msi-bf.org</strong> pour l\'administrateur.',
        position: 'left',
        padding: 12,
    },
    {
        target: 'guide-password-field',
        title: 'Mot de passe',
        desc: 'Entrez votre mot de passe. Tous les mots de passe sont sécurisés par chiffrement <strong>bcrypt</strong>.',
        position: 'left',
        padding: 12,
    },
    {
        target: 'guide-demo-creds',
        title: 'Comptes de démonstration',
        desc: '5 comptes sont pré-configurés avec des rôles différents (Admin, Achats, Stocks, Équipements, Flotte). <strong>Cliquez sur un compte</strong> pour remplir les champs automatiquement.',
        position: 'top',
        padding: 14,
    },
    {
        target: 'guide-submit',
        title: 'Se connecter',
        desc: 'Cliquez ici pour accéder au tableau de bord et explorer les <strong>4 modules</strong> du système : Achats, Stocks, Équipements et Parc automobile.',
        position: 'top',
        padding: 8,
    },
];

let currentStep = 0;
let guideActive = false;

function startGuide() {
    guideActive = true;
    currentStep = 0;
    const overlay = document.getElementById('guide-overlay');
    overlay.classList.add('active');
    showStep(currentStep);
}

function endGuide() {
    guideActive = false;
    const overlay = document.getElementById('guide-overlay');
    overlay.classList.remove('active');

    // Reset
    document.getElementById('guide-mask').style.opacity = '0';
    document.getElementById('guide-highlight').style.opacity = '0';
    const tooltip = document.getElementById('guide-tooltip');
    tooltip.classList.remove('visible');

    setTimeout(() => {
        document.getElementById('guide-mask').style.opacity = '';
        document.getElementById('guide-highlight').style.opacity = '';
    }, 300);
}

function nextStep() {
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
    } else {
        endGuide();
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function showStep(index) {
    const step  = steps[index];
    const total = steps.length;
    const el    = document.getElementById(step.target);
    if (!el) return;

    const rect    = el.getBoundingClientRect();
    const pad     = step.padding ?? 12;
    const x       = rect.left - pad;
    const y       = rect.top  - pad;
    const w       = rect.width  + pad * 2;
    const h       = rect.height + pad * 2;
    const rx      = 10;

    // --- Découpe SVG ---
    const hole = document.getElementById('spotlight-hole');
    hole.setAttribute('x',  x);
    hole.setAttribute('y',  y);
    hole.setAttribute('width',  w);
    hole.setAttribute('height', h);
    hole.setAttribute('rx', rx);

    // --- Contour lumineux ---
    const hl = document.getElementById('guide-highlight');
    hl.style.left   = x + 'px';
    hl.style.top    = y + 'px';
    hl.style.width  = w + 'px';
    hl.style.height = h + 'px';
    hl.style.opacity = '1';
    hl.classList.add('pulse');

    // --- Contenu tooltip ---
    document.getElementById('guide-step-badge').textContent = (index + 1) + '/' + total;
    document.getElementById('guide-title').textContent = step.title;
    document.getElementById('guide-desc').innerHTML = step.desc;

    // Bouton Précédent
    document.getElementById('guide-prev').disabled = index === 0;
    document.getElementById('guide-prev').style.opacity = index === 0 ? '0.3' : '1';

    // Bouton Suivant : "Terminer" à la dernière étape
    const nextBtn = document.getElementById('guide-next');
    if (index === total - 1) {
        nextBtn.innerHTML = 'Terminer <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
    } else {
        nextBtn.innerHTML = 'Suivant <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
    }

    // Barre de progression
    for (let i = 0; i < total; i++) {
        const bar = document.getElementById('prog-' + i);
        if (bar) bar.style.backgroundColor = i <= index ? '#10b981' : '#e5e7eb';
    }

    // --- Positionnement tooltip ---
    positionTooltip(rect, step.position, pad);
}

function positionTooltip(rect, position, pad) {
    const tooltip = document.getElementById('guide-tooltip');
    const arrow   = document.getElementById('guide-arrow');
    const tw = 320;
    const th = tooltip.offsetHeight || 200;
    const margin = 16;
    const vw = window.innerWidth;
    const vh = window.innerHeight;

    tooltip.classList.remove('visible');

    let left, top;

    if (position === 'bottom') {
        left = rect.left + rect.width / 2 - tw / 2;
        top  = rect.bottom + pad + margin;
        arrow.style.cssText = `top:-6px; left:${tw/2-6}px; bottom:auto; right:auto;`;
    } else if (position === 'top') {
        left = rect.left + rect.width / 2 - tw / 2;
        top  = rect.top - pad - th - margin;
        arrow.style.cssText = `bottom:-6px; left:${tw/2-6}px; top:auto; right:auto;`;
    } else if (position === 'left') {
        left = rect.left - tw - pad - margin;
        top  = rect.top + rect.height / 2 - th / 2;
        arrow.style.cssText = `right:-6px; top:${th/2-6}px; left:auto; bottom:auto;`;
    } else if (position === 'right') {
        left = rect.right + pad + margin;
        top  = rect.top + rect.height / 2 - th / 2;
        arrow.style.cssText = `left:-6px; top:${th/2-6}px; right:auto; bottom:auto;`;
    } else {
        // center
        left = vw / 2 - tw / 2;
        top  = vh / 2 - th / 2;
        arrow.style.cssText = 'display:none';
    }

    // Garder dans les limites de l'écran
    left = Math.max(margin, Math.min(left, vw - tw - margin));
    top  = Math.max(margin, Math.min(top, vh - th - margin));

    tooltip.style.left = left + 'px';
    tooltip.style.top  = top  + 'px';

    requestAnimationFrame(() => { tooltip.classList.add('visible'); });
}

// Navigation clavier (Échap = quitter, → = suivant, ← = précédent)
document.addEventListener('keydown', (e) => {
    if (!guideActive) return;
    if (e.key === 'Escape')     endGuide();
    if (e.key === 'ArrowRight') nextStep();
    if (e.key === 'ArrowLeft')  prevStep();
});

// Lancer le guide automatiquement à la première visite
if (!sessionStorage.getItem('guide-seen')) {
    sessionStorage.setItem('guide-seen', '1');
    setTimeout(startGuide, 800);
}
</script>

</body>
</html>
