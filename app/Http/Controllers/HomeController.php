<?php

namespace App\Http\Controllers;

use App\Models\News; // <-- Jangan lupa import model News
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     */
    public function index()
    {
        // Ambil 3 berita terbaru yang is_visible = true
        $latestNews = News::where('is_visible', true)
                           ->latest('published_at') // Urutkan dari yang terbaru
                           ->take(3) // Ambil hanya 3
                           ->get();

        // Kirim data berita ke view 'pages.home'
        return view('pages.home', [
            'latestNews' => $latestNews
        ]);
    }
}
