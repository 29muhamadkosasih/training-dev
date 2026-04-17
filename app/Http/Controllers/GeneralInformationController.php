<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\CompetenceCode;
use App\Models\Document;
use App\Models\GeneralInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneralInformationController extends Controller
{
    protected $fieldsList = [
        'kode',
        'jenis_program',
        'metode_pelatihan',
        'tujuan',
        'jenis_standart_kompetensi',
        'persyaratan_pendidikan',
        'persyaratan_pelatihan',
        'persyaratan_pengalaman_kerja',
        'persyaratan_usia',
        'persyaratan_khusus_peserta',
        'instruktur_pendidikan_formal',
        'instruktur_kompetensi_metodologi',
        'instruktur_kompetensi_teknis',
        'instruktur_pengalaman_kerja',  
        'instruktur_persyaratan_khusus',
    ];

    public function index($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $dataKodeUnit = CompetenceCode::where('competence_id', $competences->id)
            ->orderBy('number', 'asc')
            ->get();
        $generalInformation = GeneralInformation::where('document_id', $document_id)->first();

        return view('general-informations.index', compact(
            'document_id',
            'dataDocument',
            'competences',
            'dataKodeUnit',
            'generalInformation'
        ));
    }

    public function create($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $dataKodeUnit = CompetenceCode::where('competence_id', $competences->id)
            ->orderBy('number', 'asc')
            ->get();

        return view('general-informations.create', compact(
            'document_id',
            'dataDocument',
            'competences',
            'dataKodeUnit'
        ));
    }

    public function store(Request $request, $document_id)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:100',
            'jenis_program' => 'nullable|string|max:255',
            'metode_pelatihan' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string',
            'jenis_standart_kompetensi' => 'nullable|string|max:255',
            'persyaratan_pendidikan' => 'nullable|string',
            'persyaratan_pelatihan' => 'nullable|string',
            'persyaratan_pengalaman_kerja' => 'nullable|string',
            'persyaratan_usia' => 'nullable|string',
            'persyaratan_khusus_peserta' => 'nullable|string',
            'instruktur_pendidikan_formal' => 'nullable|string',
            'instruktur_kompetensi_metodologi' => 'nullable|string',
            'instruktur_kompetensi_teknis' => 'nullable|string',
            'instruktur_pengalaman_kerja' => 'nullable|string',
            'instruktur_persyaratan_khusus' => 'nullable|string',
        ]);

        try {
            $data = [
                'id' => Str::uuid(),
                'document_id' => $document_id,
            ];
            foreach ($this->fieldsList as $field) {
                $data[$field] = $validated[$field] ?? null;
            }

            GeneralInformation::create($data);

            return redirect()
                ->route('general-informations.index', $document_id)
                ->with('success', 'Informasi Umum berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan informasi umum: ' . $e->getMessage());
        }
    }

    public function edit($document_id, $id)
    {
        $generalInformation = GeneralInformation::findOrFail($id);
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $dataKodeUnit = CompetenceCode::where('competence_id', $competences->id)
            ->orderBy('number', 'asc')
            ->get();

        return view('general-informations.edit', compact(
            'document_id',
            'generalInformation',
            'dataDocument',
            'competences',
            'dataKodeUnit'
        ));
    }

    public function update(Request $request, $document_id, $id)
    {
        $generalInformation = GeneralInformation::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'required|string|max:100',
            'jenis_program' => 'nullable|string|max:255',
            'metode_pelatihan' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string',
            'jenis_standart_kompetensi' => 'nullable|string|max:255',
            'persyaratan_pendidikan' => 'nullable|string',
            'persyaratan_pelatihan' => 'nullable|string',
            'persyaratan_pengalaman_kerja' => 'nullable|string',
            'persyaratan_usia' => 'nullable|string',
            'persyaratan_khusus_peserta' => 'nullable|string',
            'instruktur_pendidikan_formal' => 'nullable|string',
            'instruktur_kompetensi_metodologi' => 'nullable|string',
            'instruktur_kompetensi_teknis' => 'nullable|string',
            'instruktur_pengalaman_kerja' => 'nullable|string',
            'instruktur_persyaratan_khusus' => 'nullable|string',
        ]);

        try {
            $data = [];
            foreach ($this->fieldsList as $field) {
                $data[$field] = $validated[$field] ?? null;
            }

            $generalInformation->update($data);

            return redirect()
                ->route('general-informations.index', $document_id)
                ->with('success', 'Informasi Umum berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui informasi umum: ' . $e->getMessage());
        }
    }

    public function destroy($document_id, $id)
    {
        try {
            $generalInformation = GeneralInformation::findOrFail($id);
            $generalInformation->delete();

            return redirect()
                ->route('general-informations.index', $document_id)
                ->with('success', 'Informasi Umum berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus informasi umum: ' . $e->getMessage());
        }
    }
}
