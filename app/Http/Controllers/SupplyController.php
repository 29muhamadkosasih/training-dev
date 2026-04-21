<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Document;
use App\Models\Supply;
use App\Models\SupplyDetail;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);

        // Get all supply items with details
        $supply = Supply::with([
            'details' => function ($query) {
                $query->orderBy('number', 'asc');
            },
        ])
            ->where('document_id', $document_id)
            ->get();
            
        return view('supply.index', compact('document_id', 'competences', 'supply', 'dataDocument'));
    }

    public function create($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        return view('supply.create', compact('document_id', 'dataDocument', 'competences'));
    }

    public function store(Request $request, $document_id)
    {
        // Validasi input
        $validated = $request->validate(
            [
                'perkiraan_waktu_pelatihan' => 'required|string',
                'jumlah_peserta' => 'required|string',
                'metode_pelatihan' => 'required|string',
                'items' => 'required|array|min:1',
                'items.*.nama_peralatan' => 'required|string',
                'items.*.spesifikasi' => 'required|string',
                'items.*.satuan' => 'required|string',
                'items.*.jumlah' => 'required|numeric|min:1',
            ],
            [
                'items.required' => 'Minimal harus ada satu item bahan/barang',
                'items.*.nama_peralatan.required' => 'Nama bahan/barang wajib diisi',
                'items.*.spesifikasi.required' => 'Spesifikasi wajib diisi',
                'items.*.satuan.required' => 'Satuan wajib diisi',
                'items.*.jumlah.required' => 'Jumlah wajib diisi',
            ],
        );

        try {
            // Simpan supply utama
            $supply = Supply::create([
                'document_id' => $document_id,
                'perkiraan_waktu_pelatihan' => $request->perkiraan_waktu_pelatihan,
                'jumlah_peserta' => $request->jumlah_peserta,
                'metode_pelatihan' => $request->metode_pelatihan,
            ]);

            // Simpan setiap item bahan/barang
            foreach ($validated['items'] as $index => $item) {
                SupplyDetail::create([
                    'supply_id' => $supply->id,
                    'nama_peralatan' => $item['nama_peralatan'],
                    'spesifikasi' => $item['spesifikasi'],
                    'satuan' => $item['satuan'],
                    'jumlah' => $item['jumlah'],
                    'number' => $index + 1,
                ]);
            }

            return redirect()->route('supplys.index', $document_id)->with('success', 'Bahan/barang berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan bahan/barang: ' . $e->getMessage());
        }
    }

    public function edit($document_id, $id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $supply = Supply::findOrFail($id);
        $supplyDetails = SupplyDetail::where('supply_id', $id)->orderBy('number', 'asc')->get();

        return view('supply.edit', compact('document_id', 'dataDocument', 'supply', 'supplyDetails'));
    }

    public function update(Request $request, $document_id, $id)
    {
        // Validasi input
        $validated = $request->validate(
            [
                'perkiraan_waktu_pelatihan' => 'required|string',
                'jumlah_peserta' => 'required|string',
                'metode_pelatihan' => 'required|string',
                'items' => 'required|array|min:1',
                'items.*.nama_peralatan' => 'required|string',
                'items.*.spesifikasi' => 'required|string',
                'items.*.satuan' => 'required|string',
                'items.*.jumlah' => 'required|numeric|min:1',
            ],
            [
                'items.required' => 'Minimal harus ada satu item bahan/barang',
                'items.*.nama_peralatan.required' => 'Nama bahan/barang wajib diisi',
                'items.*.spesifikasi.required' => 'Spesifikasi wajib diisi',
                'items.*.satuan.required' => 'Satuan wajib diisi',
                'items.*.jumlah.required' => 'Jumlah wajib diisi',
            ],
        );

        try {
            $supply = Supply::findOrFail($id);

            // Update supply utama
            $supply->update([
                'perkiraan_waktu_pelatihan' => $request->perkiraan_waktu_pelatihan,
                'jumlah_peserta' => $request->jumlah_peserta,
                'metode_pelatihan' => $request->metode_pelatihan,
            ]);

            // Hapus detail lama
            SupplyDetail::where('supply_id', $id)->delete();

            // Simpan detail baru
            foreach ($validated['items'] as $index => $item) {
                SupplyDetail::create([
                    'supply_id' => $supply->id,
                    'nama_peralatan' => $item['nama_peralatan'],
                    'spesifikasi' => $item['spesifikasi'],
                    'satuan' => $item['satuan'],
                    'jumlah' => $item['jumlah'],
                    'number' => $index + 1,
                ]);
            }

            return redirect()->route('supplys.index', $document_id)->with('success', 'Bahan/barang berhasil diubah');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengubah bahan/barang: ' . $e->getMessage());
        }
    }

    public function destroy($document_id, $id)
    {
        try {
            $supply = Supply::findOrFail($id);

            // Delete all related details
            SupplyDetail::where('supply_id', $id)->delete();

            // Delete supply
            $supply->delete();

            return redirect()->route('supplys.index', $document_id)->with('success', 'Bahan/barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus bahan/barang: ' . $e->getMessage());
        }
    }

    public function destroyDetail($document_id, $supply_id, $detail_id)
    {
        try {
            $detail = SupplyDetail::findOrFail($detail_id);
            $detail->delete();

            return redirect()->route('supplys.index', $document_id)->with('success', 'Detail bahan/barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus detail bahan/barang: ' . $e->getMessage());
        }
    }

    public function destroyAll($document_id)
    {
        try {
            // Get all supply for this document
            $supplies = Supply::where('document_id', $document_id)->get();

            foreach ($supplies as $supply) {
                // Delete all related details
                SupplyDetail::where('supply_id', $supply->id)->delete();
                // Delete supply
                $supply->delete();
            }

            return redirect()->route('supplys.index', $document_id)->with('success', 'Semua bahan/barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus bahan/barang: ' . $e->getMessage());
        }
    }
}
