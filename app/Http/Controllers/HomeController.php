<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContaReceber;
use App\Models\ContaPagar;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        // Dados para os cards
        $clientesAtivos = Cliente::where('ativo', true)->count();
        
        $faturamentoMensal = ContaReceber::whereMonth('data_vencimento', Carbon::now()->month)
            ->whereYear('data_vencimento', Carbon::now()->year)
            ->where('status', 'pago')
            ->sum('valor');
            
        $contasVencidas = ContaPagar::where('data_vencimento', '<', Carbon::now())
            ->where('status', '!=', 'pago')
            ->count();
            
        $ticketsAbertos = Ticket::where('status', 'aberto')->count();

        // Dados para o gráfico de faturamento
        $faturamentoAnual = ContaReceber::select(
                DB::raw('MONTH(data_vencimento) as mes'),
                DB::raw('SUM(CASE WHEN status = "pago" THEN valor ELSE 0 END) as valor_pago'),
                DB::raw('SUM(CASE WHEN status != "pago" THEN valor ELSE 0 END) as valor_pendente')
            )
            ->whereYear('data_vencimento', Carbon::now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = [];
        $valoresPagos = [];
        $valoresPendentes = [];

        for ($i = 1; $i <= 12; $i++) {
            $faturamento = $faturamentoAnual->firstWhere('mes', $i);
            $meses[] = Carbon::create()->month($i)->format('M');
            $valoresPagos[] = $faturamento ? $faturamento->valor_pago : 0;
            $valoresPendentes[] = $faturamento ? $faturamento->valor_pendente : 0;
        }

        return view('home', compact(
            'clientesAtivos',
            'faturamentoMensal',
            'contasVencidas',
            'ticketsAbertos',
            'meses',
            'valoresPagos',
            'valoresPendentes'
        ));
    }
}
