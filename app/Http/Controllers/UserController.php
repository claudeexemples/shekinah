<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        abort_unless(auth()->user()?->role === 'admin', 403, 'Acesso reservado para administradores.');
    }

    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:users,email'],
            'role' => ['required', 'in:admin,editor'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($validated);

        return redirect()->route('usuarios.index')->with('success', 'Utilizador criado com sucesso.');
    }

    public function edit(User $usuario)
    {
        return view('pages.users.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:users,email,'.$usuario->id],
            'role' => ['required', 'in:admin,editor'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')->with('success', 'Utilizador actualizado.');
    }

    public function destroy(User $usuario)
    {
        if (auth()->id() === $usuario->id) {
            return back()->with('error', 'Não pode remover a sua própria conta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Utilizador removido.');
    }
}
