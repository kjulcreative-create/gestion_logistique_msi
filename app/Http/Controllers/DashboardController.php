<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CommandeAchat;
use App\Models\Equipement;
use App\Models\Vehicule;
use App\Models\MissionVehicule;
use App\Models\MouvementStock;
use App\Models\ConsommationCarburant;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles'          => Article::where('statut', 'actif')->count(),
            'articles_alerte'   => Article::whereRaw('quantite_stock <= seuil_alerte')->count(),
            'commandes_cours'   => CommandeAchat::whereIn('statut', ['validee', 'en_cours'])->count(),
            'equipements'       => Equipement::count(),
            'equipements_maint' => Equipement::where('statut', 'en_maintenance')->count(),
            'vehicules'         => Vehicule::count(),
            'vehicules_dispo'   => Vehicule::where('statut', 'disponible')->count(),
            'missions_cours'    => MissionVehicule::where('statut', 'en_cours')->count(),
        ];

        $articlesAlerte = Article::whereRaw('quantite_stock <= seuil_alerte')
            ->with('categorie')
            ->orderBy('quantite_stock')
            ->take(5)
            ->get();

        $commandesRecentes = CommandeAchat::with('fournisseur')
            ->orderByDesc('date_commande')
            ->take(5)
            ->get();

        $missionsEnCours = MissionVehicule::with(['vehicule', 'chauffeur'])
            ->whereIn('statut', ['planifiee', 'en_cours'])
            ->orderBy('date_depart')
            ->take(5)
            ->get();

        $derniersMovements = MouvementStock::with(['article', 'user'])
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $dateExpr = match(config('database.default')) {
            'mysql', 'mariadb' => "DATE_FORMAT(`date`, '%Y-%m')",
            default            => "strftime('%Y-%m', date)",
        };

        $depensesMoisParMois = ConsommationCarburant::selectRaw(
            "$dateExpr as mois, SUM(montant_total) as total"
        )->groupBy('mois')->orderBy('mois')->take(6)->get();

        return view('dashboard', compact(
            'stats', 'articlesAlerte', 'commandesRecentes',
            'missionsEnCours', 'derniersMovements', 'depensesMoisParMois'
        ));
    }
}
