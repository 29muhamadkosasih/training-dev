<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\CompetenceCode;
use App\Models\Curriculum;
use App\Models\Document;
use App\Models\GeneralInformation;
use App\Models\Silabus;
use App\Models\SilabusDetail;
use Illuminate\Http\Request;
use PDF;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'competence_id' => 'required|exists:second_mysql.competences,id',
        ]);

        Document::create($validated);

        return redirect()->back()->with('message', 'Document berhasil ditambahkan.');
    }

    public function getViewPdf($id)
    {
        $document = Document::findOrFail($id);
        $competences = Competence::where('id', $document->competence_id)->first();
        $dataKodeUnit = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();
        $generalInformation = GeneralInformation::where('document_id', $document->id)->first();
        $sillabus = Silabus::where('document_id', $document->id)->orderBy('created_at', 'asc')->get();
        $curricula = Curriculum::with([
            'competenceCode' => function ($query) {
                $query->orderBy('number', 'asc');
            },
        ])
            ->where('document_id', $document->id)
            ->orderBy('urutan', 'asc')
            ->get();
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

        $pdf = PDF::loadView('document.pdf', [
            'document' => $document,
            'competences' => $competences,
            'dataKodeUnit' => $dataKodeUnit,
            'generalInformation' => $generalInformation,
            'curricula' => $curricula,
            'subtotals' => $subtotals,
            'sillabus' => $sillabus,
        ])->setPaper('A4', 'portrait');
        $pdf->render();
        // Tambahkan nomor halaman ke PDF
        $canvas = $pdf->getCanvas();
        $font = $pdf->getFontMetrics()->get_font('DejaVuSans', 'normal');
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($font) {
            $text = "Page $pageNumber of $pageCount";
            $x = 275; // Posisi horizontal
            $y = 825; // Posisi vertikal
            $canvas->text($x, $y, $text, $font, 7.5);
        });

        $filename = 'PROGRAM PELATIHAN BERBASIS KOMPETENSI.pdf';

        return $pdf->stream($filename);
    }
}
