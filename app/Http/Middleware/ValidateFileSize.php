<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateFileSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Validar tamanho máximo de 5MB
            if ($file->getSize() > 5120 * 1024) {
                return response()->json([
                    'error' => 'O arquivo não pode ser maior que 5MB'
                ], 422);
            }
        }

        return $next($request);
    }
}
