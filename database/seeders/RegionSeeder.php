<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $regions = [
        [
            'name' => 'Adamaoua',
            'code' => 'AD',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Centre',
            'code' => 'CE',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Est',
            'code' => 'ES',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Extrême-Nord',
            'code' => 'EN',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Littoral',
            'code' => 'LT',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Nord',
            'code' => 'NO',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Nord-Ouest',
            'code' => 'NW',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Ouest',
            'code' => 'OU',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Sud',
            'code' => 'SU',
            'country' => 'Cameroun',
        ],
        [
            'name' => 'Sud-Ouest',
            'code' => 'SW',
            'country' => 'Cameroun',
        ],
    ];

    foreach ($regions as $region) {
        Region::create($region);
    }
}
}
