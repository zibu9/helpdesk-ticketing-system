<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Créer un ticket réseau</h1>

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

                    <form method="POST" action="{{ route('tickets.store') }}" class="vstack gap-3">
                        @csrf

                        <div>
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

                        <div>
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
                            <div class="form-text">Décris le problème (au moins 10 caractères).</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Envoyer le ticket</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center small text-muted mt-3">
                Accès technicien : <a href="{{ route('login') }}">se connecter</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
