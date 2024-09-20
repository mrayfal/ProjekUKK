@extends('layouts.app')

@section('content')
    <h1 class="my-4">Daftar Playlist</h1>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach($playlists as $playlist)
            <div class="col">
                <div class="card shadow-sm h-100">
                    <!-- Jadikan seluruh card dapat diklik -->
                    <a href="{{ route('playlists.show', $playlist->id) }}" class="text-decoration-none text-dark">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>{{ $playlist->name }}</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">{{ $playlist->name }}</text></svg>

                        <div class="card-body">
                            <h5 class="card-title">{{ $playlist->name }}</h5>
                            <p class="card-text">Folder: {{ $playlist->songs_folder }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
