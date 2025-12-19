<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket envoyé</title>    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-2">Merci</h1>
                    <p class="text-muted mb-4">Votre ticket a bien été envoyé. Un technicien le traitera dès que possible.</p>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Créer un nouveau ticket</a>
                        <a href="{{ route('technician.login') }}" class="btn btn-outline-secondary">Accès technicien</a>
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
