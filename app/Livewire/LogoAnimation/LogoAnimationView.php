<?php

namespace App\Livewire\LogoAnimation;

use App\Models\LogoAnimation;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LogoAnimationView extends Component
{

    public $logoAnimation;

    public function mount()
    {
        $this->authorize('logoAnimation-list');
        $this->logoAnimation=logoAnimation::find(1);
    }


    public function toggleActivate($id)
    {
        $logoAnimation = logoAnimation::findOrFail($id);

        $logoAnimation->active = $logoAnimation->active == 0 ? 1 : 0;

        $text_action = $logoAnimation->active == 1 ? 'Activated' : 'deactivated';

        $logoAnimation->save();

        return to_route('logo.animation')->with('success', 'Logo animation '.$text_action.' successfully!');
    }

    public function render()
    {
        return view('livewire.logo-animation.logo-animation-view');
    }
}
