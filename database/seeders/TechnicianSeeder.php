<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TechnicianSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'tech@example.com'],
            [
                'name' => 'Technicien',
                'password' => Hash::make('password'),
            ]
        );
    }
}
