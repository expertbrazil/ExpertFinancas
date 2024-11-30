<?php

namespace App\Traits;

use App\Models\Atividade;
use Illuminate\Support\Facades\Auth;

trait LogActivityTrait
{
    protected function logActivity($acao, $entidade, $entidade_id, $detalhes = null)
    {
        try {
            Atividade::create([
                'user_id' => Auth::id(),
                'acao' => $acao,
                'entidade' => $entidade,
                'entidade_id' => $entidade_id,
                'detalhes' => $detalhes,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao registrar atividade: ' . $e->getMessage());
        }
    }

    protected function logCriacao($entidade, $entidade_id, $detalhes = null)
    {
        $this->logActivity('criar', $entidade, $entidade_id, $detalhes);
    }

    protected function logAtualizacao($entidade, $entidade_id, $detalhes = null)
    {
        $this->logActivity('atualizar', $entidade, $entidade_id, $detalhes);
    }

    protected function logExclusao($entidade, $entidade_id, $detalhes = null)
    {
        $this->logActivity('excluir', $entidade, $entidade_id, $detalhes);
    }

    protected function logAcesso($entidade, $entidade_id, $detalhes = null)
    {
        $this->logActivity('acessar', $entidade, $entidade_id, $detalhes);
    }
}
