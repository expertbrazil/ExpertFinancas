<?php

namespace App\Http\Controllers;

use App\Models\Parametro;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ParametroController extends Controller
{
    public function index()
    {
        $parametros = Parametro::all();
        return view('parametros.index', compact('parametros'));
    }

    public function create()
    {
        return view('parametros.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateParametro($request);
        
        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('public/logos');
        }

        Parametro::create($validated);

        return redirect()->route('parametros.index')
            ->with('success', 'Parâmetros criados com sucesso!');
    }

    public function edit()
    {
        $parametro = Parametro::first();
        if (!$parametro) {
            $parametro = Parametro::create([
                'nome_sistema' => 'Expert Finanças',
                'cor_primaria' => '#007bff',
                'cor_secundaria' => '#6c757d',
                'cor_fundo' => '#ffffff',
                'cor_texto' => '#212529',
                'cor_navbar' => '#343a40',
                'cor_footer' => '#f8f9fa',
            ]);
        }
        
        return view('parametros.edit', compact('parametro'));
    }

    public function update(Request $request)
    {
        $parametro = Parametro::first();
        
        $validated = $request->validate([
            'nome_sistema' => 'required|string|max:255',
            'cor_primaria' => 'required|string|max:7',
            'cor_secundaria' => 'required|string|max:7',
            'cor_fundo' => 'required|string|max:7',
            'cor_texto' => 'required|string|max:7',
            'cor_navbar' => 'required|string|max:7',
            'cor_footer' => 'required|string|max:7',
            'email_contato' => 'nullable|email|max:255',
            'telefone_contato' => 'nullable|string|max:20',
            'texto_rodape' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048'
        ]);

        try {
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path('logos/' . $filename);
                
                // Remove logo antiga se existir
                if ($parametro->logo_path && file_exists(public_path($parametro->logo_path))) {
                    unlink(public_path($parametro->logo_path));
                }

                // Se for SVG, move diretamente
                if ($file->getClientOriginalExtension() === 'svg') {
                    $file->move(public_path('logos'), $filename);
                } else {
                    // Para outros formatos, usa o Intervention Image
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($file->getRealPath());
                    $image->scale(width: 200);
                    
                    if ($file->getClientOriginalExtension() === 'png') {
                        $image->toPng()->save($path);
                    } else {
                        $image->toJpeg()->save($path);
                    }
                }

                $validated['logo_path'] = 'logos/' . $filename;
            }

            $parametro->update($validated);

            return redirect()->route('parametros.edit')
                ->with('success', 'Configurações atualizadas com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('parametros.edit')
                ->with('error', 'Erro ao atualizar as configurações: ' . $e->getMessage());
        }
    }

    public function destroy(Parametro $parametro)
    {
        // Não permite excluir se for o único registro
        if (Parametro::count() <= 1) {
            return redirect()->route('parametros.index')
                ->with('error', 'Não é possível excluir a única configuração do sistema.');
        }

        // Remove a logo se existir
        if ($parametro->logo_path) {
            unlink(public_path($parametro->logo_path));
        }

        $parametro->delete();

        return redirect()->route('parametros.index')
            ->with('success', 'Parâmetros excluídos com sucesso!');
    }

    private function validateParametro(Request $request)
    {
        return $request->validate([
            'nome_sistema' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'cor_primaria' => 'required|string|max:7',
            'cor_secundaria' => 'required|string|max:7',
            'cor_fundo' => 'required|string|max:7',
            'cor_texto' => 'required|string|max:7',
            'cor_navbar' => 'required|string|max:7',
            'cor_footer' => 'required|string|max:7',
            'email_contato' => 'nullable|email|max:255',
            'telefone_contato' => 'nullable|string|max:20',
            'texto_rodape' => 'nullable|string|max:1000',
        ]);
    }
}
