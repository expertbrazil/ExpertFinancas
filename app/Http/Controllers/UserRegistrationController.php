<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserRegistrationController extends Controller
{
    public function create()
    {
        $roles = Role::where('name', '!=', 'root')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            // 1. Validação
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required', 'exists:roles,id'],
                'whatsapp' => ['nullable', 'string', 'max:15'],
                'profile_photo' => ['nullable', 'image', 'max:1024'], // 1MB
            ], [
                'name.required' => 'O nome é obrigatório.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Digite um e-mail válido.',
                'email.unique' => 'Este e-mail já está em uso.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'password.confirmed' => 'As senhas não conferem.',
                'role_id.required' => 'Selecione uma permissão.',
                'role_id.exists' => 'Permissão inválida.',
                'profile_photo.image' => 'O arquivo deve ser uma imagem.',
                'profile_photo.max' => 'A foto não pode ser maior que 1MB.',
            ]);

            // 2. Preparar dados do usuário
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'],
                'whatsapp' => $validated['whatsapp'],
                'ativo' => true,
            ];

            // 3. Upload da foto
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                
                // Verificar tamanho novamente
                if ($file->getSize() > 1024 * 1024) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['profile_photo' => 'A foto não pode ser maior que 1MB.']);
                }

                // Gerar nome único
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::uuid() . '.' . $extension;
                
                // Garantir que o diretório existe
                $uploadPath = public_path('fotos');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Mover arquivo
                $file->move($uploadPath, $fileName);
                $userData['profile_photo'] = 'fotos/' . $fileName;
            }

            // 4. Criar usuário
            $user = User::create($userData);

            // 5. Log de sucesso
            Log::info('Usuário criado com sucesso', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // 6. Redirecionar com mensagem de sucesso
            return redirect()->route('users.index')
                ->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            // Log do erro
            Log::error('Erro ao criar usuário', [
                'error' => $e->getMessage(),
                'input' => $request->except(['password', 'password_confirmation'])
            ]);

            // Retornar com erro
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Erro ao criar usuário. Por favor, tente novamente.']);
        }
    }
}
