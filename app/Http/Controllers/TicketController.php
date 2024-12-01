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
        $this->middleware(['auth']);
        $this->middleware('role:admin')->only(['index', 'updateStatus']);
    }

    public function index()
    {
        $tickets = Ticket::with(['cliente', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $clientes = [];
        if (Auth::user()->isAdmin()) {
            $clientes = Cliente::where('ativo', true)->get();
        }

        return view('tickets.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string|max:50',
            'cliente_id' => Auth::user()->isAdmin() ? 'required|exists:clientes,id' : '',
            'prioridade' => 'required|in:baixa,media,alta'
        ]);

        $ticket = new Ticket();
        $ticket->titulo = $request->titulo;
        $ticket->descricao = $request->descricao;
        $ticket->categoria = $request->categoria;
        $ticket->prioridade = $request->prioridade;
        $ticket->user_id = Auth::id();
        $ticket->cliente_id = Auth::user()->isAdmin() ? $request->cliente_id : Auth::user()->cliente_id;
        $ticket->status = 'aberto';
        $ticket->save();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket criado com sucesso!');
    }

    public function show(Ticket $ticket)
    {
        if (!Auth::user()->isAdmin() && Auth::user()->cliente_id !== $ticket->cliente_id) {
            abort(403);
        }

        $ticket->load(['respostas.user', 'cliente', 'user']);
        return view('tickets.show', compact('ticket'));
    }

    public function responder(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->isAdmin() && Auth::user()->cliente_id !== $ticket->cliente_id) {
            abort(403);
        }

        $request->validate([
            'resposta' => 'required|string'
        ]);

        $ticket->respostas()->create([
            'user_id' => Auth::id(),
            'resposta' => $request->resposta,
            'is_staff' => Auth::user()->isAdmin()
        ]);

        if ($ticket->status === 'aberto') {
            $ticket->update(['status' => 'em_andamento']);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Resposta adicionada com sucesso!');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:aberto,em_andamento,fechado'
        ]);

        $ticket->update(['status' => $request->status]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Status do ticket atualizado com sucesso!');
    }
}
