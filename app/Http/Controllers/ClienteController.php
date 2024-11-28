<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Rules\ValidaCpf;
use App\Rules\ValidaCnpj;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.form');
    }

    public function store(Request $request)
    {
        // Regras base de validação (comuns para PF e PJ)
        $rules = [
            'tipo_pessoa' => 'required|in:PF,PJ',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'required',
            'celular' => 'required',
            'status' => 'nullable|boolean',
            'cep' => 'nullable|size:9',
            'logradouro' => 'nullable',
            'numero' => 'nullable',
            'complemento' => 'nullable',
            'bairro' => 'nullable',
            'cidade' => 'nullable',
            'uf' => 'nullable|size:2',
            'observacoes' => 'nullable',
            'data_nascimento' => 'nullable|date_format:Y-m-d',
            'data_fundacao' => 'nullable|date_format:Y-m-d'
        ];

        // Regras específicas para Pessoa Física
        if ($request->tipo_pessoa === 'PF') {
            $rules = array_merge($rules, [
                'nome_completo' => 'required',
                'cpf' => ['required', new ValidaCpf, 'unique:clientes,cpf'],
                'razao_social' => 'nullable',
                'cnpj' => 'nullable'
            ]);
        }

        // Regras específicas para Pessoa Jurídica
        if ($request->tipo_pessoa === 'PJ') {
            $rules = array_merge($rules, [
                'razao_social' => 'required',
                'cnpj' => ['required', new ValidaCnpj, 'unique:clientes,cnpj'],
                'nome_completo' => 'nullable',
                'cpf' => 'nullable'
            ]);
        }

        $validated = $request->validate($rules);
        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.form', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        // Regras base de validação (comuns para PF e PJ)
        $rules = [
            'tipo_pessoa' => 'required|in:PF,PJ',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'required',
            'celular' => 'required',
            'status' => 'nullable|boolean',
            'cep' => 'nullable|size:9',
            'logradouro' => 'nullable',
            'numero' => 'nullable',
            'complemento' => 'nullable',
            'bairro' => 'nullable',
            'cidade' => 'nullable',
            'uf' => 'nullable|size:2',
            'observacoes' => 'nullable',
            'data_nascimento' => 'nullable|date_format:Y-m-d',
            'data_fundacao' => 'nullable|date_format:Y-m-d'
        ];

        // Regras específicas para Pessoa Física
        if ($request->tipo_pessoa === 'PF') {
            $rules = array_merge($rules, [
                'nome_completo' => 'required',
                'cpf' => ['required', new ValidaCpf, 'unique:clientes,cpf,' . $cliente->id],
                'razao_social' => 'nullable',
                'cnpj' => 'nullable'
            ]);
        }

        // Regras específicas para Pessoa Jurídica
        if ($request->tipo_pessoa === 'PJ') {
            $rules = array_merge($rules, [
                'razao_social' => 'required',
                'cnpj' => ['required', new ValidaCnpj, 'unique:clientes,cnpj,' . $cliente->id],
                'nome_completo' => 'nullable',
                'cpf' => 'nullable'
            ]);
        }

        $validated = $request->validate($rules);
        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
