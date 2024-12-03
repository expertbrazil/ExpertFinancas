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
        $validated = $request->validate([
            'tipo_pessoa' => 'required|in:PF,PJ',
            'status' => 'boolean',
            'nome_completo' => 'required_if:tipo_pessoa,PF',
            'cpf' => 'required_if:tipo_pessoa,PF|unique:clientes,cpf',
            'data_nascimento' => 'nullable|date',
            'razao_social' => 'required_if:tipo_pessoa,PJ',
            'cnpj' => 'required_if:tipo_pessoa,PJ|unique:clientes,cnpj',
            'data_fundacao' => 'nullable|date',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable',
            'celular' => 'nullable',
            'dominios.*.nome_dominio' => 'required|string',
            'dominios.*.data_registro' => 'nullable|date',
            'dominios.*.data_vencimento' => 'nullable|date',
            'dominios.*.registrador' => 'nullable|string',
            'inscricoes.*.numero_inscricao' => 'required_if:tipo_pessoa,PF|string',
            'inscricoes.*.uf' => 'required_if:tipo_pessoa,PF|string|size:2',
            'inscricoes.*.ativo' => 'required_if:tipo_pessoa,PF|boolean'
        ]);

        try {
            DB::beginTransaction();

            // Criar cliente
            $cliente = $this->clienteService->criar($validated);

            // Processar domínios
            if (!empty($request->dominios)) {
                foreach ($request->dominios as $dominio) {
                    $cliente->dominios()->create($dominio);
                }
            }

            // Processar inscrições estaduais (apenas para PF)
            if ($request->tipo_pessoa === 'PF' && !empty($request->inscricoes)) {
                foreach ($request->inscricoes as $inscricao) {
                    $cliente->inscricoesEstaduais()->create($inscricao);
                }
            }

            DB::commit();

            $this->logCriacao('cliente', $cliente->id);
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage())
                ->withInput();
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

    protected function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tipo_pessoa' => 'required|in:PF,PJ',
            'status' => 'boolean',
            'nome_completo' => 'required_if:tipo_pessoa,PF',
            'cpf' => 'required_if:tipo_pessoa,PF|unique:clientes,cpf,' . $id,
            'data_nascimento' => 'nullable|date',
            'razao_social' => 'required_if:tipo_pessoa,PJ',
            'cnpj' => 'required_if:tipo_pessoa,PJ|unique:clientes,cnpj,' . $id,
            'data_fundacao' => 'nullable|date',
            'email' => 'required|email|unique:clientes,email,' . $id,
            'telefone' => 'nullable',
            'celular' => 'nullable',
            'dominios.*.nome_dominio' => 'required|string',
            'dominios.*.data_registro' => 'nullable|date',
            'dominios.*.data_vencimento' => 'nullable|date',
            'dominios.*.registrador' => 'nullable|string',
            'inscricoes.*.numero_inscricao' => 'required_if:tipo_pessoa,PF|string',
            'inscricoes.*.uf' => 'required_if:tipo_pessoa,PF|string|size:2',
            'inscricoes.*.ativo' => 'required_if:tipo_pessoa,PF|boolean'
        ]);

        try {
            DB::beginTransaction();

            // Atualizar cliente
            $cliente = $this->clienteService->atualizar($id, $validated);

            // Atualizar domínios
            $cliente->dominios()->delete(); // Remove domínios existentes
            if (!empty($request->dominios)) {
                foreach ($request->dominios as $dominio) {
                    $cliente->dominios()->create($dominio);
                }
            }

            // Atualizar inscrições estaduais (apenas para PF)
            $cliente->inscricoesEstaduais()->delete(); // Remove inscrições existentes
            if ($request->tipo_pessoa === 'PF' && !empty($request->inscricoes)) {
                foreach ($request->inscricoes as $inscricao) {
                    $cliente->inscricoesEstaduais()->create($inscricao);
                }
            }

            DB::commit();

            $this->logAtualizacao('cliente', $cliente->id);
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar cliente: ' . $e->getMessage())
                ->withInput();
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
