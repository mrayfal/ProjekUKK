@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Isi Playlist: {{ $playlist->name }}</h1>

        <a href="{{ route('playlists.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Playlist</a>

        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Daftar Lagu</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($songs as $song)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>{{ basename($song) }}</strong></p>
                                <audio controls class="w-100 mt-1">
                                    <source src="{{ Storage::url($song) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if(empty($songs))
                    <p class="text-center mt-3">Tidak ada lagu dalam playlist ini.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
