@extends('wisata.main')

@section('title', 'List Wisata')

@section('styles')

    <style>
        body {
            margin-top: 80px;
        }
        #map { height: 600px; }
    </style>

@endsection

@section('content')
    {{-- content --}}

   <div class="container">
   <div class="row">
        <div class="col-md-10 offset-md-1 d-flex justify-content-between">
            <h2>List Wisata Riau</h2>
            <a href="/wisata/create" class="btn btn-primary">Tambah Wisata</a>
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
        <div class="col-md-10 offset-md-1">
            <div class="card mb-5">
                <div class="card-header">
                        Maps
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama Wisata</th>
                            <th>Alamat</th>
                            <th>Kabupaten</th>
                            <th>Jenis</th>
                            <th>#</th>
                        </tr>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item['nama_wisata'] }}</td>
                            <td>{{ $item['alamat'] }}</td>
                            <td>{{ $item['kabupaten'] }}</td>
                            <td>{{ $item['jenis_wisata'] }}</td>
                            <td>
                                <a href="/wisata/detail/{{ $item['id'] }}">Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>        
</div>

@endsection