<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterField;
use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaFieldController extends Controller
{
    public function index(Lomba $lomba)
{
    $masterFields = MasterField::where('aktif', true)
        ->orderBy('kategori')
        ->orderBy('label')
        ->get();

    return view('admin.lomba.field', compact(
        'lomba',
        'masterFields'
    ));
}
}
