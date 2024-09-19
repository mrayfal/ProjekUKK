@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Dashboard</h1>

    <!-- Tombol untuk kembali ke halaman playlist -->
    <a href="{{ route('playlists.index') }}" class="btn btn-primary">Kembali ke Playlist</a>

    <!-- Konten dashboard lainnya di sini -->
    <!-- Misalnya: -->
    <p>Selamat datang di dashboard!</p>
</div>
@endsection
