<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Post;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'totalBerita' => Post::published()->count(),
            'totalPrestasi' => Achievement::count(),
        ]);
    }
}
