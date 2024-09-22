@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Buat Playlist Baru</h1>

        <div class="card">
            <div class="card-header">
                <h2>Formulir Playlist</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Playlist:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="songs" class="form-label">Upload Lagu (MP3, max 10MB):</label>
                        <input type="file" name="songs[]" id="songs" class="form-control" multiple accept=".mp3" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat Playlist</button>
                </form>
            </div>
        </div>

        <a href="{{ route('playlists.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Playlist</a>
    </div>
@endsection
