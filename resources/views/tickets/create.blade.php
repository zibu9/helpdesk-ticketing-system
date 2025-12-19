<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un ticket</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <div class="text-muted small">Helpdesk réseau</div>
                    <h1 class="h3 mb-1">Créer un ticket</h1>
                    <div class="text-muted">Décris ton problème, un technicien te recontactera si nécessaire.</div>
                </div>
                <div class="text-end">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Accès technicien</a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">

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

                    <form method="POST" action="{{ route('tickets.store') }}" class="vstack gap-4">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Nom</label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    autocomplete="name"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="issue_type" class="form-label">Type de problème</label>
                            <select
                                class="form-select @error('issue_type') is-invalid @enderror"
                                id="issue_type"
                                name="issue_type"
                                required
                            >
                                <option value="" @selected(old('issue_type') === null || old('issue_type') === '')>Choisir...</option>
                                <option value="Internet" @selected(old('issue_type') === 'Internet')>Internet</option>
                                <option value="Wi-Fi" @selected(old('issue_type') === 'Wi-Fi')>Wi‑Fi</option>
                                <option value="Câblage" @selected(old('issue_type') === 'Câblage')>Câblage</option>
                                <option value="VPN" @selected(old('issue_type') === 'VPN')>VPN</option>
                                <option value="Autre" @selected(old('issue_type') === 'Autre')>Autre</option>
                            </select>
                            @error('issue_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Choisis la catégorie qui se rapproche le plus.</div>
                        </div>

                        <div>
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="5"
                                required
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Décris le problème de façon précise (au moins 10 caractères).</div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2">
                            <div class="text-muted small">En envoyant, tu acceptes d'être recontacté à cet e-mail.</div>
                            <button type="submit" class="btn btn-primary">Envoyer le ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
