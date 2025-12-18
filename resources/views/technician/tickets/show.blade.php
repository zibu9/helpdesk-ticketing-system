<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket #{{ $ticket->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    @php
        $connectedTechnician = session('technician_id')
            ? \App\Models\User::find(session('technician_id'))
            : null;

        $statusClass = match ($ticket->status) {
            'ouvert' => 'bg-warning text-dark',
            'en_cours' => 'bg-primary',
            'resolu' => 'bg-success',
            default => 'bg-secondary',
        };
    @endphp

    <div class="d-flex align-items-start justify-content-between mb-3">
        <div>
            <div class="text-muted small">
                <a href="{{ route('technician.tickets.index') }}" class="text-decoration-none">Tickets</a>
                <span class="mx-1">/</span>
                <span>Ticket #{{ $ticket->id }}</span>
            </div>
            <div class="d-flex align-items-center gap-2 mt-1">
                <h1 class="h4 mb-0">Ticket #{{ $ticket->id }}</h1>
                <span class="badge {{ $statusClass }}">{{ str_replace('_', ' ', $ticket->status) }}</span>
            </div>
            <div class="text-muted small mt-1">
                @if ($connectedTechnician)
                    Connecté : {{ $connectedTechnician->name }}
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('technician.tickets.index') }}" class="btn btn-outline-secondary btn-sm">Retour</a>
            <form method="POST" action="{{ route('technician.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Déconnexion</button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="fw-semibold mb-1">Veuillez corriger les erreurs ci-dessous.</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h6 mb-0">Informations</h2>
                        <span class="text-muted small">{{ $ticket->created_at?->format('d/m/Y H:i') }}</span>
                    </div>

                    <dl class="row mb-0">
                        <dt class="col-4">Nom</dt>
                        <dd class="col-8">{{ $ticket->name }}</dd>

                        <dt class="col-4">Email</dt>
                        <dd class="col-8">{{ $ticket->email }}</dd>

                        <dt class="col-4">Type</dt>
                        <dd class="col-8">{{ $ticket->issue_type }}</dd>

                        <dt class="col-4">Statut</dt>
                        <dd class="col-8">
                            <span class="badge {{ $statusClass }}">
                                {{ str_replace('_', ' ', $ticket->status) }}
                            </span>
                        </dd>

                        <dt class="col-4">Assigné</dt>
                        <dd class="col-8">{{ $ticket->technician?->name ?? '—' }}</dd>

                    </dl>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h2 class="h6 mb-2">Description</h2>
                    <div class="text-body-secondary" style="white-space: pre-wrap;">{{ $ticket->description }}</div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h2 class="h6 mb-1">Changer le statut</h2>
                    <div class="text-muted small mb-3">Utilise ce menu pour suivre l'avancement du ticket.</div>

                    <form method="POST" action="{{ route('technician.tickets.status.update', $ticket) }}" class="vstack gap-2">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="form-label">Nouveau statut</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="ouvert" @selected(old('status', $ticket->status) === 'ouvert')>Ouvert</option>
                                <option value="en_cours" @selected(old('status', $ticket->status) === 'en_cours')>En cours</option>
                                <option value="resolu" @selected(old('status', $ticket->status) === 'resolu')>Résolu</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Mettre à jour le statut</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h6 mb-0">Commentaires</h2>
                        <span class="text-muted small">{{ $ticket->comments->count() }} commentaire(s)</span>
                    </div>

                    @if ($ticket->comments->isEmpty())
                        <div class="text-muted">Aucun commentaire pour le moment.</div>
                    @else
                        <div class="vstack gap-3">
                            @foreach ($ticket->comments as $comment)
                                <div class="border rounded-3 p-3 bg-white">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="fw-semibold">{{ $comment->author?->name ?? 'Technicien' }}</div>
                                        <div class="text-muted small">{{ $comment->created_at?->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div style="white-space: pre-wrap;">{{ $comment->comment }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h2 class="h6 mb-1">Ajouter un commentaire</h2>
                    <div class="text-muted small mb-3">Ajoute une note visible dans l'historique du ticket.</div>

                    <form method="POST" action="{{ route('technician.tickets.comments.store', $ticket) }}" class="vstack gap-2">
                        @csrf

                        <div>
                            <label for="comment" class="form-label">Commentaire</label>
                            <textarea
                                id="comment"
                                name="comment"
                                rows="4"
                                class="form-control @error('comment') is-invalid @enderror"
                                required
                            >{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
