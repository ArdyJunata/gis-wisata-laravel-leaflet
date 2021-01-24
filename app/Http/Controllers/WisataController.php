<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Wisata;

class WisataController extends Controller
{
    public function index() {
        $all = Wisata::all()->toArray();
        $alam = Wisata::select()->where('jenis_wisata', 'Alam')->get()->toArray();
        $agama = Wisata::select()->where('jenis_wisata', 'Agama')->get()->toArray();
        $budaya = Wisata::select()->where('jenis_wisata', 'Budaya')->get()->toArray();

        // dd($alam);

        $featureAll = [];
        $featureAlam = [];
        $featureAgama = [];
        $featureBudaya = [];

        foreach($all as $item) {
            array_push($featureAll, $this->geometry($item));
        }

        foreach($alam as $item) {
            array_push($featureAlam, $this->geometry($item));
        }

        foreach($agama as $item) {
            array_push($featureAgama, $this->geometry($item));
        }

        foreach($budaya as $item) {
            array_push($featureBudaya, $this->geometry($item));
        }

        $semua = $this->geoJson($featureAll);
        $geoAlam = $this->geoJson($featureAlam);
        $geoAgama = $this->geoJson($featureAgama);
        $geoBudaya = $this->geoJson($featureBudaya);
        
        return view('wisata.index', ['all' => $semua, 'alam' => $geoAlam, 'budaya' => $geoBudaya, 'agama' => $geoAgama]);
    }

    public function detail($id)
    {
        $data = Wisata::select(
            'id',
            'nama_wisata',
            'alamat',
            'kabupaten',
            'jenis_wisata',
            'foto',
            'langitude',
            'longitude'
        )->where('id', $id)->first()->toArray();

        // dd($data);   

        $feature = [];
        array_push($feature, $this->geometry($data));

        $geoJson = $this->geoJson($feature);

        // dd($geoJson);

        return view('wisata.detail', ['geoJson' => $geoJson, 'data' => $data]);
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'nama_wisata' => 'required',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'jenis_wisata' => 'required',
            'foto' => 'required',
            'langitude' => 'required',
            'longitude' => 'required'
        ]);

        $data = Wisata::create($validate);

        // dd($data);

        return redirect('/wisata/list')->with('status', 'Data wisata berhasil ditambahkan !');

    }

    public function formInput()
    {
        return view('wisata.create');
    }

    public function list()
    {
        $data = Wisata::all();

        return view('wisata.list', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_wisata' => 'required',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'jenis_wisata' => 'required',
            'foto' => 'required',
            'langitude' => 'required',
            'longitude' => 'required'
        ]);

        $data = Wisata::find($id);
        $data->nama_wisata = $request->nama_wisata;
        $data->alamat = $request->alamat;
        $data->kabupaten = $request->kabupaten;
        $data->jenis_wisata = $request->jenis_wisata;
        $data->foto = $request->foto;
        $data->langitude = $request->langitude;
        $data->longitude = $request->longitude;
        $data->save();

        return redirect('/wisata/detail/' . $id)->with('status', 'Data Berhasil di Update !');
    }

    public function delete($id)
    {
        $data = Wisata::find($id);
        $data->delete();
        return redirect('/wisata/list')->with('status', 'Data wisata berhasil dihapus !');
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
                'jenis_wisata' => $item['jenis_wisata'],
                'kabupaten' => $item['kabupaten'],
                'foto' => $item['foto']
            ]
        ];
    }
}
