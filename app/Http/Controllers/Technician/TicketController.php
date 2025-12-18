<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        $tickets = Ticket::query()
            ->latest()
            ->paginate(15);

        return view('technician.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load([
            'technician',
            'comments.author',
        ]);

        return view('technician.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['ouvert', 'en_cours', 'resolu'])],
        ], [
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
        ]);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('technician.tickets.show', $ticket)
            ->with('success', 'Statut mis à jour.');
    }

    public function storeComment(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'min:2'],
        ], [
            'comment.required' => 'Le commentaire est obligatoire.',
            'comment.min' => 'Le commentaire doit contenir au moins :min caractères.',
        ]);

        $technicianId = $request->session()->get('technician_id');

        if (!$technicianId) {
            return redirect('/login');
        }

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $technicianId,
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('technician.tickets.show', $ticket)
            ->with('success', 'Commentaire ajouté.');
    }
}
