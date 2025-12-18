<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function create(): View
    {
        return view('tickets.create');
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = 'ouvert';

        Ticket::create($data);

        return redirect()
            ->route('tickets.confirmation')
            ->with('success', 'Votre ticket a bien été créé.');
    }

    public function confirmation(): View
    {
        return view('tickets.confirmation');
    }
}
