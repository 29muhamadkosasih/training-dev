<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\CompetenceCode;
use App\Models\CompetenceCodeElement;
use App\Models\Document;
use App\Models\Silabus;
use App\Models\SilabusDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SilabusController extends Controller
{
    public function index($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $dataKodeUnit = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();
        $silabus = Silabus::where('document_id', $document_id)->orderBy('created_at', 'asc')->get();

        return view('silabus.index', compact('document_id', 'dataDocument', 'competences', 'dataKodeUnit', 'silabus'));
    }

    public function create($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $sillabus = Silabus::where('document_id', $document_id)->orderBy('created_at', 'asc')->get();
        // Get all competence codes for this competence
        $allCompetenceCodes = CompetenceCode::where('competence_id', $competences->id)
            ->whereNotIn('id', $sillabus->pluck('unit_kompetensi_id')->toArray() ?? [''])
            ->orderBy('number', 'asc')
            ->get();
        return view('silabus.create', compact('document_id', 'dataDocument', 'competences', 'allCompetenceCodes'));
    }

    public function store(Request $request, $document_id)
    {
        $validated = $request->validate([
            'unit_kompetensi_id' => 'required|string|max:100',
        ]);

        try {
            $data = [
                'id' => Str::uuid(),
                'document_id' => $document_id,
                'unit_kompetensi_id' => $validated['unit_kompetensi_id'],
            ];

            Silabus::create($data);

            return redirect()
                ->route('silabus.create.unit', ['document_id' => $document_id, 'unit_kompetensi_id' => $validated['unit_kompetensi_id']])
                ->with('success', 'Silabus berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan informasi umum: ' . $e->getMessage());
        }
    }

    public function createUnit($document_id, $unit_kompetensi_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $silabus = Silabus::where('unit_kompetensi_id', $unit_kompetensi_id)->with('document.competence.scheme')->firstOrFail();
        $competenceCodes = CompetenceCode::where('competence_id', $silabus->document->competence_id)->first();
        $element = CompetenceCodeElement::where('competence_code_id', $silabus->unit_kompetensi_id)->orderBy('number', 'asc')->get();
        return view('silabus.create-unit', compact('document_id', 'unit_kompetensi_id', 'dataDocument', 'element', 'competenceCodes'));
    }

    public function editUnit($document_id, $unit_kompetensi_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $silabus = Silabus::where('unit_kompetensi_id', $unit_kompetensi_id)->with('document.competence.scheme')->firstOrFail();
        $competenceCodes = CompetenceCode::where('competence_id', $silabus->document->competence_id)->first();
        $element = CompetenceCodeElement::where('competence_code_id', $silabus->unit_kompetensi_id)->orderBy('number', 'asc')->get();

        // Get all silabus details and create a map for easy access
        $silabusDetails = SilabusDetail::where('silabus_id', $silabus->id)->get();
        $silabusDetailMap = $silabusDetails->keyBy('element_id');

        return view('silabus.edit-unit', compact('document_id', 'unit_kompetensi_id', 'dataDocument', 'element', 'competenceCodes', 'silabus', 'silabusDetailMap'));
    }

    public function storeUnit(Request $request, $document_id, $unit_kompetensi_id)
    {
        $validated = $request->validate([
            'waktu_pelatihan' => 'nullable|string|max:255',
            'metode_pelatihan' => 'nullable|string|max:255',
            'capaian_unit_kompetensi' => 'nullable|string',
        ]);

        $silabus = Silabus::where('unit_kompetensi_id', $unit_kompetensi_id)->firstOrFail();

        try {
            // Update silabus with main fields
            $silabus->update([
                'waktu_pelatihan' => $validated['waktu_pelatihan'] ?? null,
                'metode_pelatihan' => $validated['metode_pelatihan'] ?? null,
                'capaian_unit_kompetensi' => $validated['capaian_unit_kompetensi'] ?? null,
            ]);

            // Get all element IDs from request
            $elementIds = [];
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'element_id_') === 0) {
                    $elementIds[] = $value;
                }
            }

            // Create silabus details for each element
            foreach ($elementIds as $elementId) {
                SilabusDetail::create([
                    'id' => Str::uuid(),
                    'silabus_id' => $silabus->id,
                    'element_id' => $elementId,
                    'number' => $request->input('number_' . $elementId),
                    'indikator_unjuk_kerja' => $request->input('indikator_' . $elementId),
                    'pengetahuan' => $request->input('pengetahuan_' . $elementId),
                    'keterampilan_sikap' => $request->input('keterampilan_sikap_' . $elementId),
                    'durasi' => $request->input('durasi_' . $elementId),
                ]);
            }

            return redirect()->route('silabus.index', $document_id)->with('success', 'Silabus berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan silabus: ' . $e->getMessage());
        }
    }

    public function updateUnit(Request $request, $document_id, $unit_kompetensi_id)
    {
        $validated = $request->validate([
            'waktu_pelatihan' => 'nullable|string|max:255',
            'metode_pelatihan' => 'nullable|string|max:255',
            'capaian_unit_kompetensi' => 'nullable|string',
        ]);

        $silabus = Silabus::where('unit_kompetensi_id', $unit_kompetensi_id)->firstOrFail();

        try {
            // Update silabus with main fields
            $silabus->update([
                'waktu_pelatihan' => $validated['waktu_pelatihan'] ?? null,
                'metode_pelatihan' => $validated['metode_pelatihan'] ?? null,
                'capaian_unit_kompetensi' => $validated['capaian_unit_kompetensi'] ?? null,
            ]);

            // Get all element IDs from request
            $elementIds = [];
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'element_id_') === 0) {
                    $elementIds[] = $value;
                }
            }

            // Update or create silabus details for each element
            foreach ($elementIds as $elementId) {
                SilabusDetail::updateOrCreate(
                    [
                        'silabus_id' => $silabus->id,
                        'element_id' => $elementId,
                    ],
                    [
                        'number' => $request->input('number_' . $elementId),
                        'indikator_unjuk_kerja' => $request->input('indikator_' . $elementId),
                        'pengetahuan' => $request->input('pengetahuan_' . $elementId),
                        'keterampilan_sikap' => $request->input('keterampilan_sikap_' . $elementId),
                        'durasi' => $request->input('durasi_' . $elementId),
                    ],
                );
            }

            return redirect()->route('silabus.index', $document_id)->with('success', 'Silabus berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui silabus: ' . $e->getMessage());
        }
    }

    public function destroy($document_id, $unit_kompetensi_id)
    {
        try {
            $data = Silabus::where('unit_kompetensi_id', $unit_kompetensi_id)->first();
            SilabusDetail::where('silabus_id', $data->id)->delete();
            $data->delete();

            return redirect()->route('silabus.index', $document_id)->with('success', 'Silabus berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus silabus: ' . $e->getMessage());
        }
    }
}
