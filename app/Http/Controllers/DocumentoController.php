<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::with(['cliente'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        $clientes = Cliente::where('ativo', true)->get();
        return view('documentos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'arquivo' => 'required|file|max:10240', // máximo 10MB
            'tipo' => 'required|in:contrato,nota_fiscal,recibo,outros'
        ]);

        $arquivo = $request->file('arquivo');
        $nomeArquivo = time() . '_' . Str::slug($request->titulo) . '.' . $arquivo->getClientOriginalExtension();
        $caminhoArquivo = $arquivo->storeAs('documentos', $nomeArquivo, 'public');

        $documento = new Documento();
        $documento->cliente_id = $request->cliente_id;
        $documento->titulo = $request->titulo;
        $documento->descricao = $request->descricao;
        $documento->tipo = $request->tipo;
        $documento->arquivo_path = $caminhoArquivo;
        $documento->arquivo_nome = $arquivo->getClientOriginalName();
        $documento->arquivo_tipo = $arquivo->getClientMimeType();
        $documento->arquivo_tamanho = $arquivo->getSize();
        $documento->save();

        return redirect()->route('documentos.show', $documento)
            ->with('success', 'Documento enviado com sucesso!');
    }

    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    public function edit(Documento $documento)
    {
        $clientes = Cliente::where('ativo', true)->get();
        return view('documentos.edit', compact('documento', 'clientes'));
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'arquivo' => 'nullable|file|max:10240', // máximo 10MB
            'tipo' => 'required|in:contrato,nota_fiscal,recibo,outros'
        ]);

        if ($request->hasFile('arquivo')) {
            // Remove o arquivo antigo
            Storage::disk('public')->delete($documento->arquivo_path);

            // Salva o novo arquivo
            $arquivo = $request->file('arquivo');
            $nomeArquivo = time() . '_' . Str::slug($request->titulo) . '.' . $arquivo->getClientOriginalExtension();
            $caminhoArquivo = $arquivo->storeAs('documentos', $nomeArquivo, 'public');

            $documento->arquivo_path = $caminhoArquivo;
            $documento->arquivo_nome = $arquivo->getClientOriginalName();
            $documento->arquivo_tipo = $arquivo->getClientMimeType();
            $documento->arquivo_tamanho = $arquivo->getSize();
        }

        $documento->cliente_id = $request->cliente_id;
        $documento->titulo = $request->titulo;
        $documento->descricao = $request->descricao;
        $documento->tipo = $request->tipo;
        $documento->save();

        return redirect()->route('documentos.show', $documento)
            ->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy(Documento $documento)
    {
        // Remove o arquivo físico
        Storage::disk('public')->delete($documento->arquivo_path);

        // Remove o registro do banco
        $documento->delete();

        return redirect()->route('documentos.index')
            ->with('success', 'Documento excluído com sucesso!');
    }

    public function download(Documento $documento)
    {
        return Storage::disk('public')->download(
            $documento->arquivo_path,
            $documento->arquivo_nome
        );
    }
}
