@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit Playlist: <strong>{{ $playlist->name }}</strong></h1>

        <div class="card mb-4">
            <div class="card-header">
                <h2>Tambah Lagu ke Playlist</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('playlists.addSong', $playlist->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="new_song" class="form-label">Pilih Lagu (MP3):</label>
                        <input type="file" class="form-control" id="new_song" name="new_song" accept=".mp3" required>
                    </div>
                    <button type="submit" class="btn btn-success">Tambah Lagu</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Daftar Lagu</h2>
            </div>
            <div class="card-body">
                @if(!empty($songs))
                    <ul class="list-group">
                        @foreach($songs as $song)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $song->getFilename() }}</span>
                                <form action="{{ route('playlists.deleteSong', $playlist->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus lagu ini?');">
                                    @csrf
                                    <input type="hidden" name="song_name" value="{{ $song->getFilename() }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Tidak ada lagu dalam playlist ini.</p>
                @endif
            </div>
        </div>

        <a href="{{ route('playlists.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Playlist</a>
    </div>
@endsection
