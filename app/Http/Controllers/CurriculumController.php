<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\CompetenceCode;
use App\Models\Curriculum;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurriculumController extends Controller
{
    public function index($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);

        // Get all curriculum items grouped by kelompok
        $curricula = Curriculum::with([
            'competenceCode' => function ($query) {
                $query->orderBy('number', 'asc');
            },
        ])
            ->where('document_id', $document_id)
            ->orderBy('urutan', 'asc')
            ->get();

        // Get all available competence codes for dropdowns
        $competenceCodes = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();

        // Calculate subtotals
        $subtotals = [
            'inti' => [
                'teori' => $curricula->where('kelompok', 'inti')->sum('perkiraan_waktu_teori'),
                'praktek' => $curricula->where('kelompok', 'inti')->sum('perkiraan_waktu_praktek'),
                'jumlah' => $curricula->where('kelompok', 'inti')->sum('jumlah'),
            ],
            'penunjang' => [
                'teori' => $curricula->where('kelompok', 'penunjang')->sum('perkiraan_waktu_teori'),
                'praktek' => $curricula->where('kelompok', 'penunjang')->sum('perkiraan_waktu_praktek'),
                'jumlah' => $curricula->where('kelompok', 'penunjang')->sum('jumlah'),
            ],
        ];

        $subtotals['total'] = [
            'teori' => $subtotals['inti']['teori'] + $subtotals['penunjang']['teori'],
            'praktek' => $subtotals['inti']['praktek'] + $subtotals['penunjang']['praktek'],
            'jumlah' => $subtotals['inti']['jumlah'] + $subtotals['penunjang']['jumlah'],
        ];

        return view('curricula.index', compact('document_id', 'dataDocument', 'competences', 'curricula', 'competenceCodes', 'subtotals'));
    }

    public function create($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);

        // Get all competence codes for this competence
        $allCompetenceCodes = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();

        // Get used codes grouped by kelompok
        $usedCodesByKelompok = [
            'inti' => Curriculum::where('document_id', $document_id)->where('kelompok', 'inti')->whereNotNull('competence_code_id')->pluck('competence_code_id')->toArray(),
            'penunjang' => Curriculum::where('document_id', $document_id)->where('kelompok', 'penunjang')->whereNotNull('competence_code_id')->pluck('competence_code_id')->toArray(),
        ];

        return view('curricula.create', compact('document_id', 'dataDocument', 'competences', 'allCompetenceCodes', 'usedCodesByKelompok'));
    }

    public function store(Request $request, $document_id)
    {
        $kelompok = $request->input('kelompok');

        // Validasi kelompok
        $request->validate([
            'kelompok' => 'required|in:inti,penunjang,ojt',
        ]);

        try {
            if ($kelompok === 'ojt') {
                // Handle single OJT record
                $request->validate([
                    'ojt_bulan' => 'required|string',
                ]);

                Curriculum::create([
                    'id' => Str::uuid(),
                    'document_id' => $document_id,
                    'kelompok' => 'ojt',
                    'ojt_bulan' => $request->input('ojt_bulan'),
                ]);
            } else {
                // Handle multiple items for inti/penunjang
                // Format: items[code_id][field] -> array dengan key adalah competence_code_id
                $items = $request->input('items', []);

                if (empty($items)) {
                    return redirect()->back()->with('error', 'Silakan tambahkan minimal satu item kurikulum');
                }

                foreach ($items as $code_id => $item) {
                    // Skip empty items (if both values are empty/zero)
                    $teori = (int) ($item['perkiraan_waktu_teori'] ?? 0);
                    $praktek = (int) ($item['perkiraan_waktu_praktek'] ?? 0);
                    $urutan = (int) ($item['urutan'] ?? 0);

                    if ($teori == 0 && $praktek == 0) {
                        continue;
                    }

                    Curriculum::create([
                        'id' => Str::uuid(),
                        'document_id' => $document_id,
                        'kelompok' => $kelompok,
                        'competence_code_id' => $code_id,
                        'urutan' => $urutan,
                        'perkiraan_waktu_teori' => $teori,
                        'perkiraan_waktu_praktek' => $praktek,
                        'jumlah' => $teori + $praktek,
                    ]);
                }
            }

            return redirect()->route('curricula.index', $document_id)->with('success', 'Kurikulum berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan kurikulum: ' . $e->getMessage());
        }
    }

    public function edit($document_id, $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);

        // Get all competence codes for this competence
        $allCompetenceCodes = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();

        // Get used codes grouped by kelompok (excluding current item)
        $usedCodesByKelompok = [
            'inti' => Curriculum::where('document_id', $document_id)->where('kelompok', 'inti')->where('id', '!=', $id)->whereNotNull('competence_code_id')->pluck('competence_code_id')->toArray(),
            'penunjang' => Curriculum::where('document_id', $document_id)->where('kelompok', 'penunjang')->where('id', '!=', $id)->whereNotNull('competence_code_id')->pluck('competence_code_id')->toArray(),
        ];

        return view('curricula.edit', compact('document_id', 'curriculum', 'dataDocument', 'competences', 'allCompetenceCodes', 'usedCodesByKelompok'));
    }

    public function update(Request $request, $document_id, $id)
    {
        $curriculum = Curriculum::findOrFail($id);

        $validated = $request->validate([
            'kelompok' => 'required|in:inti,penunjang,ojt',
            'competence_code_id' => 'nullable|required_if:kelompok,inti,penunjang',
            'urutan' => 'nullable|integer|min:1',
            'perkiraan_waktu_teori' => 'nullable|required_if:kelompok,inti,penunjang|integer|min:0',
            'perkiraan_waktu_praktek' => 'nullable|required_if:kelompok,inti,penunjang|integer|min:0',
            'ojt_bulan' => 'nullable|required_if:kelompok,ojt',
        ]);

        try {
            $data = [
                'kelompok' => $validated['kelompok'],
            ];

            if ($validated['kelompok'] !== 'ojt') {
                $data['competence_code_id'] = $validated['competence_code_id'];
                $data['urutan'] = $validated['urutan'] ?? null;
                $data['perkiraan_waktu_teori'] = $validated['perkiraan_waktu_teori'] ?? 0;
                $data['perkiraan_waktu_praktek'] = $validated['perkiraan_waktu_praktek'] ?? 0;
                $data['jumlah'] = ($validated['perkiraan_waktu_teori'] ?? 0) + ($validated['perkiraan_waktu_praktek'] ?? 0);
                $data['ojt_bulan'] = null;
            } else {
                $data['ojt_bulan'] = $validated['ojt_bulan'];
                $data['competence_code_id'] = null;
                $data['urutan'] = null;
                $data['perkiraan_waktu_teori'] = 0;
                $data['perkiraan_waktu_praktek'] = 0;
                $data['jumlah'] = 0;
            }

            $curriculum->update($data);

            return redirect()->route('curricula.index', $document_id)->with('success', 'Kurikulum berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui kurikulum: ' . $e->getMessage());
        }
    }

    public function destroy($document_id, $id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            $curriculum->delete();

            return redirect()->route('curricula.index', $document_id)->with('success', 'Kurikulum berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus kurikulum: ' . $e->getMessage());
        }
    }
}
