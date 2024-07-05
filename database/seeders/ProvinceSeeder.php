<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Province;

class ProvinceSeeder extends Seeder
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
        ])->get('https://api.rajaongkir.com/starter/province'); 

        $provinces = $response['rajaongkir']['results'];

        foreach($provinces as $province){
            $data[] = [
                'id' => $province['province_id'],
                'province' => $province['province']
            ];
        }

        Province::insert($data);
    }
}
