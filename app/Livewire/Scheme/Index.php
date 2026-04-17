<?php

namespace App\Livewire\Scheme;

use App\Models\Scheme;
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

        $datas = Scheme::query()
            ->select('id', 'name', 'no_scheme')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orWhere('no_scheme', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($perPageValue);

        return view('livewire.scheme.index', [
            'datas' => $datas,
        ]);
    }
}
