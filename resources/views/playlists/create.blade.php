@extends('layouts.app')

@section('content')
    <h1>Buat Playlist Baru</h1>

    <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Nama Playlist:</label>
        <input type="text" name="name" id="name" required>

        <label for="songs">Pilih Lagu:</label>
        <input type="file" name="songs[]" id="songs" multiple accept=".mp3">

        <button type="submit">Simpan</button>
    </form>
@endsection
