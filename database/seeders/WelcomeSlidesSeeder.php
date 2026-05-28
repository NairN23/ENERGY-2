<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WelcomeSlide;

class WelcomeSlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WelcomeSlide::create([
            'imagen' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=2000',
            'titulo_blanco' => 'Potenciá',
            'titulo_rojo' => 'tu mejor versión',
            'orden' => 1,
        ]);

        WelcomeSlide::create([
            'imagen' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&q=80&w=2000',
            'titulo_blanco' => 'Calidad',
            'titulo_rojo' => 'Garantizada',
            'orden' => 2,
        ]);

        WelcomeSlide::create([
            'imagen' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=2000',
            'titulo_blanco' => 'Envíos a',
            'titulo_rojo' => 'Todo el NEA',
            'orden' => 3,
        ]);
    }
}
