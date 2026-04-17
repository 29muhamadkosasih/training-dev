<?php

namespace App\Livewire\Competence;

use App\Models\Competence;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    // Reset halaman ketika search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Apply filter untuk pencarian
    public function applyFilter()
    {
        $this->resetPage();
    }

    // Reset filter/pencarian
    public function resetFilter()
    {
        $this->reset(['search', 'dataId', 'showConfirm']);
        $this->resetPage();
    }

    public function render()
    {
        $perPageValue = $this->perPage ?: 99999; // Jika kosong (All), gunakan nilai besar

        $datas = Competence::query()
            ->with('scheme')
            ->withCount('competenceCodes')
            ->when($this->search, function ($q) {
                return $q->where(function ($subQuery) {
                    $subQuery->Where('no_skkni', 'like', '%' . $this->search . '%')
                        ->orWhere('as', 'like', '%' . $this->search . '%')
                        ->orWhereHas('scheme', function ($schemeQuery) {
                            $schemeQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate($perPageValue);

        return view('livewire.competence.index', [
            'datas' => $datas,
        ]);
    }
}
