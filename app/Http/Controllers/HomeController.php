<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\Atividade;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hoje = Carbon::now();
        $inicioMes = $hoje->copy()->startOfMonth();
        $fimMes = $hoje->copy()->endOfMonth();

        // Faturamento Mensal
        $faturamentoMensal = ContaReceber::whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->where('status', 'pago')
            ->sum('valor');

        // Clientes Ativos
        $clientesAtivos = Cliente::where('ativo', true)->count();

        // Contas a Receber
        $contasReceber = ContaReceber::where('status', 'pendente')
            ->where('data_vencimento', '>=', $hoje)
            ->sum('valor');

        // Contas a Pagar
        $contasPagar = ContaPagar::where('status', 'pendente')
            ->where('data_vencimento', '>=', $hoje)
            ->sum('valor');

        // Dados do Gráfico de Faturamento (últimos 12 meses)
        $dadosFaturamento = [];
        for ($i = 11; $i >= 0; $i--) {
            $mes = $hoje->copy()->subMonths($i);
            $faturamento = ContaReceber::whereYear('data_vencimento', $mes->year)
                ->whereMonth('data_vencimento', $mes->month)
                ->where('status', 'pago')
                ->sum('valor');
            $dadosFaturamento[] = $faturamento;
        }

        // Últimas Atividades
        $ultimasAtividades = Atividade::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Próximos Vencimentos
        $proximosVencimentos = ContaReceber::with('cliente')
            ->where('status', 'pendente')
            ->where('data_vencimento', '>=', $hoje)
            ->orderBy('data_vencimento')
            ->take(5)
            ->get()
            ->map(function ($vencimento) {
                $vencimento->status_cor = $this->getStatusColor($vencimento);
                return $vencimento;
            });

        return view('home', compact(
            'faturamentoMensal',
            'clientesAtivos',
            'contasReceber',
            'contasPagar',
            'dadosFaturamento',
            'ultimasAtividades',
            'proximosVencimentos'
        ));
    }

    /**
     * Get the status color based on the due date
     *
     * @param ContaReceber $vencimento
     * @return string
     */
    private function getStatusColor($vencimento)
    {
        $hoje = Carbon::now();
        $dataVencimento = Carbon::parse($vencimento->data_vencimento);
        
        if ($dataVencimento->isPast()) {
            return 'danger';
        }
        
        if ($dataVencimento->diffInDays($hoje) <= 3) {
            return 'warning';
        }
        
        return 'info';
    }
}
