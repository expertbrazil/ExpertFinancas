<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ApplySystemParameters
{
    public function handle(Request $request, Closure $next)
    {
        $parametros = Parametro::getAtivo();
        
        // Compartilha os parâmetros com todas as views
        View::share('systemParams', $parametros);
        
        // Adiciona o CSS dinâmico ao response
        $response = $next($request);
        
        if (method_exists($response, 'header')) {
            $css = $parametros->generateCss();
            $style = "<style>{$css}</style>";
            
            $content = $response->getContent();
            $content = str_replace('</head>', $style . '</head>', $content);
            $response->setContent($content);
        }
        
        return $response;
    }
}
