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
    public function adminDashboard()
{
    // Menampilkan dashboard admin
    return view('admin.dashboard'); // Buat file Blade admin.dashboard
}

public function userPlaylists()
{
    // Menampilkan playlist yang bisa dilihat oleh user
    $playlists = Playlist::all(); // Sesuaikan dengan akses playlist yang dimiliki user
    return view('user.playlists', compact('playlists')); // Buat file Blade user.playlists
}

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'songs' => 'required',
            'songs.*' => 'mimes:mp3|max:10240', // Setiap file harus mp3 dan max 10MB
        ]);
    
        // Simpan playlist di database
        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->songs_folder = 'playlists/' . $playlist->name; // Misalnya disimpan di folder 'playlists/Nama Playlist'
        $playlist->save();
    
        // Simpan file lagu ke folder yang sesuai
        foreach ($request->file('songs') as $song) {
            $song->storeAs($playlist->songs_folder, $song->getClientOriginalName(), 'public');
        }
    
        return redirect()->route('playlists.index')->with('success', 'Playlist berhasil dibuat.');
    }   

    public function show(Playlist $playlist)
    {
        // Dapatkan daftar file dari folder yang bersangkutan
        $songs = Storage::disk('public')->files($playlist->songs_folder);

        return view('playlists.show', compact('playlist', 'songs'));
    
    }
    

    public function edit($id)
    {
        $playlist = Playlist::findOrFail($id);

        // Cek folder path di storage/public atau storage/app/public tergantung penyimpanan
        $folderPath = storage_path('app/public/' . $playlist->songs_folder); 
    
        if (File::exists($folderPath)) {
            $mp3Files = File::files($folderPath);
    
            // Filter hanya file mp3
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
    // Validasi input lagu harus dalam format MP3
    $request->validate([
        'new_song' => 'required|file|mimes:mp3',
    ]);

    // Ambil playlist berdasarkan ID
    $playlist = Playlist::findOrFail($id);

    // Tentukan folder path tempat file lagu akan disimpan
    $folderPath = storage_path('app/public/' . $playlist->songs_folder);

    // Cek apakah folder path ada, jika tidak buat folder tersebut
    if (!File::exists($folderPath)) {
        File::makeDirectory($folderPath, 0755, true);
    }

    // Ambil file lagu yang diupload
    $newSong = $request->file('new_song');

    // Pindahkan file ke folder yang sesuai
    $newSong->move($folderPath, $newSong->getClientOriginalName());

    return redirect()->route('playlists.edit', $playlist->id)->with('success', 'Lagu berhasil ditambahkan.');
}
public function deleteSong(Request $request, $id)
{
    // Validasi bahwa nama file lagu diinputkan
    $request->validate([
        'song_name' => 'required',
    ]);

    // Ambil playlist berdasarkan ID
    $playlist = Playlist::findOrFail($id);

    // Tentukan file path dari lagu yang akan dihapus
    $filePath = storage_path('app/public/' . $playlist->songs_folder . '/' . $request->song_name);

    // Cek apakah file ada di folder
    if (File::exists($filePath)) {
        // Hapus file dari folder
        File::delete($filePath);

        return redirect()->route('playlists.edit', $playlist->id)->with('success', 'Lagu berhasil dihapus.');
    }

    // Jika file tidak ditemukan, berikan pesan error
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
    // Ambil playlist berdasarkan ID
    $playlist = Playlist::findOrFail($id);

    // Tentukan folder path dari playlist yang akan dihapus
    $folderPath = storage_path('app/public/' . $playlist->songs_folder);

    // Cek apakah folder playlist ada
    if (File::exists($folderPath)) {
        // Hapus semua isi folder terlebih dahulu, kemudian hapus folder itu sendiri
        File::deleteDirectory($folderPath);
    }

    // Hapus playlist dari database
    $playlist->delete();

    // Redirect ke halaman daftar playlist dengan pesan sukses
    return redirect()->route('playlists.index')->with('success', 'Playlist dan folder terkait berhasil dihapus.');
}
    }

