@extends('layouts.app')

@section('content')
    <h1>Buat Playlist Baru</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Nama Playlist:</label>
        <input type="text" name="name" id="name" required>

        <label for="songs_folder">Pilih Folder Lagu:</label>
        <!-- Ubah input menjadi file input yang bisa memilih folder -->
        <input type="file" id="songs_folder" webkitdirectory multiple>

        <!-- Hidden input untuk menyimpan nama folder yang dipilih -->
        <input type="hidden" name="folder_path" id="folder_path" required>

        <button type="submit">Simpan</button>
    </form>

    @if (session('success'))
        <!-- Tombol Kembali -->
        <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Kembali ke Daftar Playlist</a>
    @endif

    <script>
        document.getElementById('songs_folder').addEventListener('change', function(event) {
            const files = event.target.files;
            if (files.length > 0) {
                // Dapatkan folder path dari file pertama yang dipilih
                const folderPath = files[0].webkitRelativePath.split('/')[0];
                document.getElementById('folder_path').value = folderPath;
            }
        });
    </script>
@endsection
