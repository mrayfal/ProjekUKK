@extends('layouts.app')

@section('content')
    <h1>Dashboard Admin</h1>
    <a href="{{ route('playlists.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Playlist</a>
    <!-- Tampilkan daftar playlist dan opsi CRUD -->
@endsection
