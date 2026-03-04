<?php

namespace App\Livewire\Entries;

use App\Models\Entries;
use App\Models\Types;
use App\Models\grantees;
use App\Models\ProjectGrantees;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ProjectGranteesView extends Component
{

    use AuthorizesRequests; 

    public $years = [];
    
    public $showModal = false;
    public $modalTitle = 'Add Grantee';
    
    public $grantees = '';
    public $project_grantees = '';
    
    public $type_id;
    public $grantee_id;
    public $project_id;
    public $editingId = null;


    public function mount($projectId)
    {   
        $this->authorize('section-list');
        $this->type_id=3;
        $this->project_id=$projectId;
        $this->grantees=Entries::WHERE('type_id','4')->ORDERBY('id','DESC')->GET();
        $this->loadGrantees();
    }

    public function loadGrantees()
    {
        $this->project_grantees = ProjectGrantees::WHERE('project_id',$this->project_id)->ORDERBY('list_order','ASC')->get();
    }

    public function openModal($projectGranteeId = null)
    {
        $this->reset(['editingId', 'grantee_id']);

        if ($projectGranteeId) {
            $projectGrantee = ProjectGrantees::find($projectGranteeId);

            if ($projectGrantee) {
                $this->editingId = $projectGranteeId;
                $this->grantee_id = (string) $projectGrantee->grantee_id;
                $this->modalTitle = 'Edit Grantee';
            } else {
                $this->modalTitle = 'Add Grantee';
            }
        } else {
            $this->modalTitle = 'Add Grantee';
        }

        $this->showModal = true;
        $this->dispatch('grantee-modal-opened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'grantee_id']);
        $this->dispatch('grantee-modal-closed');
    }

    public function saveGrantee()
    {
        
        $rules = [
            'project_id' => 'required',
            'grantee_id' => 'required',
        ]; 

        $this->validate($rules);

        if ($this->editingId) {
            $this->authorize('section-edit');
            $projectGrantee = ProjectGrantees::find($this->editingId);
            $projectGrantee->update(['grantee_id' => $this->grantee_id]);
            $message = 'Grantee updated successfully!';
        } else {
            $this->authorize('section-create');
            $highestOrder = ProjectGrantees::WHERE('project_id',$this->project_id)->max('list_order');
            ProjectGrantees::create(['project_id' => $this->project_id,'grantee_id' => $this->grantee_id,'list_order'=>$highestOrder+1]);
            $message = 'Grantee added successfully!';
        }

        $this->closeModal();
        return to_route('entry.project.grantees',['projectId'=>$this->project_id])->with('success', $message);
    }

    #[On('updateOrder')]
    public function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            ProjectGrantees::where('id', $id)->update(['list_order' => $index+1]);
        }

        return to_route('entry.project.grantees', ['projectId' => $this->project_id])->with('success', 'Order updated successfully!');
        
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('section-delete');

        $grantee = ProjectGrantees::find($id);

        $grantee->delete();

        $message = 'Grantee deleted successfully!';

        return to_route('entry.project.grantees',['projectId'=>$this->project_id])->with('success', $message);
    }


    public function render()
    {
        return view('livewire.entries.project-grantees-view');
    }
}
