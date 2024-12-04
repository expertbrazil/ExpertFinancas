<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use App\Enums\TipoPessoa;
use App\Enums\StatusGeral;
use App\Traits\LogActivityTrait;
use App\Rules\ValidaCpf;
use App\Rules\ValidaCnpj;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    use LogActivityTrait;

    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index(Request $request)
    {
        $filtros = $request->only(['nome', 'email', 'cpf_cnpj', 'tipo_pessoa', 'status']);
        $clientes = $this->clienteService->listar($filtros);
        
        return view('clientes.index', [
            'clientes' => $clientes,
            'tipos_pessoa' => TipoPessoa::getDescriptions(),
            'status_list' => StatusGeral::getDescriptions()
        ]);
    }

    public function create()
    {
        return view('clientes.form', [
            'tipos_pessoa' => TipoPessoa::getDescriptions(),
            'status_list' => StatusGeral::getDescriptions()
        ]);
    }

    protected function store(Request $request)
    {
        $rules = [
            'tipo_pessoa' => 'required|in:PF,PJ',
            'status' => 'boolean',
            'email' => 'nullable|email',
            'telefone' => 'nullable|string|max:15',
            'celular' => 'nullable|string|max:15',
            'cep' => 'nullable|string|size:9',
            'logradouro' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:50',
            'bairro' => 'nullable|string|max:50',
            'cidade' => 'nullable|string|max:50',
            'uf' => 'nullable|string|size:2',
            'observacoes' => 'nullable|string|max:500',
        ];

        // Regras específicas para Pessoa Física
        if ($request->input('tipo_pessoa') === 'PF') {
            $rules = array_merge($rules, [
                'nome_completo' => 'required|string|max:100',
                'cpf' => ['required', 'string', 'size:14', new ValidaCpf],
                'data_nascimento' => 'nullable|date',
            ]);
        }
        // Regras específicas para Pessoa Jurídica
        else {
            $rules = array_merge($rules, [
                'razao_social' => 'required|string|max:100',
                'nome_fantasia' => 'nullable|string|max:100',
                'cnpj' => ['required', 'string', 'size:18', new ValidaCnpj],
            ]);
        }

        // Validação de domínios
        if ($request->has('dominios')) {
            $rules['dominios.*.dominio'] = [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/'
            ];
        }

        // Validação de inscrições estaduais
        if ($request->has('inscricoes')) {
            $rules['inscricoes.*.uf'] = 'required|string|size:2';
            $rules['inscricoes.*.inscricao'] = 'required|string|max:20';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();
            
            $cliente = $this->clienteService->criar($validated);
            
            $this->logActivity(
                'Cliente cadastrado com sucesso', 
                'create', 
                'cliente', 
                $cliente->id
            );

            DB::commit();
            
            return redirect()
                ->route('clientes.index')
                ->with('success', 'Cliente cadastrado com sucesso!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $cliente = $this->clienteService->buscar($id);
        
        return view('clientes.form', [
            'cliente' => $cliente,
            'tipos_pessoa' => TipoPessoa::getDescriptions(),
            'status_list' => StatusGeral::getDescriptions()
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'tipo_pessoa' => 'required|in:PF,PJ',
            'status' => 'boolean',
            'email' => 'nullable|email',
            'telefone' => 'nullable|string|max:15',
            'celular' => 'nullable|string|max:15',
            'cep' => 'nullable|string|size:9',
            'logradouro' => 'nullable|string|max:100',
            'numero' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:50',
            'bairro' => 'nullable|string|max:50',
            'cidade' => 'nullable|string|max:50',
            'uf' => 'nullable|string|size:2',
            'observacoes' => 'nullable|string|max:500',
        ];

        // Regras específicas para Pessoa Física
        if ($request->input('tipo_pessoa') === 'PF') {
            $rules = array_merge($rules, [
                'nome_completo' => 'required|string|max:100',
                'cpf' => ['required', 'string', 'size:14', new ValidaCpf],
                'data_nascimento' => 'nullable|date',
            ]);
        }
        // Regras específicas para Pessoa Jurídica
        else {
            $rules = array_merge($rules, [
                'razao_social' => 'required|string|max:100',
                'nome_fantasia' => 'nullable|string|max:100',
                'cnpj' => ['required', 'string', 'size:18', new ValidaCnpj],
            ]);
        }

        // Validação de domínios
        if ($request->has('dominios')) {
            $rules['dominios.*.dominio'] = [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/'
            ];
        }

        // Validação de inscrições estaduais
        if ($request->has('inscricoes')) {
            $rules['inscricoes.*.uf'] = 'required|string|size:2';
            $rules['inscricoes.*.inscricao'] = 'required|string|max:20';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();
            
            $cliente = $this->clienteService->atualizar($id, $validated);
            
            $this->logActivity(
                'Cliente atualizado com sucesso', 
                'update', 
                'cliente', 
                $cliente->id
            );

            DB::commit();
            
            return redirect()
                ->route('clientes.index')
                ->with('success', 'Cliente atualizado com sucesso!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $this->clienteService->excluir($id);
            
            $this->logActivity(
                'Cliente excluído com sucesso', 
                'delete', 
                'cliente', 
                $id
            );

            DB::commit();
            
            return redirect()
                ->route('clientes.index')
                ->with('success', 'Cliente excluído com sucesso!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir cliente: ' . $e->getMessage());
        }
    }
}
