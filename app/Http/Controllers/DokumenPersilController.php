<?php

namespace App\Http\Controllers;

use App\Models\DokumenPersil;
use App\Models\Persil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokumenPersilController extends Controller
{
    public function index()
    {
        $dokumens = DokumenPersil::with('persil')->latest()->get();
        return view('guest.dokumen_persil.index', compact('dokumens'));
    }

    public function create()
    {
        $persils = Persil::orderBy('kode_persil')->get();
        return view('guest.dokumen_persil.create', compact('persils'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'persil_id' => 'required|exists:persil,persil_id',
                'jenis_dokumen' => 'required|string|max:100',
                'nomor' => 'nullable|string|max:100',
                'keterangan' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ], [
                'persil_id.required' => 'Persil wajib dipilih',
                'persil_id.exists' => 'Persil tidak valid',
                'jenis_dokumen.required' => 'Jenis dokumen wajib diisi',
                'file.mimes' => 'Format file harus: PDF, DOC, DOCX, JPG, JPEG, PNG',
                'file.max' => 'Ukuran file maksimal 5MB',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
                'persil_id' => $request->persil_id,
                'jenis_dokumen' => $request->jenis_dokumen,
                'nomor' => $request->nomor,
                'keterangan' => $request->keterangan,
            ];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filePath = $file->store('dokumen_persil', 'public');
                $data['file_path'] = $filePath;
            }

            DokumenPersil::create($data);

            return redirect()
                ->route('guest.persil.show', $request->persil_id)
                ->with('success', 'Dokumen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeMultiple(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'persil_id' => 'required|exists:persil,persil_id',
                'files' => 'required|array',
                'files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
                'jenis_dokumen' => 'required|array',
                'jenis_dokumen.*' => 'required|string|max:100',
            ], [
                'persil_id.required' => 'Persil wajib dipilih',
                'files.required' => 'File wajib dipilih',
                'files.*.mimes' => 'Format file harus: PDF, DOC, DOCX, JPG, JPEG, PNG',
                'files.*.max' => 'Ukuran file maksimal 5MB',
                'jenis_dokumen.required' => 'Jenis dokumen wajib diisi untuk setiap file',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $uploadedCount = 0;

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $index => $file) {
                    $filePath = $file->store('dokumen_persil', 'public');

                    DokumenPersil::create([
                        'persil_id' => $request->persil_id,
                        'jenis_dokumen' => $request->jenis_dokumen[$index] ?? 'Dokumen',
                        'nomor' => $request->nomor[$index] ?? null,
                        'keterangan' => $request->keterangan[$index] ?? null,
                        'file_path' => $filePath,
                    ]);

                    $uploadedCount++;
                }
            }

            return redirect()
                ->route('guest.persil.show', $request->persil_id)
                ->with('success', "{$uploadedCount} dokumen berhasil diupload!");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $dokumen = DokumenPersil::with('persil')->findOrFail($id);
        return view('guest.dokumen_persil.show', compact('dokumen'));
    }

    public function edit(string $id)
    {
        $dokumen = DokumenPersil::findOrFail($id);
        $persils = Persil::orderBy('kode_persil')->get();
        return view('guest.dokumen_persil.edit', compact('dokumen', 'persils'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $dokumen = DokumenPersil::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'persil_id' => 'required|exists:persil,persil_id',
                'jenis_dokumen' => 'required|string|max:100',
                'nomor' => 'nullable|string|max:100',
                'keterangan' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = [
                'persil_id' => $request->persil_id,
                'jenis_dokumen' => $request->jenis_dokumen,
                'nomor' => $request->nomor,
                'keterangan' => $request->keterangan,
            ];

            if ($request->hasFile('file')) {
                if ($dokumen->file_path) {
                    Storage::disk('public')->delete($dokumen->file_path);
                }

                $file = $request->file('file');
                $filePath = $file->store('dokumen_persil', 'public');
                $data['file_path'] = $filePath;
            }

            $dokumen->update($data);

            return redirect()
                ->route('guest.persil.show', $dokumen->persil_id)
                ->with('success', 'Dokumen berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $dokumen = DokumenPersil::findOrFail($id);
            $persilId = $dokumen->persil_id;

            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            $dokumen->delete();

            return redirect()
                ->route('guest.persil.show', $persilId)
                ->with('success', 'Dokumen berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage());
        }
    }
}
