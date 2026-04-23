<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parrainage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParrainageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $statistiques = $user->statistiques_parrainage;
        $filleuls = $user->filleuls()->with('parrainage')->get();
        
        return view('parrainage.index', compact('statistiques', 'filleuls', 'user'));
    }
}