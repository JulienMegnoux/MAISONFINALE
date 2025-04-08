<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeObjet;

class TypeObjetSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Lampe',
            'Thermostat',
            'Alarme',
            'Portail',
            'Volets',
            'Interphone connecté',
            'Caméra de surveillance',
            'Aspirateur robot',
            'Serrure connectée',
            'Capteur de qualité de l\'air'
        ];

        foreach ($types as $type) {
            TypeObjet::create(['nom' => $type]);
        }
    }
}
