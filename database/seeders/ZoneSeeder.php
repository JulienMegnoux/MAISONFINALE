<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    public function run()
    {
        $zones = [
            'Salon',
            'Salle de bain',
            'Cuisine',
            'Chambre 1',
            'Chambre 2',
            'Salle à manger',
            'Extérieur'
        ];

        foreach ($zones as $zone) {
            Zone::create(['nom' => $zone]);
        }
    }
}
