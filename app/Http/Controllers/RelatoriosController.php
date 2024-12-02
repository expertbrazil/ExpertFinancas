<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function clientes()
    {
        return view('relatorios.clientes');
    }

    public function faturas()
    {
        return view('relatorios.faturas');
    }

    public function tickets()
    {
        return view('relatorios.tickets');
    }

    public function financeiro()
    {
        return view('relatorios.financeiro');
    }
}
