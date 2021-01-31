@extends('wisata.main');

@section('title', 'Tambah Wisata');

@section('styles')
    <style>
        body {
            margin-top: 80px;
        }
        #map { width: 610px; height: 300px; }
    </style>
@endsection

@section('content')
    {{-- content --}}

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-5">
                    <div class="card-header">
                            Tambah Wisata
                    </div>
                    <div class="card-body">
                    <form action="/wisata/create" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Wisata</label>
                                <input type="text" class="form-control @error('nama_wisata') is-invalid @enderror" name="nama_wisata" placeholder="nama wisata" value="{{ old('nama_wisata') }}">
                                @error('nama_wisata')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" placeholder="alamat wisata" name="alamat" style="height: 100px">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" placeholder="kabupaten wisata" value="{{ old('kabupaten') }}">
                                @error('kabupaten')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Wisata</label>
                                <select class="form-select" name="jenis_wisata" aria-label="Default select example">
                                    <option value="Alam">Alam</option>
                                    <option value="Agama">Agama</option>
                                    <option value="Budaya">Budaya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Url gambar</label>
                                <input type="text" class="form-control" name="foto" placeholder="Foto" value="{{ old('foto') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" id="latitude" name="langitude" value="@if(request()){{ request('lat')}}@endif" class="form-control @error('langitude') is-invalid @enderror" placeholder="titik latitude">
                                    @error('langitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" value="@if(request()){{ request('long')}}@endif" class="form-control @error('longitude') is-invalid @enderror" placeholder="titik longitude">
                                    @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="m-2 my-2" id="map"></div>
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

    var mymap = L.map('map').setView([{{ request('lat', 0.9) }}, {{ request('long', 101.5) }} ], 7);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: accessToken
    }).addTo(mymap);

    theMarker = L.marker([ {{ request('lat', 0.9) }}, {{ request('long',  101.5) }}]).addTo(mymap);

    mymap.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude, longitude);
    });

    function updateMarker(lat, lng) {
        theMarker
        .setLatLng([lat, lng])
        .bindPopup("Lokasi : " + lat + ", " + lng + ".")
        .openPopup();
        return false;
    };

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);

</script>

@endpush