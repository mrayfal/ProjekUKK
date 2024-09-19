<?php
namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'folder_path' => 'required|string',
        ]);
    
        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->songs_folder = $request->folder_path;
        $playlist->save();
    
        return redirect()->route('playlists.create')->with('success', 'Playlist berhasil dibuat.');
    }

    public function show(Playlist $playlist)
    {
        // Ambil daftar lagu dari folder playlist (misalnya menggunakan Storage atau fungsi filesystem)
        $songs = Storage::files($playlist->songs_folder);
    
        return view('playlists.show', compact('playlist', 'songs'));
    }
    

    public function edit($id)
    {
        $playlist = Playlist::findOrFail($id);

    // Ambil semua file MP3 dari folder
    $folderPath = public_path($playlist->songs_folder);
    if (File::exists($folderPath)) {
        $mp3Files = File::files($folderPath);
        $songs = array_filter($mp3Files, function ($file) {
            return strtolower($file->getExtension()) === 'mp3';
        });
    } else {
        $songs = [];
    }

    return view('playlists.edit', compact('playlist', 'songs'));
}
    public function addSong(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);

        $request->validate([
            'new_song' => 'required|file|mimes:mp3',
        ]);

        // Simpan file ke folder yang sesuai
        $folderPath = public_path($playlist->songs_folder);
        $newSong = $request->file('new_song');
        $newSong->move($folderPath, $newSong->getClientOriginalName());

        return redirect()->route('playlists.edit', $playlist->id)->with('success', 'Lagu berhasil ditambahkan.');
    }

    public function deleteSong(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);

        $request->validate([
            'song_name' => 'required',
        ]);

        // Hapus file dari folder
        $filePath = public_path($playlist->songs_folder . '/' . $request->song_name);
        if (File::exists($filePath)) {
            File::delete($filePath);
            return redirect()->route('playlists.edit', $playlist->id)->with('success', 'Lagu berhasil dihapus.');
        }

        return redirect()->route('playlists.edit', $playlist->id)->with('error', 'Lagu tidak ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'songs_folder' => 'required',
        ]);

        $playlist = Playlist::findOrFail($id);
        $playlist->name = $request->name;
        $playlist->songs_folder = $request->songs_folder;
        $playlist->save();

        return redirect()->route('playlists.index');
    }

    public function destroy($id)
    {
        $playlist = Playlist::findOrFail($id);

        // Hapus semua lagu di folder
        $folderPath = public_path($playlist->songs_folder);
        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        // Hapus playlist dari database
        $playlist->delete();

        return redirect()->route('playlists.index')->with('success', 'Playlist berhasil dihapus.');
    }
}
