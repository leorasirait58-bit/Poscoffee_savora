<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Meja;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {

    $kategoris =kategori::all();

    $menus = Menu::all();
    $mejas = Meja::all();
    return view('welcome', compact('kategoris','menus','mejas'));
    }

    public function updateStatus($id)
    {
        $meja = Meja::find($id);
        $meja->status = 'penuh';
        $meja->save();

        return response()->json(['success' => true]);
    }
}
