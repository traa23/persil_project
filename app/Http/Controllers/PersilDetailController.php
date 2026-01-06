<?php
namespace App\Http\Controllers;

use App\Models\DokumenPersil;
use App\Models\Persil;
use App\Models\PetaPersil;
use App\Models\SengketaPersil;
use Illuminate\Http\Request;

class PersilDetailController extends Controller
{
    // Dokumen Persil
    public function dokumenAdd($persilId)
    {
        $persil = Persil::findOrFail($persilId);
        return view('admin.persil.dokumen.create', compact('persil'));
    }

    public function dokumenStore(Request $request, $persilId)
    {
        $persil = Persil::findOrFail($persilId);

        $validated = $request->validate([
            'jenis_dokumen'  => 'required',
            'nomor'          => 'nullable',
            'keterangan'     => 'nullable',
            'file_dokumen'   => 'nullable|array',
            'file_dokumen.*' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,gif,doc,docx,xls,xlsx',
        ]);

        // Handle multiple file uploads - create one dokumen record per file
        if ($request->hasFile('file_dokumen')) {
            $files = $request->file('file_dokumen');

            foreach ($files as $index => $file) {
                $filePath = $file->store('dokumen', 'public');

                DokumenPersil::create([
                    'persil_id'     => $persilId,
                    'jenis_dokumen' => $validated['jenis_dokumen'],
                    'nomor'         => $validated['nomor'],
                    'keterangan'    => $validated['keterangan'],
                    'file_dokumen'  => $filePath,
                ]);
            }

            $count = count($files);
            return redirect()->back()->with('success', "{$count} dokumen berhasil ditambahkan");
        }

        // If no file uploaded, still create the record
        DokumenPersil::create([
            'persil_id'     => $persilId,
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'nomor'         => $validated['nomor'],
            'keterangan'    => $validated['keterangan'],
            'file_dokumen'  => null,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function dokumenDelete($dokumenId)
    {
        $dokumen = DokumenPersil::findOrFail($dokumenId);

        if ($dokumen->file_dokumen) {
            \Storage::disk('public')->delete($dokumen->file_dokumen);
        }

        $persilId = $dokumen->persil_id;
        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }

    // Peta Persil
    public function petaAdd($persilId)
    {
        $persil = Persil::findOrFail($persilId);
        $peta   = PetaPersil::where('persil_id', $persilId)->first();

        return view('admin.persil.peta.create', compact('persil', 'peta'));
    }

    public function petaStore(Request $request, $persilId)
    {
        $persil = Persil::findOrFail($persilId);

        $validated = $request->validate([
            'geojson'   => 'nullable',
            'panjang_m' => 'nullable|numeric',
            'lebar_m'   => 'nullable|numeric',
            'file_peta' => 'nullable|file|max:5120',
        ]);

        $validated['persil_id'] = $persilId;

        if ($request->hasFile('file_peta')) {
            $validated['file_peta'] = $request->file('file_peta')->store('peta', 'public');
        }

        $peta = PetaPersil::where('persil_id', $persilId)->first();

        if ($peta) {
            if ($request->hasFile('file_peta') && $peta->file_peta) {
                \Storage::disk('public')->delete($peta->file_peta);
            }
            $peta->update($validated);
        } else {
            PetaPersil::create($validated);
        }

        return redirect()->back()->with('success', 'Peta berhasil disimpan');
    }

    // Sengketa Persil
    public function sengketaAdd($persilId)
    {
        $persil = Persil::findOrFail($persilId);
        return view('admin.persil.sengketa.create', compact('persil'));
    }

    public function sengketaStore(Request $request, $persilId)
    {
        $persil = Persil::findOrFail($persilId);

        $validated = $request->validate([
            'pihak_1'        => 'required',
            'pihak_2'        => 'required',
            'kronologi'      => 'nullable',
            'status'         => 'required|in:baru,proses,selesai',
            'penyelesaian'   => 'nullable',
            'bukti_sengketa' => 'nullable|file|max:5120',
        ]);

        $validated['persil_id'] = $persilId;

        if ($request->hasFile('bukti_sengketa')) {
            $validated['bukti_sengketa'] = $request->file('bukti_sengketa')->store('sengketa', 'public');
        }

        SengketaPersil::create($validated);

        return redirect()->back()->with('success', 'Data sengketa berhasil ditambahkan');
    }

    public function sengketaEdit($sengketaId)
    {
        $sengketa = SengketaPersil::findOrFail($sengketaId);
        $persil   = $sengketa->persil;

        return view('admin.persil.sengketa.edit', compact('sengketa', 'persil'));
    }

    public function sengketaUpdate(Request $request, $sengketaId)
    {
        $sengketa = SengketaPersil::findOrFail($sengketaId);

        $validated = $request->validate([
            'pihak_1'        => 'required',
            'pihak_2'        => 'required',
            'kronologi'      => 'nullable',
            'status'         => 'required|in:baru,proses,selesai',
            'penyelesaian'   => 'nullable',
            'bukti_sengketa' => 'nullable|file|max:5120',
        ]);

        if ($request->hasFile('bukti_sengketa')) {
            if ($sengketa->bukti_sengketa) {
                \Storage::disk('public')->delete($sengketa->bukti_sengketa);
            }
            $validated['bukti_sengketa'] = $request->file('bukti_sengketa')->store('sengketa', 'public');
        }

        $sengketa->update($validated);

        return redirect()->back()->with('success', 'Data sengketa berhasil diperbarui');
    }

    public function sengketaDelete($sengketaId)
    {
        $sengketa = SengketaPersil::findOrFail($sengketaId);

        if ($sengketa->bukti_sengketa) {
            \Storage::disk('public')->delete($sengketa->bukti_sengketa);
        }

        $sengketa->delete();

        return redirect()->back()->with('success', 'Data sengketa berhasil dihapus');
    }

    // =====================
    // DOKUMEN EDIT/UPDATE
    // =====================
    public function dokumenEdit($dokumenId)
    {
        $dokumen = DokumenPersil::findOrFail($dokumenId);
        $persil  = $dokumen->persil;

        return view('admin.persil.dokumen.edit', compact('dokumen', 'persil'));
    }

    public function dokumenUpdate(Request $request, $dokumenId)
    {
        $dokumen = DokumenPersil::findOrFail($dokumenId);

        $validated = $request->validate([
            'jenis_dokumen' => 'required',
            'nomor'         => 'nullable',
            'keterangan'    => 'nullable',
            'file_dokumen'  => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,gif,doc,docx,xls,xlsx',
        ]);

        if ($request->hasFile('file_dokumen')) {
            // Delete old file if exists
            if ($dokumen->file_dokumen) {
                \Storage::disk('public')->delete($dokumen->file_dokumen);
            }
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('dokumen', 'public');
        }

        $dokumen->update($validated);

        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui');
    }

    // =====================
    // PETA EDIT/DELETE
    // =====================
    public function petaEdit($petaId)
    {
        $peta   = PetaPersil::findOrFail($petaId);
        $persil = $peta->persil;

        return view('admin.persil.peta.edit', compact('peta', 'persil'));
    }

    public function petaUpdate(Request $request, $petaId)
    {
        $peta = PetaPersil::findOrFail($petaId);

        $validated = $request->validate([
            'geojson'   => 'nullable',
            'panjang_m' => 'nullable|numeric',
            'lebar_m'   => 'nullable|numeric',
            'file_peta' => 'nullable|file|max:5120',
        ]);

        if ($request->hasFile('file_peta')) {
            if ($peta->file_peta) {
                \Storage::disk('public')->delete($peta->file_peta);
            }
            $validated['file_peta'] = $request->file('file_peta')->store('peta', 'public');
        }

        $peta->update($validated);

        return redirect()->back()->with('success', 'Peta berhasil diperbarui');
    }

    public function petaDelete($petaId)
    {
        $peta = PetaPersil::findOrFail($petaId);

        if ($peta->file_peta) {
            \Storage::disk('public')->delete($peta->file_peta);
        }

        $peta->delete();

        return redirect()->back()->with('success', 'Peta berhasil dihapus');
    }
}
