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

    public function store(Request $request)
    {
        // Regras base de validação
        $rules = [
            'tipo_pessoa' => ['required', Rule::in(TipoPessoa::getValues())],
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'required',
            'celular' => 'required',
            'status' => ['required', Rule::in(StatusGeral::getValues())],
            'cep' => 'nullable|size:9',
            'logradouro' => 'nullable',
            'numero' => 'nullable',
            'complemento' => 'nullable',
            'bairro' => 'nullable',
            'cidade' => 'nullable',
            'uf' => 'nullable|size:2',
            'observacoes' => 'nullable',
            'foto' => 'nullable|image|max:2048'
        ];

        // Regras específicas por tipo de pessoa
        if ($request->tipo_pessoa === TipoPessoa::FISICA->value) {
            $rules = array_merge($rules, [
                'nome_completo' => 'required',
                'cpf' => ['required', new ValidaCpf, 'unique:clientes,cpf'],
                'data_nascimento' => 'nullable|date_format:Y-m-d',
                'razao_social' => 'nullable',
                'cnpj' => 'nullable',
                'data_fundacao' => 'nullable'
            ]);
        } else {
            $rules = array_merge($rules, [
                'razao_social' => 'required',
                'cnpj' => ['required', new ValidaCnpj, 'unique:clientes,cnpj'],
                'data_fundacao' => 'nullable|date_format:Y-m-d',
                'nome_completo' => 'nullable',
                'cpf' => 'nullable',
                'data_nascimento' => 'nullable'
            ]);
        }

        $validated = $request->validate($rules);

        try {
            $cliente = $this->clienteService->criar($validated);
            $this->logCriacao('cliente', $cliente->id);

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
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
        $cliente = $this->clienteService->buscar($id);

        // Regras base de validação
        $rules = [
            'tipo_pessoa' => ['required', Rule::in(TipoPessoa::getValues())],
            'email' => ['required', 'email', Rule::unique('clientes')->ignore($id)],
            'telefone' => 'required',
            'celular' => 'required',
            'status' => ['required', Rule::in(StatusGeral::getValues())],
            'cep' => 'nullable|size:9',
            'logradouro' => 'nullable',
            'numero' => 'nullable',
            'complemento' => 'nullable',
            'bairro' => 'nullable',
            'cidade' => 'nullable',
            'uf' => 'nullable|size:2',
            'observacoes' => 'nullable',
            'foto' => 'nullable|image|max:2048'
        ];

        // Regras específicas por tipo de pessoa
        if ($request->tipo_pessoa === TipoPessoa::FISICA->value) {
            $rules = array_merge($rules, [
                'nome_completo' => 'required',
                'cpf' => ['required', new ValidaCpf, Rule::unique('clientes')->ignore($id)],
                'data_nascimento' => 'nullable|date_format:Y-m-d',
                'razao_social' => 'nullable',
                'cnpj' => 'nullable',
                'data_fundacao' => 'nullable'
            ]);
        } else {
            $rules = array_merge($rules, [
                'razao_social' => 'required',
                'cnpj' => ['required', new ValidaCnpj, Rule::unique('clientes')->ignore($id)],
                'data_fundacao' => 'nullable|date_format:Y-m-d',
                'nome_completo' => 'nullable',
                'cpf' => 'nullable',
                'data_nascimento' => 'nullable'
            ]);
        }

        $validated = $request->validate($rules);

        try {
            $cliente = $this->clienteService->atualizar($id, $validated);
            $this->logAtualizacao('cliente', $cliente->id);

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->clienteService->excluir($id);
            $this->logExclusao('cliente', $id);

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente excluído com sucesso!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao excluir cliente: ' . $e->getMessage());
        }
    }
}
