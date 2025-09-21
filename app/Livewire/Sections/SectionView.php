<?php

namespace App\Livewire\Sections;

use App\Models\Pages;
use App\Models\Sections;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionView extends Component
{
    public function render()
    {
        return view('livewire.sections.section-view');
    }
}
