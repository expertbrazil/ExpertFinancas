<?php

namespace App\Http\Controllers;

use App\Models\HostingPlan;
use App\Rules\MediaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HostingPlanController extends Controller
{
    public function index()
    {
        $plans = HostingPlan::all();
        return view('planos.index', compact('plans'));
    }

    public function create()
    {
        return view('planos.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'monthly_price' => ['required', 'numeric', 'min:0'],
                'semiannual_price' => ['required', 'numeric', 'min:0'],
                'annual_price' => ['required', 'numeric', 'min:0'],
                'image' => ['nullable', new MediaRule()],
                'active' => ['boolean'],
            ]);

            $data = $request->except('image');
            
            if ($request->hasFile('image')) {
                try {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = Str::slug($request->name) . '-' . time() . '.' . $extension;
                    
                    // Garante que o diretório existe
                    $directory = 'planos/imagens';
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }
                    
                    // Log informações do arquivo
                    \Log::info('Tentando fazer upload de imagem', [
                        'original_name' => $file->getClientOriginalName(),
                        'extension' => $extension,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'target_path' => $directory . '/' . $filename
                    ]);
                    
                    // Salva o arquivo
                    $path = $file->storeAs($directory, $filename, 'public');
                    
                    if (!$path) {
                        throw new \Exception('Falha ao salvar o arquivo.');
                    }
                    
                    $data['image'] = $path;
                    
                    \Log::info('Upload de imagem bem-sucedido', [
                        'path' => $path
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Erro no upload da imagem', [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]);
                    
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Erro ao fazer upload da imagem: ' . $e->getMessage()]);
                }
            }

            $data['active'] = $request->boolean('active');

            HostingPlan::create($data);

            return redirect()->route('planos.index')
                ->with('success', 'Plano criado com sucesso.');
                
        } catch (\Exception $e) {
            \Log::error('Erro ao criar plano de hospedagem', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Erro ao criar plano: ' . $e->getMessage()]);
        }
    }

    public function edit(HostingPlan $plano)
    {
        return view('planos.edit', compact('plano'));
    }

    public function update(Request $request, HostingPlan $plano)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'monthly_price' => ['required', 'numeric', 'min:0'],
                'semiannual_price' => ['required', 'numeric', 'min:0'],
                'annual_price' => ['required', 'numeric', 'min:0'],
                'image' => ['nullable', new MediaRule()],
                'active' => ['boolean'],
            ]);

            $data = $request->except('image');

            if ($request->hasFile('image')) {
                try {
                    // Remove a imagem antiga se existir
                    if ($plano->image && Storage::disk('public')->exists($plano->image)) {
                        Storage::disk('public')->delete($plano->image);
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = Str::slug($request->name) . '-' . time() . '.' . $extension;
                    
                    // Garante que o diretório existe
                    $directory = 'planos/imagens';
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }
                    
                    // Salva o arquivo
                    $path = $file->storeAs($directory, $filename, 'public');
                    
                    if (!$path) {
                        throw new \Exception('Falha ao salvar o arquivo.');
                    }
                    
                    $data['image'] = $path;
                } catch (\Exception $e) {
                    \Log::error('Erro no upload da imagem', [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]);
                    
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Erro ao fazer upload da imagem: ' . $e->getMessage()]);
                }
            }

            $data['active'] = $request->boolean('active');

            $plano->update($data);

            return redirect()->route('planos.index')
                ->with('success', 'Plano atualizado com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar plano de hospedagem', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Erro ao atualizar plano: ' . $e->getMessage()]);
        }
    }

    public function destroy(HostingPlan $plano)
    {
        try {
            if ($plano->image && Storage::disk('public')->exists($plano->image)) {
                Storage::disk('public')->delete($plano->image);
            }

            $plano->delete();

            return redirect()->route('planos.index')
                ->with('success', 'Plano excluído com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir plano de hospedagem', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Erro ao excluir plano: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus(HostingPlan $plano)
    {
        try {
            $plano->update(['active' => !$plano->active]);

            return redirect()->route('planos.index')
                ->with('success', 'Status do plano atualizado com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao alterar status do plano', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Erro ao alterar status do plano: ' . $e->getMessage()]);
        }
    }
}
