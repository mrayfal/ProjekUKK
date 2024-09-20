@extends('layouts.app')

@section('content')
    <h1 class="my-4">Isi Playlist: {{ $playlist->name }}</h1>

    <a href="{{ route('playlists.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Playlist</a>

    <ul class="list-group">
        @foreach($songs as $song)
            <li class="list-group-item">
                <p><b>{{ basename($song) }}</b></p>
                <audio controls>
                    <source src="{{ Storage::url($song) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </li>
        @endforeach
    </ul>
@endsection
