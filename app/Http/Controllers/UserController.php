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
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'root')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'profile_photo.max' => 'A foto de perfil não pode ser maior que 1MB.',
                'profile_photo.image' => 'O arquivo deve ser uma imagem válida (JPG, PNG, GIF).',
                'email.unique' => 'Este e-mail já está sendo usado por outro usuário.',
                'password.confirmed' => 'A confirmação da senha não corresponde.',
                'required' => 'O campo :attribute é obrigatório.',
            ];

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role_id' => ['required', 'exists:roles,id'],
                'whatsapp' => ['nullable', 'string', 'max:15'],
                'profile_photo' => ['nullable', 'image', 'max:1024'], // Max 1MB
            ], $messages);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'],
                'whatsapp' => $validated['whatsapp'],
                'ativo' => true,
            ];

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                
                // Validate file size again (double check)
                if ($file->getSize() > 1024 * 1024) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['profile_photo' => 'A foto de perfil não pode ser maior que 1MB.']);
                }

                $extension = $file->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                
                // Ensure the directory exists
                $uploadPath = public_path('fotos');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Move the file
                $file->move($uploadPath, $fileName);
                
                // Save the relative path to the database
                $data['profile_photo'] = 'fotos/' . $fileName;
            }

            $user = User::create($data);

            Log::info('Usuário criado com sucesso', ['user_id' => $user->id, 'email' => $user->email]);

            return redirect()->route('users.index')
                ->with('success', 'Usuário criado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao criar usuário', [
                'errors' => $e->errors(),
                'input' => $request->except(['password', 'password_confirmation'])
            ]);
            throw $e;

        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário', [
                'error' => $e->getMessage(),
                'input' => $request->except(['password', 'password_confirmation'])
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar usuário. Por favor, tente novamente.');
        }
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'root')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'whatsapp' => ['nullable', 'string', 'max:15'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $data = $request->only(['name', 'email', 'role_id', 'whatsapp']);

        // Protege o usuário root de ter seu perfil alterado
        if ($user->email === 'root@expertfinancas.com.br') {
            $data['role_id'] = $user->role_id;
        }

        // Processa o upload da foto
        if ($request->hasFile('photo')) {
            // Remove a foto antiga se existir
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Salva a nova foto
            $data['photo'] = $request->file('photo')->store('users/photos', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Impedir a exclusão do usuário root
            if ($user->email === 'root@expertfinancas.com.br') {
                return redirect()->back()
                    ->with('error', 'O usuário root do sistema não pode ser excluído.');
            }

            // Remover foto de perfil se existir
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }

            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'Usuário excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir usuário', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao excluir usuário. Por favor, tente novamente.');
        }
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
