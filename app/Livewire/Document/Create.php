<?php

namespace App\Livewire\Document;

use App\Models\Competence;
use App\Models\Document;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Create Document')]
class Create extends Component
{
    public $competence_id = '';
    public $search = '';

    protected $rules = [
        'competence_id' => 'required|string',
    ];

    public function store()
    {
        $this->validate();

        try {
            Document::create([
                'competence_id' => $this->competence_id,
            ]);

            session()->flash('success', 'Document berhasil ditambahkan');
            // return redirect()->route('documents.index');
            return $this->redirectRoute('documents.index', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambahkan document: ' . $e->getMessage());
        }
    }

    public function resetInput()
    {
        $this->reset(['search', 'competence_id']);
    }

    public function render()
    {
        // Ambil semua competence_id yang sudah dipakai
        $datas = Document::pluck('competence_id')->toArray();

        $competence = Competence::with('scheme')
            ->whereNotIn('id', $datas)
            ->when($this->search, function ($query) {
                $query->whereHas('scheme', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        return view('livewire.document.create', compact('competence'));
    }
}
