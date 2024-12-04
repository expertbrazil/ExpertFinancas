<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => ['required', 'image', 'max:1024']
            ]);

            // Remove old avatar
            if ($user->avatar && $user->avatar !== 'default_avatar.png') {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Store new avatar
            $avatarName = uniqid() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            
            $user->avatar = $avatarName;
            $user->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Avatar atualizado com sucesso',
                    'avatar' => Storage::url('avatars/' . $avatarName)
                ]);
            }

            return redirect()->route('profile.edit')->with('status', 'avatar-updated');
        }

        // Handle profile update
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        try {
            \Log::info('Iniciando upload de avatar');
            
            if (!$request->hasFile('avatar')) {
                \Log::error('Nenhum arquivo recebido');
                return response()->json(['success' => false, 'message' => 'Nenhum arquivo recebido']);
            }

            $file = $request->file('avatar');
            
            // Validar arquivo
            $request->validate([
                'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024']
            ]);

            $user = $request->user();
            
            // Gerar nome único com extensão correta
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Definir caminho na pasta public/images
            $path = public_path('images/' . $filename);
            
            // Mover arquivo
            $file->move(public_path('images'), $filename);
            
            // Remover avatar antigo
            if ($user->avatar && $user->avatar !== 'default_avatar.png') {
                $oldPath = public_path('images/' . $user->avatar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Atualizar usuário
            $user->avatar = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar atualizado com sucesso',
                'avatar' => asset('images/' . $filename)
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar avatar: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar avatar: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the user's avatar.
     */
    public function removeAvatar(Request $request)
    {
        try {
            $user = $request->user();

            if ($user->avatar && $user->avatar !== 'default_avatar.png') {
                if (!Storage::disk('public')->delete('avatars/' . $user->avatar)) {
                    throw new \Exception('Erro ao remover arquivo');
                }
                
                $user->avatar = null;
                if (!$user->save()) {
                    throw new \Exception('Erro ao atualizar usuário');
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Avatar removido com sucesso'
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao remover avatar: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover avatar: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
