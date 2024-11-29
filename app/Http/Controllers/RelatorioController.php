<?php

namespace App\Http\Controllers;

use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function financeiro(Request $request)
    {
        $dataInicio = $request->input('data_inicio', Carbon::now()->startOfMonth());
        $dataFim = $request->input('data_fim', Carbon::now()->endOfMonth());

        $contasPagar = ContaPagar::whereBetween('data_vencimento', [$dataInicio, $dataFim])
            ->with(['fornecedor', 'categoria'])
            ->get();

        $contasReceber = ContaReceber::whereBetween('data_vencimento', [$dataInicio, $dataFim])
            ->with(['cliente', 'categoria'])
            ->get();

        $totalPagar = $contasPagar->sum('valor');
        $totalReceber = $contasReceber->sum('valor');
        $saldo = $totalReceber - $totalPagar;

        return view('relatorios.financeiro', compact(
            'contasPagar',
            'contasReceber',
            'totalPagar',
            'totalReceber',
            'saldo',
            'dataInicio',
            'dataFim'
        ));
    }

    public function clientes()
    {
        $clientes = Cliente::withCount([
            'contasReceber',
            'contasReceber as contas_receber_pendentes_count' => function ($query) {
                $query->where('status', 'pendente');
            }
        ])->get();

        return view('relatorios.clientes', compact('clientes'));
    }

    public function servicos()
    {
        $servicos = Servico::withCount('clientes')->get();

        return view('relatorios.servicos', compact('servicos'));
    }

    public function produtos()
    {
        $produtos = Produto::where('estoque', '<=', \DB::raw('estoque_minimo'))
            ->orWhere('ativo', true)
            ->get();

        return view('relatorios.produtos', compact('produtos'));
    }
}
