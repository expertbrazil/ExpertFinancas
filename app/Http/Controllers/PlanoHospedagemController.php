<?php

namespace App\Http\Controllers;

use App\Models\PlanoHospedagem;
use Illuminate\Http\Request;

class PlanoHospedagemController extends Controller
{
    public function index()
    {
        $planos = PlanoHospedagem::orderBy('valor')->paginate(10);
        return view('planos.index', compact('planos'));
    }

    public function create()
    {
        return view('planos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'valor' => 'required|numeric|min:0',
            'periodo' => 'required|in:mensal,trimestral,semestral,anual',
            'espaco_disco' => 'required|integer|min:1',
            'largura_banda' => 'required|integer|min:1',
            'contas_email' => 'required|integer|min:0',
            'bancos_dados' => 'required|integer|min:0',
            'ssl_gratuito' => 'boolean',
            'backup_diario' => 'boolean',
        ]);

        PlanoHospedagem::create($validated);

        return redirect()->route('planos.index')
            ->with('success', 'Plano de hospedagem cadastrado com sucesso!');
    }

    public function show(PlanoHospedagem $plano)
    {
        return view('planos.show', compact('plano'));
    }

    public function edit(PlanoHospedagem $plano)
    {
        return view('planos.edit', compact('plano'));
    }

    public function update(Request $request, PlanoHospedagem $plano)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'valor' => 'required|numeric|min:0',
            'periodo' => 'required|in:mensal,trimestral,semestral,anual',
            'espaco_disco' => 'required|integer|min:1',
            'largura_banda' => 'required|integer|min:1',
            'contas_email' => 'required|integer|min:0',
            'bancos_dados' => 'required|integer|min:0',
            'ssl_gratuito' => 'boolean',
            'backup_diario' => 'boolean',
            'ativo' => 'boolean'
        ]);

        $plano->update($validated);

        return redirect()->route('planos.index')
            ->with('success', 'Plano de hospedagem atualizado com sucesso!');
    }

    public function destroy(PlanoHospedagem $plano)
    {
        $plano->delete();

        return redirect()->route('planos.index')
            ->with('success', 'Plano de hospedagem excluído com sucesso!');
    }
}
