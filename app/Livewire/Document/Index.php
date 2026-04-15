<?php

namespace App\Livewire\Document;

use App\Models\Competence;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Document')]
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
            $document->delete();
            $this->toast('message', 'Data berhasil dihapus.');
        } else {
            $this->toast('warning', 'Data tidak ditemukan.');
        }

        $this->closeModal();
    }
}
