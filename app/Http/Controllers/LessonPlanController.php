<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\CompetenceCode;
use App\Models\Document;
use App\Models\LessonPlan;
use App\Models\LessonPlanDetail;
use Illuminate\Http\Request;

class LessonPlanController extends Controller
{
    public function index($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $dataKodeUnit = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();
        $lessonPlans = LessonPlan::firstOrCreate(['document_id' => $document_id], ['document_id' => $document_id]);
        $lessonPlanDetails = LessonPlanDetail::where('lesson_plan_id', $lessonPlans->id)->orderBy('number', 'asc')->get();

        return view('lesson-plans.index', compact('document_id', 'dataDocument', 'competences', 'dataKodeUnit', 'lessonPlans', 'lessonPlanDetails'));
    }

    public function create($document_id)
    {
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $lessonPlans = LessonPlan::where('document_id', $document_id)->first();
        $allCompetenceCodes = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();
        return view('lesson-plans.create', compact('document_id', 'dataDocument', 'competences', 'allCompetenceCodes', 'lessonPlans'));
    }

    public function store(Request $request, $document_id)
    {
        $validated = $request->validate([
            'penyajian_hari' => 'required|integer|min:1',
            'waktu_jp' => 'required|integer|min:1',
            'tujuan_instruksional' => 'required|string',
            'metode' => 'required|string',
            'media' => 'required|string',
            'persiapan_text' => 'required|string',
            'detail_sub_pokok' => 'nullable|array',
            'detail_uraian' => 'nullable|array',
            'detail_media' => 'nullable|array',
            'detail_waktu' => 'nullable|array',
            'detail_number' => 'nullable|array',
        ]);

        // Calculate waktu_menit (1 JP = 45 menit)
        $validated['waktu_menit'] = $validated['waktu_jp'] * 45;
        $validated['document_id'] = $document_id;

        // Rename persiapan_text to persiapan
        $validated['persiapan'] = $validated['persiapan_text'];
        unset($validated['persiapan_text']);

        // Extract detail arrays
        $detailSubPokok = $validated['detail_sub_pokok'] ?? [];
        $detailUraian = $validated['detail_uraian'] ?? [];
        $detailMedia = $validated['detail_media'] ?? [];
        $detailWaktu = $validated['detail_waktu'] ?? [];
        $detailNumber = $validated['detail_number'] ?? [];

        unset($validated['detail_sub_pokok']);
        unset($validated['detail_uraian']);
        unset($validated['detail_media']);
        unset($validated['detail_waktu']);
        unset($validated['detail_number']);

        // Create or Update main lesson plan
        $lessonPlan = LessonPlan::updateOrCreate(
            ['document_id' => $document_id],
            $validated
        );

        // Delete old details and create new ones
        LessonPlanDetail::where('lesson_plan_id', $lessonPlan->id)->delete();

        // Create detail records
        foreach ($detailSubPokok as $index => $subPokok) {
            if (!empty($subPokok)) {
                LessonPlanDetail::create([
                    'lesson_plan_id' => $lessonPlan->id,
                    'sub_pokok' => $subPokok,
                    'uraian' => $detailUraian[$index] ?? '',
                    'media' => $detailMedia[$index] ?? '',
                    'waktu' => $detailWaktu[$index] ?? 0,
                    'number' => $detailNumber[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('lesson-plans.index', $document_id)
            ->with('success', 'Rencana Pelatihan berhasil disimpan');
    }

    public function edit($document_id, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        $dataDocument = Document::with('competence.scheme')->findOrFail($document_id);
        $competences = Competence::findOrFail($dataDocument->competence_id);
        $allCompetenceCodes = CompetenceCode::where('competence_id', $competences->id)->orderBy('number', 'asc')->get();
        $lessonPlanDetails = LessonPlanDetail::where('lesson_plan_id', $lessonPlan->id)->orderBy('number', 'asc')->get();

        return view('lesson-plans.edit', compact('document_id', 'lessonPlan', 'dataDocument', 'competences', 'allCompetenceCodes', 'lessonPlanDetails'));
    }

    public function update(Request $request, $document_id, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        $validated = $request->validate([
            'penyajian_hari' => 'required|integer|min:1',
            'waktu_jp' => 'required|integer|min:1',
            'tujuan_instruksional' => 'required|string',
            'metode' => 'required|string',
            'media' => 'required|string',
            'persiapan_text' => 'required|string',
            'detail_sub_pokok' => 'nullable|array',
            'detail_uraian' => 'nullable|array',
            'detail_media' => 'nullable|array',
            'detail_waktu' => 'nullable|array',
            'detail_number' => 'nullable|array',
        ]);

        // Calculate waktu_menit
        $validated['waktu_menit'] = $validated['waktu_jp'] * 45;

        // Rename persiapan_text to persiapan
        $validated['persiapan'] = $validated['persiapan_text'];
        unset($validated['persiapan_text']);

        // Extract detail arrays
        $detailSubPokok = $validated['detail_sub_pokok'] ?? [];
        $detailUraian = $validated['detail_uraian'] ?? [];
        $detailMedia = $validated['detail_media'] ?? [];
        $detailWaktu = $validated['detail_waktu'] ?? [];
        $detailNumber = $validated['detail_number'] ?? [];

        unset($validated['detail_sub_pokok']);
        unset($validated['detail_uraian']);
        unset($validated['detail_media']);
        unset($validated['detail_waktu']);
        unset($validated['detail_number']);

        // Create or Update main lesson plan
        $lessonPlan = LessonPlan::updateOrCreate(
            ['document_id' => $document_id],
            $validated
        );

        // Delete old details and create new ones
        LessonPlanDetail::where('lesson_plan_id', $lessonPlan->id)->delete();

        // Create detail records
        foreach ($detailSubPokok as $index => $subPokok) {
            if (!empty($subPokok)) {
                LessonPlanDetail::create([
                    'lesson_plan_id' => $lessonPlan->id,
                    'sub_pokok' => $subPokok,
                    'uraian' => $detailUraian[$index] ?? '',
                    'media' => $detailMedia[$index] ?? '',
                    'waktu' => $detailWaktu[$index] ?? 0,
                    'number' => $detailNumber[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('lesson-plans.index', $document_id)->with('success', 'Rencana Pelatihan berhasil diperbarui');
    }

    public function destroy($document_id, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        $lessonPlan->delete();

        return redirect()->route('lesson-plans.index', $document_id)->with('success', 'Rencana Pelatihan berhasil dihapus');
    }
}
