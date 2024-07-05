<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'key' => 'fe254777c8fc0eb5cfd515fdfe32c74d'
        ])->get('https://api.rajaongkir.com/starter/city'); 
        
        $cities = $response['rajaongkir']['results'];

        foreach($cities as $city){
            $data[] = [
                'id' => $city['city_id'],
                'city_name' => $city['city_name'],
                'province_id' => $city['province_id'],
                'type' => $city['type'],
                'postal_code' => $city['postal_code'],
            ];
        }

        City::insert($data);
    }
}
