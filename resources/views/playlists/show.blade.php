@extends('layouts.app')

@section('content')
    <h1 class="my-4">Isi Playlist: {{ $playlist->name }}</h1>

    <a href="{{ route('playlists.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Playlist</a>

    <ul class="list-group">
        @foreach($songs as $song)
            <li class="list-group-item">{{ basename($song) }}</li>
        @endforeach
    </ul>
@endsection
