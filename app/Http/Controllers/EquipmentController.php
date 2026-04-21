<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Document;
use App\Models\Equipment;
use App\Models\EquipmentDetail;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);

        // Get all curriculum items grouped by kelompok
        $equipment = Equipment::with('document')->where('document_id', $document_id)->orderBy('created_at', 'asc')->get();

        return view('equipment.index', compact('document_id', 'competences', 'equipment'));
    }

    public function create($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $equipment = Equipment::with('document')->where('document_id', $document_id)->first();
        return view('equipment.create', compact('document_id', 'dataDocument', 'competences', 'equipment'));
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
                'items.required' => 'Minimal harus ada satu item peralatan',
                'items.*.nama_peralatan.required' => 'Nama peralatan wajib diisi',
                'items.*.spesifikasi.required' => 'Spesifikasi wajib diisi',
                'items.*.satuan.required' => 'Satuan wajib diisi',
                'items.*.jumlah.required' => 'Jumlah wajib diisi',
            ],
        );

        try {
            // Simpan equipment utama
            $equipment = Equipment::create([
                'document_id' => $document_id,
                'perkiraan_waktu_pelatihan' => $request->perkiraan_waktu_pelatihan,
                'jumlah_peserta' => $request->jumlah_peserta,
                'metode_pelatihan' => $request->metode_pelatihan,
            ]);

            // Simpan setiap item peralatan
            foreach ($validated['items'] as $index => $item) {
                EquipmentDetail::create([
                    'equipment_id' => $equipment->id,
                    'nama_peralatan' => $item['nama_peralatan'],
                    'spesifikasi' => $item['spesifikasi'],
                    'satuan' => $item['satuan'],
                    'jumlah' => $item['jumlah'],
                    'number' => $index + 1,
                ]);
            }

            return redirect()->route('equipments.index', $document_id)->with('success', 'Peralatan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan peralatan: ' . $e->getMessage());
        }
    }

    public function edit($document_id, $id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $equipment = Equipment::findOrFail($id);
        $equipmentDetails = EquipmentDetail::where('equipment_id', $id)->orderBy('number', 'asc')->get();

        return view('equipment.edit', compact('document_id', 'dataDocument', 'equipment', 'equipmentDetails'));
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
                'items.required' => 'Minimal harus ada satu item peralatan',
                'items.*.nama_peralatan.required' => 'Nama peralatan wajib diisi',
                'items.*.spesifikasi.required' => 'Spesifikasi wajib diisi',
                'items.*.satuan.required' => 'Satuan wajib diisi',
                'items.*.jumlah.required' => 'Jumlah wajib diisi',
            ],
        );

        try {
            $equipment = Equipment::findOrFail($id);

            // Update equipment utama
            $equipment->update([
                'perkiraan_waktu_pelatihan' => $request->perkiraan_waktu_pelatihan,
                'jumlah_peserta' => $request->jumlah_peserta,
                'metode_pelatihan' => $request->metode_pelatihan,
            ]);

            // Hapus detail lama
            EquipmentDetail::where('equipment_id', $id)->delete();

            // Simpan detail baru
            foreach ($validated['items'] as $index => $item) {
                EquipmentDetail::create([
                    'equipment_id' => $equipment->id,
                    'nama_peralatan' => $item['nama_peralatan'],
                    'spesifikasi' => $item['spesifikasi'],
                    'satuan' => $item['satuan'],
                    'jumlah' => $item['jumlah'],
                    'number' => $index + 1,
                ]);
            }

            return redirect()->route('equipments.index', $document_id)->with('success', 'Peralatan berhasil diubah');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengubah peralatan: ' . $e->getMessage());
        }
    }

    public function destroy($document_id, $id)
    {
        try {
            $equipment = Equipment::findOrFail($id);

            // Delete all related details
            EquipmentDetail::where('equipment_id', $id)->delete();

            // Delete equipment
            $equipment->delete();

            return redirect()->route('equipments.index', $document_id)->with('success', 'Peralatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus peralatan: ' . $e->getMessage());
        }
    }

    public function destroyDetail($document_id, $equipment_id, $detail_id)
    {
        try {
            $detail = EquipmentDetail::findOrFail($detail_id);
            $detail->delete();

            return redirect()->route('equipments.index', $document_id)->with('success', 'Detail peralatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus detail peralatan: ' . $e->getMessage());
        }
    }

    public function destroyAll($document_id)
    {
        try {
            // Get all equipment for this document
            $equipments = Equipment::where('document_id', $document_id)->get();

            foreach ($equipments as $equipment) {
                // Delete all related details
                EquipmentDetail::where('equipment_id', $equipment->id)->delete();
                // Delete equipment
                $equipment->delete();
            }

            return redirect()->route('equipments.index', $document_id)->with('success', 'Semua peralatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus peralatan: ' . $e->getMessage());
        }
    }
}
