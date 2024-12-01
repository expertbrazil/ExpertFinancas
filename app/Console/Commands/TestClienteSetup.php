<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestClienteSetup extends Command
{
    protected $signature = 'test:cliente-setup';
    protected $description = 'Testa a configuração do sistema de clientes';

    public function handle()
    {
        $this->info('Iniciando teste de configuração do cliente...');

        // 1. Criar um cliente
        $cliente = Cliente::create([
            'tipo_pessoa' => 'PJ',
            'ativo' => true,
            'razao_social' => 'Empresa Teste LTDA',
            'cnpj' => '12345678901234',
            'email' => 'empresa@teste.com',
            'telefone' => '1199999999',
            'cep' => '12345678',
            'logradouro' => 'Rua Teste',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'uf' => 'SP'
        ]);

        $this->info('Cliente criado com ID: ' . $cliente->id);

        // 2. Obter role do cliente
        $roleCliente = Role::where('slug', 'cliente')->first();
        if (!$roleCliente) {
            $this->error('Role de cliente não encontrada!');
            return 1;
        }

        // 3. Criar usuário para o cliente
        $user = User::create([
            'name' => 'Usuário Teste',
            'email' => 'usuario@teste.com',
            'password' => Hash::make('password'),
            'cliente_id' => $cliente->id,
            'role_id' => $roleCliente->id
        ]);

        $this->info('Usuário criado com ID: ' . $user->id);

        // 4. Testar criação de ticket
        $ticket = Ticket::create([
            'cliente_id' => $cliente->id,
            'user_id' => $user->id,
            'titulo' => 'Ticket de Teste',
            'descricao' => 'Este é um ticket de teste para verificar a funcionalidade.',
            'categoria' => 'suporte'
        ]);

        $this->info('Ticket criado com ID: ' . $ticket->id);

        // 5. Testar permissões
        $this->info('Testando permissões do usuário:');
        $this->info('- dashboard.view: ' . ($user->hasPermission('dashboard.view') ? 'Sim' : 'Não'));
        $this->info('- tickets.create: ' . ($user->hasPermission('tickets.create') ? 'Sim' : 'Não'));
        $this->info('- documentos.view: ' . ($user->hasPermission('documentos.view') ? 'Sim' : 'Não'));
        $this->info('- faturas.view: ' . ($user->hasPermission('faturas.view') ? 'Sim' : 'Não'));

        // 6. Testar relacionamentos
        $this->info('Testando relacionamentos:');
        $this->info('- Cliente -> Usuários: ' . $cliente->users()->count());
        $this->info('- Cliente -> Tickets: ' . $cliente->tickets()->count());
        $this->info('- Usuário -> Cliente: ' . ($user->cliente->razao_social ?? 'Não encontrado'));

        $this->info('Teste concluído com sucesso!');
    }
}
