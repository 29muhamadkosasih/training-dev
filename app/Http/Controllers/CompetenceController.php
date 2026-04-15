<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\CompetenceCode;
use PDF;

class CompetenceController extends Controller
{
    public function getViewPdf($id)
    {
        $data = Competence::find($id);
        $dataKodeUnit = CompetenceCode::where('competence_id', $data->id)->orderBy('number', 'asc')->get();
        // Render tampilan ke dalam HTML
        $html = view('competences.pdf', [
            'data' => $data,
            'dataKodeUnit' => $dataKodeUnit,
        ])->render();

        // Buat objek PDF
        $pdf = PDF::loadHtml($html);

        // Aktifkan HTML5 Parser dan PHP
        $pdf->set_option('isHtml5ParserEnabled', true);
        $pdf->set_option('isPhpEnabled', true);

        // Set ukuran kertas jika diperlukan (contoh: A4, portrait)
        $pdf->setPaper('A4', 'portrait');
        //dd($data->scheme->name);

        // Render PDF
        $pdf->render();

        // Tambahkan nomor halaman ke PDF
        $canvas = $pdf->getCanvas();
        $font = $pdf->getFontMetrics()->get_font('DejaVuSans', 'normal');
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($font) {
            $text = "Page $pageNumber of $pageCount";
            $x = 275;
            $y = 828;
            $canvas->text($x, $y, $text, $font, 7);
        });

        // Stream PDF dengan nama file yang benar
        return $pdf->stream('KOMPETENSI-' . str_replace(' ', '-', strtoupper($data->scheme->name)) . '.pdf');
    }
}
