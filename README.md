# Helpdesk Ticketing System

Helpdesk réseau simplifié construit avec Laravel.

Objectif : un utilisateur **sans compte** peut créer un ticket, et un technicien (connexion **manuelle** basée sur la **session**) peut consulter/traiter les tickets.

## 1) Modélisation (base de données)

### Tables

#### `users` (techniciens)

Table standard Laravel utilisée ici comme base des comptes techniciens (connexion manuelle).

- `id`
- `name` (string)
- `email` (string, unique)
- `password` (string, hashé)
- `created_at`, `updated_at`

#### `tickets`

- `id`
- `name` (string) : nom du demandeur
- `email` (string) : email du demandeur
- `issue_type` (string) : type de problème (Internet / Wi‑Fi / …)
- `description` (text) : description du problème
- `status` (enum) : `ouvert` | `en_cours` | `resolu`
- `assigned_to` (nullable FK -> `users.id`) : technicien assigné (MVP)
- `created_at`, `updated_at`

#### `ticket_comments`

- `id`
- `ticket_id` (FK -> `tickets.id`, cascade delete)
- `user_id` (FK -> `users.id`, cascade delete) : technicien auteur
- `comment` (text)
- `created_at`, `updated_at`

### Relations Eloquent

#### `Ticket`

- `Ticket::comments()` : `hasMany(TicketComment::class)`
- `Ticket::technician()` : `belongsTo(User::class, 'assigned_to')`

#### `TicketComment`

- `TicketComment::ticket()` : `belongsTo(Ticket::class)`
- `TicketComment::author()` : `belongsTo(User::class, 'user_id')`

## 2) Fonctionnalités MVP

### Utilisateur (sans compte)

- **Créer un ticket**
- **Page de confirmation**

### Technicien (connexion manuelle)

- Se connecter via `/technician/login`
- Voir la liste des tickets
- Voir le détail d’un ticket
- Changer le statut (`ouvert`, `en_cours`, `resolu`)
- Ajouter un commentaire
- Se déconnecter

Contraintes :

- Pas de permissions complexes
- Pas de notifications
- Pas de JS lourd

## 3) Auth technicien (session-only)

Ce projet n’utilise **pas** Breeze/Jetstream et n’utilise pas `auth()` pour l’espace technicien.

Principe :

- Au login, l’id du technicien est stocké en session : `technician_id`
- Le middleware `technician.auth` protège les routes `/technician/*`
- Le middleware `technician.guest` empêche un technicien déjà connecté d’accéder au formulaire de login

## 4) Routes principales

### Public

- `GET /tickets/create` : formulaire
- `POST /tickets` : enregistrement
- `GET /tickets/confirmation` : confirmation

### Technicien

- `GET /technician/login`
- `POST /technician/login`
- `POST /technician/logout`
- `GET /technician/tickets`
- `GET /technician/tickets/{ticket}`
- `PATCH /technician/tickets/{ticket}/status`
- `POST /technician/tickets/{ticket}/comments`

## 5) Structure du code (MVP)

### Controllers

- `app/Http/Controllers/TicketController.php`
- `app/Http/Controllers/Technician/TicketController.php`
- `app/Http/Controllers/Auth/LoginController.php`

### Requests

- `app/Http/Requests/StoreTicketRequest.php`

### Middlewares

- `app/Http/Middleware/TechnicianAuth.php`
- `app/Http/Middleware/TechnicianGuest.php`

Enregistrement (Laravel 11+) : `bootstrap/app.php` (`$middleware->alias([...])`).

### Vues

- `resources/views/tickets/create.blade.php`
- `resources/views/tickets/confirmation.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/technician/tickets/index.blade.php`
- `resources/views/technician/tickets/show.blade.php`

## 6) Installation & exécution (local)

### Prérequis

- PHP 8.2+
- Composer

### Installer

```bash
composer install
copy .env.example .env
php artisan key:generate
```

### Base de données

Ce projet fonctionne avec SQLite (rapide pour le MVP). Assure-toi que le fichier existe :

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Puis :

```bash
php artisan migrate:fresh --seed
```

### Lancer le serveur

```bash
php artisan serve
```

## 7) Compte technicien (seed)

Le seeder `Database\Seeders\TechnicianSeeder` crée un technicien par défaut :

- Email : `tech@example.com`
- Mot de passe : `password`

Login :

- `http://127.0.0.1:8000/technician/login`

## 8) Notes MVP

- Les statuts autorisés sont limités à : `ouvert`, `en_cours`, `resolu`.
