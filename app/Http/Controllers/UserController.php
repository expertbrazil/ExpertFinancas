<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,cliente',
        ]);

        // Apenas root pode criar administradores
        if ($validated['role'] === 'admin' && auth()->user()->role !== 'root') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Apenas o usuário root pode criar administradores.');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_root' => false,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        // Apenas root pode editar administradores
        if ($user->role === 'admin' && auth()->user()->role !== 'root') {
            return redirect()->route('users.index')
                ->with('error', 'Apenas o usuário root pode editar administradores.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->is_root) {
            return redirect()->route('users.index')
                ->with('error', 'Não é possível editar o usuário root.');
        }

        // Apenas root pode editar administradores
        if ($user->role === 'admin' && auth()->user()->role !== 'root') {
            return redirect()->route('users.index')
                ->with('error', 'Apenas o usuário root pode editar administradores.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,cliente',
        ]);

        // Apenas root pode mudar papel para administrador
        if ($validated['role'] === 'admin' && auth()->user()->role !== 'root') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Apenas o usuário root pode atribuir papel de administrador.');
        }

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->is_root) {
            return redirect()->route('users.index')
                ->with('error', 'Não é possível excluir o usuário root.');
        }

        // Apenas root pode excluir administradores
        if ($user->role === 'admin' && auth()->user()->role !== 'root') {
            return redirect()->route('users.index')
                ->with('error', 'Apenas o usuário root pode excluir administradores.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Toggle user status between active and inactive.
     */
    public function toggleStatus(User $user)
    {
        try {
            // Impedir a desativação do usuário root
            if ($user->email === 'root@expertfinancas.com.br') {
                return redirect()->back()
                    ->with('error', 'O usuário root do sistema não pode ser desativado.');
            }

            $user->update(['ativo' => !$user->ativo]);

            $status = $user->ativo ? 'ativado' : 'desativado';
            return redirect()->route('users.index')
                ->with('success', "Usuário {$status} com sucesso!");
        } catch (\Exception $e) {
            Log::error('Erro ao alterar status do usuário', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao alterar status do usuário. Por favor, tente novamente.');
        }
    }
}
