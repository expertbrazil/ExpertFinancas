<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::orderBy('nome')->paginate(10);
        return view('servicos.index', compact('servicos'));
    }

    public function create()
    {
        return view('servicos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'valor' => 'required|numeric|min:0',
            'tipo_cobranca' => 'required|in:mensal,trimestral,semestral,anual,avulso',
        ]);

        Servico::create($validated);

        return redirect()->route('servicos.index')
            ->with('success', 'Serviço cadastrado com sucesso!');
    }

    public function show(Servico $servico)
    {
        return view('servicos.show', compact('servico'));
    }

    public function edit(Servico $servico)
    {
        return view('servicos.edit', compact('servico'));
    }

    public function update(Request $request, Servico $servico)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'valor' => 'required|numeric|min:0',
            'tipo_cobranca' => 'required|in:mensal,trimestral,semestral,anual,avulso',
            'ativo' => 'boolean'
        ]);

        $servico->update($validated);

        return redirect()->route('servicos.index')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();

        return redirect()->route('servicos.index')
            ->with('success', 'Serviço excluído com sucesso!');
    }
}
