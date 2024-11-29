<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class PasswordController extends Controller
{
    public function edit(User $user)
    {
        return view('users.password', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'current_password.required' => 'A senha atual é obrigatória.',
                'current_password.current_password' => 'A senha atual está incorreta.',
                'password.required' => 'A nova senha é obrigatória.',
                'password.confirmed' => 'A confirmação da nova senha não confere.',
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            Log::info('Senha alterada com sucesso', ['user_id' => $user->id]);

            return redirect()->route('users.index')
                ->with('success', 'Senha alterada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao alterar senha', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Erro ao alterar senha. Por favor, tente novamente.']);
        }
    }
}
