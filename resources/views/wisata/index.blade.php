@extends('wisata.main')

@section('styles')

    <style>
        body {
            margin-top: 80px;
        }
        #map { height: 600px; }

        .info {
            padding: 10px 30px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
        }
        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }
        .legend {
            line-height: 18px;
            color: #555;
        }
    </style>

@endsection

@section('title', 'Peta Wisata')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mb-5">
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
@endsection

@push('scripts')

    <script>
    let accessToken = 'pk.eyJ1Ijoicml3YWxzeWFtIiwiYSI6ImNrajB5c21obTF1ZmQycnAyOTY3N2VycXUifQ.DAfn6MTxzf_BU3lqD0fIgQ'

    var mymap = null;

    let tileLayer = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: accessToken
    });

    let tileLayer2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: accessToken
    });

    let geoLayer = L.geoJson(@json($all), {
        onEachFeature: function (feature, layer) {
            const data = feature.properties;

            layer.bindPopup(`<b>${data['nama_wisata']}</b><br>(${data['jenis_wisata']})<br><img src="${data['foto']}" width="250">`);

            //icon
            if (data['jenis_wisata'] === 'Alam') {
                    const icon = L.icon({
                        iconUrl: '{{ asset('assets/icon/leaf.png') }}',
                        iconSize: [40, 40],
                        popupAnchor: [0, -10]
                    });

                    layer.setIcon(icon);
                }
                else if (data['jenis_wisata'] === 'Agama') {
                    const icon = L.icon({
                        iconUrl:  '{{ asset('assets/icon/islam.png') }}',
                        iconSize: [40, 40],
                        popupAnchor: [0, -10]
                    });


                    layer.setIcon(icon);
                }
                else {
                    const icon = L.icon({
                        iconUrl:  '{{ asset('assets/icon/unity.png') }}',
                        iconSize: [40, 40],
                        popupAnchor: [0, -10]
                    });

                    layer.setIcon(icon);
                }
        }
    });

    let alamLayer = L.geoJson(@json($alam), {
        onEachFeature: function (feature, layer) {
            const data = feature.properties;

            layer.bindPopup(`<b>${data['nama_wisata']}</b><br>(${data['jenis_wisata']})<br><img src="${data['foto']}" width="250">`);

            const icon = L.icon({
                iconUrl:  '{{ asset('assets/icon/leaf.png') }}',
                iconSize: [40, 40],
                popupAnchor: [0, -10]
            });
            
            layer.setIcon(icon);

        }
    })

    let agamaLayer = L.geoJson(@json($agama), {
        onEachFeature: function (feature, layer) {
            const data = feature.properties;

            layer.bindPopup(`<b>${data['nama_wisata']}</b><br>(${data['jenis_wisata']})<br><img src="${data['foto']}" width="250">`);

            const icon = L.icon({
                iconUrl:  '{{ asset('assets/icon/islam.png') }}',
                iconSize: [40, 40],
                popupAnchor: [0, -10]
            });
            
            layer.setIcon(icon);

        }
    })

    let budayaLayer = L.geoJson(@json($budaya), {
        onEachFeature: function (feature, layer) {
            const data = feature.properties;

            layer.bindPopup(`<b>${data['nama_wisata']}</b><br>(${data['jenis_wisata']})<br><img src="${data['foto']}" width="250">`);

            const icon = L.icon({
                iconUrl:  '{{ asset('assets/icon/unity.png') }}',
                iconSize: [40, 40],
                popupAnchor: [0, -10]
            });
            
            layer.setIcon(icon);

        }
    })

    console.log(geoLayer);

    var littleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.');

    var cities = L.layerGroup([littleton, geoLayer]);

    mymap = L.map('map', {
        layers: [
            tileLayer,
            geoLayer
        ]
    }).setView([0.9, 101.5], 8);

    var overlayMaps = {
        "Semua": geoLayer,
        "Alam": alamLayer,
        "Agama": agamaLayer,
        "Budaya": budayaLayer
    };

    L.control.layers(overlayMaps).addTo(mymap);
    
    let mark = L.marker([0, 0]).addTo(mymap);

    mymap.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);

        var popupContent = "Lokasi : " + latitude + ", " + longitude + ".";
        popupContent += '<br><a href="/wisata/create?lat=' + latitude + '&long=' + longitude +'">tambah wisata</a>'

        updateMarker(latitude, longitude, popupContent);
    });

    function updateMarker(lat, lng, popup) {
        mark
        .setLatLng([lat, lng])
        .bindPopup(popup)
        .openPopup();
        return false;
    };
    
    var info = L.control({position: 'bottomleft'});

    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        this.update();
        return this._div;
    };

    // method that we will use to update the control based on feature properties passed
    info.update = function (props) {
        this._div.innerHTML = '<h4>Peta Wisata Riau</h4>';
    };

    info.addTo(mymap);

    var legend = L.control({position: 'bottomright'});

    legend.onAdd = function (map) {

        var div = L.DomUtil.create('div', 'info legend');

        div.innerHTML = 
            '<table cellpadding="5">' +
                '<tr>' +
                    '<td colspan="2">' +
                        'Kategori Wisata' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>' +
                        '<img src="{{ asset('assets/icon/unity.png') }}" width="35">' + 
                    '</td>' +
                    '<td>' +
                        'Budaya' + 
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>' +
                        '<img src="{{ asset('assets/icon/islam.png') }}" width="35">' + 
                    '</td>' +
                    '<td>' +
                        'Agama' + 
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>' +
                        '<img src="{{ asset('assets/icon/leaf.png') }}" width="35">' + 
                    '</td>' +
                    '<td>' +
                        'Alam' + 
                    '</td>' +
                '</tr>' +
            '</table>'

        return div;
    };

    legend.addTo(mymap);

</script>

@endpush
