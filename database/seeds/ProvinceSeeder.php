<?php

use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * @var array All the provinces in Spain
     */
    protected $provinces = [
        'Álava',
        'Albacete',
        'Alicante',
        'Almería',
        'Ávila',
        'Badajoz',
        'Baleares (Illes)',
        'Barcelona',
        'Burgos',
        'Cáceres',
        'Cádiz',
        'Castellón',
        'Ciudad Real',
        'Córdoba',
        'A Coruña',
        'Cuenca',
        'Girona',
        'Granada',
        'Guadalajara',
        'Guipúzcoa',
        'Huelva',
        'Huesca',
        'Jaén',
        'León',
        'Lleida',
        'La Rioja',
        'Lugo',
        'Madrid',
        'Málaga',
        'Murcia',
        'Navarra',
        'Ourense',
        'Asturias',
        'Palencia',
        'Las Palmas',
        'Pontevedra',
        'Salamanca',
        'Santa Cruz de Tenerife',
        'Cantabria',
        'Segovia',
        'Sevilla',
        'Soria',
        'Tarragona',
        'Teruel',
        'Toledo',
        'Valencia',
        'Valladolid',
        'Vizcaya',
        'Zamora',
        'Zaragoza',
        'Ceuta',
        'Melilla',
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->provinces as $province) {
            DB::table('province')->insert([
                'name' => $province,
            ]);
        }
    }
}
