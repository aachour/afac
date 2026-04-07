<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackGroups;

class PMView extends Component
{

    use AuthorizesRequests; 

    public $pms = [];
    public $form_id;
    public $group_id;
    public $jurors=[];
    public $jurors_id;
    public $readers=[];
    public $readers_id;

    public function mount($formId)
    {
        $this->authorize('formstack-viewAssignedPM');
        
        $this->form_id=$formId;

        $this->pms = FormStackGroups::where('form_id', $formId)->get();

        $this->jurors = User::role('Juror')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        $this->readers = User::role('Reader')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();
    }

    public function setGroupId($groupId,$type)
    {
        $this->group_id=$groupId;
        $formStackGroup= FormStackGroups::find($this->group_id);
        $this->jurors_id=json_decode($formStackGroup->jurors_id) ?? [];
        $this->readers_id=json_decode($formStackGroup->readers_id) ?? [];
        
        if($type=="Jurors")
        {
            $this->dispatch('jurors-loaded');
        }
        else if($type=="Readers")
        {
            $this->dispatch('readers-loaded');
        }
    }

    public function saveJurors()
    {   

        FormStackGroups::where('id', $this->group_id)
            ->update([
                'jurors_id' => json_encode($this->jurors_id),
            ]);

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Jurors assigned successfully!');
        
    }

    public function saveReaders()
    {   

        FormStackGroups::where('id', $this->group_id)
            ->update([
                'readers_id' => json_encode($this->readers_id),
            ]);

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Readers assigned done successfully!');
        
    }

    public function render()
    {
        return view('livewire.formstack.p-m-view');
    }
}
