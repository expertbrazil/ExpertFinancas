@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-pretitle">Configurações</div>
            <h2 class="page-title">Meu Perfil</h2>
        </div>
    </div>
</div>

<div class="row">
    <!-- Coluna da Foto de Perfil -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-pic mb-4">
                    <div class="position-relative d-inline-block">
                        <div class="mt-2">
                            <img 
                                id="avatarPreview" 
                                src="{{ auth()->user()->avatar ? asset('images/' . auth()->user()->avatar) : asset('images/default_avatar.png') }}" 
                                alt="Avatar" 
                                class="rounded-full h-20 w-20 object-cover"
                            >
                        </div>
                        <button 
                            type="button" 
                            onclick="document.getElementById('avatarFileInput').click()" 
                            class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle"
                            style="width: 32px; height: 32px;"
                        >
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                </div>
                <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                
                <input 
                    type="file" 
                    id="avatarFileInput" 
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    class="hidden" 
                    onchange="uploadAvatar(this)"
                >
            </div>
        </div>
    </div>

    <!-- Coluna dos Dados -->
    <div class="col-xl-8">
        <!-- Card de Informações Pessoais -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">Informações Pessoais</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" 
                                value="{{ old('name', auth()->user()->name) }}" 
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">E-mail</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" 
                                value="{{ old('email', auth()->user()->email) }}" 
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card de Alteração de Senha -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Alterar Senha</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Senha Atual</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control @error('current_password') is-invalid @enderror" 
                                    name="current_password"
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nova Senha</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password"
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    name="password_confirmation"
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-2"></i>Alterar Senha
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function uploadAvatar(input) {
        if (input.files && input.files[0]) {
            // Debug
            console.log('Arquivo selecionado:', input.files[0]);

            // Verificar tamanho do arquivo (max 1MB)
            if (input.files[0].size > 1048576) {
                alert('A imagem deve ter no máximo 1MB');
                input.value = '';
                return;
            }

            // Preview imediato
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);

            // Preparar upload
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('avatar', input.files[0]);

            // Debug
            console.log('FormData preparado');
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // Visual feedback
            document.getElementById('avatarPreview').style.opacity = '0.5';

            // Upload
            fetch('{{ route('profile.avatar.update') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Status da resposta:', response.status);
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Resposta não é JSON:', text);
                        throw new Error('Resposta inválida do servidor');
                    }
                });
            })
            .then(data => {
                console.log('Resposta do servidor:', data);
                document.getElementById('avatarPreview').style.opacity = '1';
                
                if (data.success) {
                    document.getElementById('avatarPreview').src = data.avatar + '?t=' + new Date().getTime();
                    alert('Foto atualizada com sucesso!');
                } else {
                    throw new Error(data.message || 'Erro ao atualizar foto');
                }
            })
            .catch(error => {
                console.error('Erro completo:', error);
                document.getElementById('avatarPreview').style.opacity = '1';
                document.getElementById('avatarPreview').src = '{{ auth()->user()->avatar ? asset('images/' . auth()->user()->avatar) : asset('images/default_avatar.png') }}';
                alert(error.message || 'Erro ao atualizar foto. Tente novamente.');
            });
        }
    }

    function togglePassword(button) {
        const input = button.previousElementSibling;
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection