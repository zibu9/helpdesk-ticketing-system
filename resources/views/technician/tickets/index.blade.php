<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tickets (Technicien)</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
@php
    $connectedTechnician = session('technician_id')
        ? \App\Models\User::find(session('technician_id'))
        : null;
@endphp

<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <div class="text-muted small">
                Helpdesk technicien
                @if ($connectedTechnician)
                    — connecté : {{ $connectedTechnician->name }}
                @endif
            </div>
            <h1 class="h4 mb-0">Tickets</h1>
        </div>
        <form method="POST" action="{{ route('technician.logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Déconnexion</button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if ($tickets->count() === 0)
                <div class="p-4 text-muted">Aucun ticket pour le moment.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Créé</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                            @php
                                $statusClass = match ($ticket->status) {
                                    'ouvert' => 'bg-warning text-dark',
                                    'en_cours' => 'bg-primary',
                                    'resolu' => 'bg-success',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $ticket->email }}</td>
                                <td>{{ $ticket->issue_type }}</td>
                                <td>
                                    <span class="badge {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $ticket->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $ticket->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('technician.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
