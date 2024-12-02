<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function receitas()
    {
        return view('financeiro.receitas');
    }

    public function despesas()
    {
        return view('financeiro.despesas');
    }

    public function fluxoCaixa()
    {
        return view('financeiro.fluxo-caixa');
    }

    public function conciliacao()
    {
        return view('financeiro.conciliacao');
    }
}
