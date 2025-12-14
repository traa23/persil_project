<?php

namespace App\Http\Controllers;

use App\Models\Persil;
use Illuminate\Http\Request;

class PersilController extends Controller
{
    public function index()
    {
        $persils = Persil::with('pemilik')->latest()->paginate(10);
        return view('guest.persil.index', compact('persils'));
    }

    public function create()
    {
        return view('guest.persil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_persil' => 'required|string|max:50|unique:persil,kode_persil',
            'luas_m2' => 'nullable|numeric|min:0',
            'penggunaan' => 'nullable|string|max:100',
            'alamat_lahan' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
        ]);

        Persil::create($request->all());

        return redirect()->route('guest.persil.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $persil = Persil::with(['pemilik', 'dokumen', 'peta', 'sengketa'])->findOrFail($id);
        return view('guest.persil.show', compact('persil'));
    }

    public function edit(string $id)
    {
        $persil = Persil::findOrFail($id);
        return view('guest.persil.edit', compact('persil'));
    }

    public function update(Request $request, string $id)
    {
        $persil = Persil::findOrFail($id);

        $request->validate([
            'kode_persil' => 'required|string|max:50|unique:persil,kode_persil,' . $id . ',persil_id',
            'luas_m2' => 'nullable|numeric|min:0',
            'penggunaan' => 'nullable|string|max:100',
            'alamat_lahan' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
        ]);

        $persil->update($request->all());

        return redirect()->route('guest.persil.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $persil = Persil::findOrFail($id);
        $persil->delete();

        return redirect()->route('guest.persil.index')->with('success', 'Data berhasil dihapus');
    }
}
