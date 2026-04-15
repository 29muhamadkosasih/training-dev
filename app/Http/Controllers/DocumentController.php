<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Document;
use Illuminate\Http\Request;

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
}
