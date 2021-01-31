@extends('wisata.main')

@section('styles')
    <style>
        body {
            margin-top: 80px;
        }
        #map { height: 400px; }

        #map-update { width:455px; height: 300px; }
    </style>
@endsection

@section('title', 'Detail')
   

@section('content')
    {{-- content --}}

   <div class="container">
   <div class="row">
        <div class="col-md-10 offset-md-1 d-flex justify-content-between">
            <h2>{{ $data['nama_wisata'] }}</h2>
        </div>
    </div> 
    @if (session('status'))
        <div class="row mt-2">
            <div class="col-md-10 offset-md-1">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
        </div> 
    @endif  
    <div class="row mt-2">
        <div class="col-md-5 offset-md-1">
            <div class="card mb-5">
                <div class="card-header">
                        Detail
                </div>
                <div class="card-body">
                    
                    <table class="table">
                        <tr>
                            <td class="text-center" colspan="2">
                            {{-- @if(str_contains($data['foto'], 'http' ) > 0 )
                                <img src="{{ $data['foto'] }}" width="200">
                            @else
                                <img src="{{ asset('assets/img/lokasi/' . $data['foto'] ) }}" width="200">
                            @endif --}}
                                <img src="{{ $data['foto'] }}" width="200">
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Wisata</td>
                            <td>{{ $data['nama_wisata'] }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Wisata</td>
                            <td>{{ $data['alamat'] }}</td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>{{ $data['kabupaten'] }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Wisata</td>
                            <td>{{ $data['jenis_wisata'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer text-muted">
                        <button type="submit" data-bs-toggle="modal" data-bs-target="#updateModal" class="btn btn-warning">Update</button>
                        <a href="/wisata/delete/{{ $data['id'] }}" class="btn btn-danger" >Hapus</a>
                    </div>   
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                        Maps
                </div>
                <div class="card-body">
                         <div id="map"></div>
                </div>
            </div>
        </div>
    </div>  
</div>

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Data Wisata</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                            <form action="/wisata/detail/{{ $data['id'] }}}" method="post" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="PUT">
                        @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Wisata</label>
                                <input type="text" value="{{ $data['nama_wisata'] }}" class="form-control" name="nama_wisata" placeholder="nama wisata">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea id="alamat" class="form-control" placeholder="" name="alamat" style="height: 100px">{{ $data['alamat'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" class="form-control" value="{{ $data['kabupaten'] }}" name="kabupaten" placeholder="kabupaten wisata">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Wisata</label>
                                <select class="form-select" name="jenis_wisata" aria-label="Default select example">
                                    <option value="{{ $data['jenis_wisata'] }}" selected>{{ $data['jenis_wisata'] }}</option>
                                    <option value="Alam">Alam</option>
                                    <option value="Agama">Agama</option>
                                    <option value="Budaya">Budaya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Url gambar</label>
                                <input type="text" class="form-control" value="{{ $data['foto'] }}" name="foto" placeholder="Foto">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" id="latitude" name="langitude" value="{{ $data['langitude'] }}" class="form-control" name="langitude" placeholder="titik latitude">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" value="{{ $data['longitude'] }}" class="form-control" name="longitude" placeholder="titik longitude">
                                </div>
                            </div>
                            <div class="row">
                                <div class="m-2 my-2" id="map-update"></div>
                            </div>
                        </div>
                    <div class="card-footer text-muted">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script>
        let accessToken = 'pk.eyJ1Ijoicml3YWxzeWFtIiwiYSI6ImNrajB5c21obTF1ZmQycnAyOTY3N2VycXUifQ.DAfn6MTxzf_BU3lqD0fIgQ'
        
        let lat = {{ $data['langitude'] }};
        let long = {{ $data['longitude'] }};

        var map2 = L.map('map-update').setView([0.9, 101.5], 7);
        
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: accessToken
        }).addTo(map2);

        marker = L.marker([ lat, long  ]).addTo(map2);

        map2.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);

            var popupContent = "Lokasi : " + latitude + ", " + longitude + ".";

            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            updateMarker(latitude, longitude, popupContent);
        });

        function updateMarker(lat, lng, popup) {
            marker
            .setLatLng([lat, lng])
            .bindPopup(popup)
            .openPopup();
            return false;
        };

        var updateMarkerByInputs = function() {
            return updateMarker( $('#latitude').val() , $('#longitude').val());
        }
        $('#latitude').on('input', updateMarkerByInputs);
        $('#longitude').on('input', updateMarkerByInputs);

        //detail map
        var mymap = L.map('map').setView([0.9, 101.5], 7);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: accessToken
        }).addTo(mymap);

        L.marker([ lat, long ]).addTo(mymap);
        

    </script>
@endpush