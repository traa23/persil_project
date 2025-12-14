<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JenisPenggunaanController extends Controller
{
    public function index()
    {
        return view('guest.jenis_penggunaan.index');
    }

    public function create()
    {
        return view('guest.jenis_penggunaan.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('guest.jenis-penggunaan.index');
    }

    public function show(string $id)
    {
        return view('guest.jenis_penggunaan.show');
    }

    public function edit(string $id)
    {
        return view('guest.jenis_penggunaan.edit');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('guest.jenis-penggunaan.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('guest.jenis-penggunaan.index');
    }
}
