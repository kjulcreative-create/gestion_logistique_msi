<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|in:admin,gestionnaire_achats,gestionnaire_stocks,gestionnaire_equipements,gestionnaire_flotte,utilisateur',
            'telephone' => 'nullable|string|max:50',
            'poste'     => 'nullable|string|max:100',
            'actif'     => 'boolean',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['actif']    = $request->boolean('actif', true);

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'role'      => 'required|in:admin,gestionnaire_achats,gestionnaire_stocks,gestionnaire_equipements,gestionnaire_flotte,utilisateur',
            'telephone' => 'nullable|string|max:50',
            'poste'     => 'nullable|string|max:100',
            'actif'     => 'boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $data['actif'] = $request->boolean('actif', true);
        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
