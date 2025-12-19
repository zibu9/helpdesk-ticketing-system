<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion technicien</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="text-muted small">Helpdesk</div>
                        <h1 class="h5 mb-0">Connexion technicien</h1>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="fw-semibold mb-1">Impossible de se connecter.</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('technician.login.store') }}" class="vstack gap-3">
                        @csrf

                        <div>
                            <label for="email" class="form-label">E-mail</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                autocomplete="email"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="form-label">Mot de passe</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="current-password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>

                    <div class="text-center small text-muted mt-3">
                        <a href="{{ route('tickets.create') }}">Retour à la création de ticket</a>
                    </div>
                </div>
            </div>

            <div class="text-center small text-muted mt-3">
                URL technicien : <span class="font-monospace">/technician</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
