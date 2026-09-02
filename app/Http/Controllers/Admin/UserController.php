<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Jangan tampilkan user dengan role admin
        $users = \App\Models\User::where('role', '!=', 'admin')
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        return view('admin.user.index', compact('users'));
    }

    // Blokir akses ke fitur create, store, show, edit, update, destroy jika mencoba lewat URL
    public function show(\App\Models\User $user) { abort(403); }
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(\App\Models\User $user) { abort(403); }
    public function update(Request $request, \App\Models\User $user) { abort(403); }
    public function destroy(\App\Models\User $user) { abort(403); }
}
