<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Painting;
use Illuminate\Http\Request;

class PaintingsController extends Controller
{
    public function index()
    {
        $maxPrice = 20000.00;
        $perPage = 6;
        $paintings = Painting::maxPrice($maxPrice)
            ->orderBy('artist')
            ->orderBy('title')
            ->paginate($perPage);
        $genres = Genre::orderBy('name')->with('paintings')->has('paintings')->get();
        return view('admin.paintings.index', compact('paintings','genres'));
    }
}
