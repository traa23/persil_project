<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaPersilController extends Controller
{
    public function index()
    {
        return view('guest.peta_persil.index');
    }

    public function create()
    {
        return view('guest.peta_persil.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('guest.peta-persil.index');
    }

    public function show(string $id)
    {
        return view('guest.peta_persil.show');
    }

    public function edit(string $id)
    {
        return view('guest.peta_persil.edit');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('guest.peta-persil.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('guest.peta-persil.index');
    }
}
