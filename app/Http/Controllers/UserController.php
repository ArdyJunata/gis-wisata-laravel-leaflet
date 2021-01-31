<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;

class UserController extends Controller
{
    public function index()
    {
        $all = Wisata::all()->toArray();

        // dd($alam);

        $featureAll = [];

        foreach($all as $item) {
            array_push($featureAll, $this->geometry($item));
        }

        $semua = $this->geoJson($featureAll);
        
        return view('user.index', ['all' => $semua]);
    }

    public function geoJson ($feature)
    {
        return [
            'type' => 'FeatureCollection',
            'crs' => [
                'type' => 'name',
                'properties' => [
                    'name' => 'EPSG:4326'
                ]
            ],
            'features' => $feature
        ];
    }

    public function geometry($item)
    {
        return [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [ $item['longitude'] , $item['langitude'] ]
            ],
            'properties' => [
                'id' => $item['id'],
                'nama_wisata' => $item['nama_wisata'],
                'alamat' => $item['alamat'],
                'jenis_wisata' => $item['jenis_wisata'],
                'kabupaten' => $item['kabupaten'],
                'foto' => $item['foto']
            ]
        ];
    }
}
