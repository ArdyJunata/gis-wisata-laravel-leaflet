<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
    <style>
        body {
            margin-top: 80px;
        }
        #map { width: 610px; height: 300px; }
    </style>
    <title>Maps</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-around">
            <a href="/wisata" class="navbar-brand">Admin </a>
            <div id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href=# class="nav-link active">Maps</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a href=# class="nav-link active">List</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href=# class="nav-link active dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- content --}}

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-5">
                    <div class="card-header">
                            Tambah Wisata
                    </div>
                    <div class="card-body">
                    <form action="/wisata/create" method="post" accept-charset="UTF-8">
                        @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Wisata</label>
                                <input type="text" class="form-control" name="nama_wisata" placeholder="nama wisata">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" placeholder="alamat wisata" name="alamat" style="height: 100px"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" class="form-control" name="kabupaten" placeholder="kabupaten wisata">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Wisata</label>
                                <select class="form-select" name="jenis_wisata" aria-label="Default select example">
                                    <option selected>pilih jenis wisata</option>
                                    <option value="Alam">Alam</option>
                                    <option value="Agama">Agama</option>
                                    <option value="Budaya">Budaya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Url gambar</label>
                                <input type="text" class="form-control" name="foto" placeholder="Foto">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" id="latitude" name="langitude" value="{{ request('lat') }}" class="form-control" name="" placeholder="titik latitude">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" value="{{ request('long') }}" class="form-control" name="" placeholder="titik longitude">
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

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
  </body>
</html>

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