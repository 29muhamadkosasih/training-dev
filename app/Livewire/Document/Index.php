<?php

namespace App\Livewire\Document;

use App\Models\Competence;
use App\Models\Curriculum;
use App\Models\Equipment;
use App\Models\EquipmentDetail;
use App\Models\GeneralInformation;
use App\Models\LessonPlan;
use App\Models\Silabus;
use App\Models\Supply;
use App\Models\SupplyDetail;
use Livewire\Attributes\Layout;
use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;
    public $dataId;
    public $showConfirm = false;

    protected $paginationTheme = 'bootstrap';

    // Reset halaman ketika search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset filter/pencarian
    public function resetFilter()
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    private function getDocumentStatus($documentId)
    {
        return [
            'general_information' => GeneralInformation::where('document_id', $documentId)->exists(),
            'curriculum' => Curriculum::where('document_id', $documentId)->exists(),
            'silabus' => Silabus::where('document_id', $documentId)->exists(),
            'lesson_plan' => LessonPlan::where('document_id', $documentId)->exists(),
            'equipment' => Equipment::where('document_id', $documentId)->exists(),
            'supply' => Supply::where('document_id', $documentId)->exists(),
        ];
    }

    public function render()
    {
        $perPageValue = $this->perPage ?: 99999; // Jika kosong (All), gunakan nilai besar

        // Query documents dengan eager load relasi
        $datas = Document::with('competence.scheme')
            ->when($this->search, function ($q) {
                // Cari berdasarkan competence data (yang di database lain)
                $competenceIds = Competence::where(function ($subQuery) {
                    $subQuery->where('no_skkni', 'like', '%' . $this->search . '%')->orWhereHas('scheme', function ($schemeQuery) {
                        $schemeQuery->where('name', 'like', '%' . $this->search . '%');
                    });
                })
                    ->pluck('id')
                    ->toArray();

                return $q->whereIn('competence_id', $competenceIds);
            })
            ->latest()
            ->paginate($perPageValue);

        // Load competence codes untuk count
        foreach ($datas as $document) {
            if ($document->competence) {
                $document->competence->load('competenceCodes');
                $document->competence->competence_codes_count = $document->competence->competenceCodes->count();
            }
            // Add status for each document
            $document->status = $this->getDocumentStatus($document->id);
        }

        return view('livewire.document.index', [
            'datas' => $datas,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dataId = (string) $id;
        $this->showConfirm = true;
    }

    public function closeModal()
    {
        $this->showConfirm = false;
        $this->dataId = null;
    }

    protected function toast(string $type, string $message): void
    {
        session()->flash($type, $message);
        $this->dispatch('notify', type: $type === 'message' ? 'success' : $type, message: $message);
    }

    public function delete()
    {
        $document = Document::find($this->dataId);

        if ($document) {
            // Delete all related details
            GeneralInformation::where('document_id', $document->id)->delete();
            Curriculum::where('document_id', $document->id)->delete();
            Silabus::where('document_id', $document->id)->delete();
            LessonPlan::where('document_id', $document->id)->delete();

            // Delete equipment and its details
            $equipments = Equipment::where('document_id', $document->id)->get();
            foreach ($equipments as $equipment) {
                EquipmentDetail::where('equipment_id', $equipment->id)->delete();
            }
            Equipment::where('document_id', $document->id)->delete();

            // Delete supply and its details
            $supplies = Supply::where('document_id', $document->id)->get();
            foreach ($supplies as $supply) {
                SupplyDetail::where('supply_id', $supply->id)->delete();
            }
            Supply::where('document_id', $document->id)->delete();

            // Delete document
            $document->delete();
            $this->toast('message', 'Data berhasil dihapus berserta detail-detailnya.');
        } else {
            $this->toast('warning', 'Data tidak ditemukan.');
        }

        $this->closeModal();
    }
}
