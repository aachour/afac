<?php

namespace App\Livewire\Entries;

use App\Models\Entries;
use App\Models\Types;
use App\Models\ProgramYears;
use App\Models\ProgramYearJurors;
use App\Models\ProgramYearProjects;

use Livewire\Attributes\On;

use Livewire\Component;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProgramYearsView extends Component
{

    use AuthorizesRequests; 

    public $years = [];
    
    public $showModal = false;
    public $modalTitle = 'Add Year';
    
    public $year = '';
    public $program_id;
    public $program_type_id;
    public $editingId = null;

    public $showModalJuror = false;
    public $modalJurorTitle = 'Add Juror';
    public $jurors;
    public $program_year_id;
    public $juror_id;

    public $showModalProject = false;
    public $modalProjectTitle = 'Add Project';
    public $projects;
    public $project_id;
    
    public function mount($programId)
    {   
        $this->authorize('section-list');
        $this->program_id=$programId;
        $this->loadYears();
    }

    public function loadYears()
    {
        $this->years = ProgramYears::WHERE('program_id',$this->program_id)->get();
    }

    public function openModal($yearId = null)
    {
        if ($yearId) {
            $year = ProgramYears::find($yearId);
            $this->editingId = $yearId;
            $this->year = $year->year;
            $this->modalTitle = 'Edit Year';
        } else {
            $this->reset(['editingId', 'year']);
            $this->modalTitle = 'Add Year';
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingId', 'year']);
    }

    public function saveYear()
    {
        
        $rules = [
            'program_id' => 'required',
            'year' => 'required',
        ];

        $this->validate($rules);

        if ($this->editingId) {
            $this->authorize('section-edit');
            $year = ProgramYears::find($this->editingId);
            $year->update(['year' => $this->year]);
            $message = 'Year updated successfully!';
        } else {
            $this->authorize('section-create');
            ProgramYears::create(['program_id' => $this->program_id,'year' => $this->year]);
            $message = 'Year added successfully!';
        }

        $this->closeModal();
        return to_route('entry.program.years',['programId'=>$this->program_id])->with('success', $message);
    }


    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('section-delete');

        $year = ProgramYears::find($id);

        $year->delete();

        $message = 'Year deleted successfully!';

        return to_route('entry.program.years',['programId'=>$this->program_id])->with('success', $message);
    }


    /*******************************************************************************/
    /*******************************************************************************/
    /*******************************************************************************/
    
    public function openJurorModal($yearId = null)
    {
        $this->program_year_id=$yearId;
        $this->showModalJuror = true;
        $this->jurors=Entries::WHERE('type_id','5')->ORDERBY('id','DESC')->get();
    }

    public function closeJurorModal()
    {
        $this->showModalJuror = false;
        $this->reset(['program_year_id', 'juror_id']); 
    }

    public function saveJuror(){

        $rules = [
            'program_year_id' => 'required',
            'juror_id' => 'required',
        ];

        $this->validate($rules);
        
        $this->authorize('section-create');

        $highestOrder = ProgramYearJurors::WHERE('program_year_id',$this->program_year_id)->max('list_order');

        ProgramYearJurors::create(['program_year_id' => $this->program_year_id , 'juror_id' => $this->juror_id , 'list_order' =>$highestOrder+1]);
        $message = 'Juror added successfully!';

        $this->closeJurorModal();
        return to_route('entry.program.years',['programId'=>$this->program_id])->with('success', $message);
        
    }

    /*******************************************************************************/
    /*******************************************************************************/
    /*******************************************************************************/
    
    public function openProjectModal($yearId = null)
    {
        $this->program_year_id=$yearId;
        $this->showModalProject = true;
        $this->projects=Entries::WHERE('type_id','3')->ORDERBY('id','DESC')->get();
    }

    public function closeProjectModal()
    {
        $this->showModalProject = false;
        $this->reset(['program_year_id', 'project_id']); 
    }

    public function saveProject(){

        $rules = [
            'program_year_id' => 'required',
            'project_id' => 'required',
        ];

        $this->validate($rules);
        
        $this->authorize('section-create');

        $highestOrder = ProgramYearProjects::WHERE('program_year_id',$this->program_year_id)->max('list_order');

        ProgramYearProjects::create(['program_year_id' => $this->program_year_id , 'project_id' => $this->project_id , 'list_order' =>$highestOrder+1]);
        $message = 'Project added successfully!';

        $this->closeProjectModal();
        return to_route('entry.program.years',['programId'=>$this->program_id])->with('success', $message);
        
    }

    /*******************************************************************************/
    /*******************************************************************************/
    /*******************************************************************************/

    public function render()
    {
        return view('livewire.entries.program-years-view');
    }
}
