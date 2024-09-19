@extends('layouts.app')

@section('content')
    <h1>Edit Playlist: {{ $playlist->name }}</h1>

    <!-- Tambah Lagu -->
    <h2>Tambah Lagu</h2>
    <form action="{{ route('playlists.addSong', $playlist->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="new_song" accept=".mp3" required>
        <button type="submit">Tambah Lagu</button>
    </form>

    <!-- Daftar Lagu dalam Playlist -->
    <h2>Daftar Lagu</h2>
    @if (empty($songs))
        <p>Tidak ada lagu di folder ini.</p>
    @else
        <ul>
            @foreach($songs as $song)
                <li>
                    {{ $song->getFilename() }}
                    <!-- Form untuk menghapus lagu -->
                    <form action="{{ route('playlists.deleteSong', $playlist->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="song_name" value="{{ $song->getFilename() }}">
                        <button type="submit">Hapus</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
