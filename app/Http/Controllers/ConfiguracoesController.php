<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function empresa()
    {
        return view('configuracoes.empresa');
    }

    public function usuarios()
    {
        return view('configuracoes.usuarios');
    }

    public function permissoes()
    {
        return view('configuracoes.permissoes');
    }

    public function notificacoes()
    {
        return view('configuracoes.notificacoes');
    }

    public function integracao()
    {
        return view('configuracoes.integracao');
    }

    public function backup()
    {
        return view('configuracoes.backup');
    }

    public function logs()
    {
        return view('configuracoes.logs');
    }
}
