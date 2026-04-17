<?php

namespace App\Livewire\Document;

use App\Models\Document;
use App\Models\GeneralInformation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public $documentId;
    public $data;
    public $generalInfo = '';

    public function mount($id)
    {
        $this->documentId = $id;
        $this->loadData();
    }

    public function loadData()
    {
        $this->data = Document::with('competence.scheme')->findOrFail($this->documentId);
        $this->generalInfo = GeneralInformation::with('document')->where('document_id', $this->documentId)->first();
    }

    public function render()
    {
        return view('livewire.document.show');
    }
}
