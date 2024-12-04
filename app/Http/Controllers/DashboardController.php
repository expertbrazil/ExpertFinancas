<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\Atividade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Faturamento Mensal (último mês)
        $faturamentoMensal = ContaReceber::whereMonth('data_recebimento', now()->month)
            ->whereYear('data_recebimento', now()->year)
            ->where('status', 'pago')
            ->sum('valor');

        // Clientes Ativos
        $clientesAtivos = Cliente::count();

        // Contas a Receber (próximos 30 dias)
        $contasReceber = ContaReceber::where('status', 'pendente')
            ->whereNull('data_recebimento')
            ->whereBetween('data_vencimento', [now(), now()->addDays(30)])
            ->count();

        // Contas a Pagar (próximos 30 dias)
        $contasPagar = ContaPagar::where('status', 'pendente')
            ->whereNull('data_pagamento')
            ->whereBetween('data_vencimento', [now(), now()->addDays(30)])
            ->sum('valor');

        // Dados do Gráfico de Faturamento (últimos 12 meses)
        $faturamentoData = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M');
            
            $faturamento = ContaReceber::whereMonth('data_recebimento', $date->month)
                ->whereYear('data_recebimento', $date->year)
                ->where('status', 'pago')
                ->sum('valor');
                
            $faturamentoData[] = $faturamento;
        }

        // Próximos Vencimentos (combinando contas a pagar e receber)
        $proximosVencimentos = collect();
        
        // Contas a Receber
        $contasReceberProximas = ContaReceber::with('cliente')
            ->where('status', 'pendente')
            ->whereNull('data_recebimento')
            ->whereBetween('data_vencimento', [now(), now()->addDays(30)])
            ->get()
            ->map(function ($conta) {
                return [
                    'cliente' => optional($conta->cliente)->nome ?? 'N/A',
                    'servico' => 'Receita: ' . $conta->descricao,
                    'data_vencimento' => $conta->data_vencimento,
                    'valor' => $conta->valor,
                    'status' => 'A Receber',
                    'status_color' => 'success'
                ];
            });

        // Contas a Pagar
        $contasPagarProximas = ContaPagar::with('fornecedor')
            ->where('status', 'pendente')
            ->whereNull('data_pagamento')
            ->whereBetween('data_vencimento', [now(), now()->addDays(30)])
            ->get()
            ->map(function ($conta) {
                return [
                    'cliente' => optional($conta->fornecedor)->nome ?? 'N/A',
                    'servico' => 'Despesa: ' . $conta->descricao,
                    'data_vencimento' => $conta->data_vencimento,
                    'valor' => $conta->valor,
                    'status' => 'A Pagar',
                    'status_color' => 'danger'
                ];
            });

        // Combinar e ordenar por data de vencimento
        $proximosVencimentos = $contasReceberProximas->concat($contasPagarProximas)
            ->sortBy('data_vencimento')
            ->take(10);

        // Últimas Atividades
        $ultimasAtividades = Atividade::with('usuario')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'faturamentoMensal',
            'clientesAtivos',
            'contasReceber',
            'contasPagar',
            'faturamentoData',
            'labels',
            'proximosVencimentos',
            'ultimasAtividades'
        ));
    }
}
