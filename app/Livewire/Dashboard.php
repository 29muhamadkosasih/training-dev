<?php

namespace App\Livewire;

use App\Models\Scheme;
use App\Models\Document;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $totalSchemes = 0;
    public $totalDocuments = 0;
    public $latestSchemes = [];
    public $latestDocuments = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Load data from Scheme model
        $this->totalSchemes = Scheme::count();
        $this->latestSchemes = Scheme::latest('created_at')->limit(5)->get()->toArray();

        // Load data from Document model
        $this->totalDocuments = Document::count();
        $this->latestDocuments = Document::with('competence')->latest('created_at')->limit(5)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
