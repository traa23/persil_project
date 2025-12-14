<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SengketaPersilController extends Controller
{
    public function index()
    {
        return view('guest.sengketa_persil.index');
    }

    public function create()
    {
        return view('guest.sengketa_persil.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('guest.sengketa-persil.index');
    }

    public function show(string $id)
    {
        return view('guest.sengketa_persil.show');
    }

    public function edit(string $id)
    {
        return view('guest.sengketa_persil.edit');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('guest.sengketa-persil.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('guest.sengketa-persil.index');
    }
}
