<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => Plan::FREE,
                'description' => 'Acceso gratuito con texto y audio básico.',
                'price_cents' => 0,
                'currency' => 'USD',
                'features' => [
                    'texto' => true,
                    'audio' => true,
                    'emociones' => false,
                ],
                'trial_days' => 0,
            ],
            [
                'name' => 'Pro',
                'slug' => Plan::PRO,
                'description' => 'Acceso avanzado con audio y reconocimiento de emociones.',
                'price_cents' => 1990,
                'currency' => 'USD',
                'features' => [
                    'texto' => true,
                    'audio' => true,
                    'emociones' => true,
                ],
                'trial_days' => 7,
            ],
            [
                'name' => 'Plus',
                'slug' => Plan::PLUS,
                'description' => 'Acceso completo con análisis extendido y resultados prioritarios.',
                'price_cents' => 2990,
                'currency' => 'USD',
                'features' => [
                    'texto' => true,
                    'audio' => true,
                    'emociones' => true,
                    'prioridad' => true,
                ],
                'trial_days' => 14,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
