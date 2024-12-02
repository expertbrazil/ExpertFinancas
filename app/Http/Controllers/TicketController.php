<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Ticket::with('cliente')
            ->when($request->cliente, function ($q) use ($request) {
                return $q->whereHas('cliente', function ($q) use ($request) {
                    $q->where('razao_social', 'like', "%{$request->cliente}%")
                      ->orWhere('nome_completo', 'like', "%{$request->cliente}%");
                });
            })
            ->when($request->status, function ($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->prioridade, function ($q) use ($request) {
                return $q->where('prioridade', $request->prioridade);
            })
            ->when($request->categoria, function ($q) use ($request) {
                return $q->where('categoria', $request->categoria);
            })
            ->latest();

        // Estatísticas
        $stats = [
            'total' => Ticket::count(),
            'abertos' => Ticket::where('status', 'aberto')->count(),
            'em_andamento' => Ticket::where('status', 'em_andamento')->count(),
            'fechados' => Ticket::where('status', 'fechado')->count()
        ];

        // Lista de categorias únicas
        $categorias = Ticket::distinct()->pluck('categoria')->filter()->values();

        return view('tickets.index', [
            'tickets' => $query->paginate(15)->withQueryString(),
            'stats' => $stats,
            'categorias' => $categorias
        ]);
    }

    public function create()
    {
        $clientes = Cliente::orderBy('razao_social')->get();
        return view('tickets.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'categoria' => 'required|string|max:100',
        ]);

        $ticket = new Ticket($validatedData);
        $ticket->status = 'aberto';
        $ticket->user_id = Auth::id();
        $ticket->save();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket criado com sucesso!');
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $clientes = Cliente::orderBy('razao_social')->get();
        return view('tickets.edit', compact('ticket', 'clientes'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'categoria' => 'required|string|max:100',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket atualizado com sucesso!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket excluído com sucesso!');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:aberto,em_andamento,fechado'
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->back()
            ->with('success', 'Status do ticket atualizado com sucesso!');
    }

    // API Methods
    public function apiIndex()
    {
        $tickets = Ticket::with(['cliente', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        return response()->json($tickets);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string|max:50',
            'cliente_id' => 'required|exists:clientes,id',
            'prioridade' => 'required|in:baixa,media,alta'
        ]);

        $ticket = new Ticket();
        $ticket->titulo = $request->titulo;
        $ticket->descricao = $request->descricao;
        $ticket->categoria = $request->categoria;
        $ticket->prioridade = $request->prioridade;
        $ticket->user_id = Auth::id();
        $ticket->cliente_id = $request->cliente_id;
        $ticket->status = 'aberto';
        $ticket->save();

        return response()->json($ticket->load(['cliente', 'user']), 201);
    }

    public function apiShow(Ticket $ticket)
    {
        return response()->json($ticket->load(['respostas.user', 'cliente', 'user']));
    }

    public function apiResponder(Request $request, Ticket $ticket)
    {
        $request->validate([
            'resposta' => 'required|string'
        ]);

        $resposta = $ticket->respostas()->create([
            'user_id' => Auth::id(),
            'resposta' => $request->resposta,
            'is_staff' => Auth::user()->isAdmin()
        ]);

        if ($ticket->status === 'aberto') {
            $ticket->update(['status' => 'em_andamento']);
        }

        return response()->json($resposta->load('user'));
    }

    public function apiUpdateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:aberto,em_andamento,fechado'
        ]);

        $ticket->update(['status' => $request->status]);
        return response()->json($ticket);
    }
}
