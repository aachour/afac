<?php

namespace App\Livewire\Formstack;


use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackForms;
use App\Models\FormStackSubmissions;
use App\Models\FormStackGroups;
use App\Models\FormStackAssigns;
use Spatie\Permission\Models\Role;

class SubmissionsView extends Component
{

use AuthorizesRequests; 

    public $submissions = [];
    public $assigns = [];
    public $selected_submissions = [];
    public $form_id;
    public $users;
    public $users_id;

    public $id;
    public $admin_notes;
    public $admin_status;
    

    public function mount($formId='')
    {
        $this->authorize('formstack-submissions');

        $this->form_id=$formId;
        
        if(Auth::user()->hasRole('Program Manager'))
        {
            $group = FormStackGroups::where('form_id', $this->form_id)
                ->where('user_id', Auth::id())
                ->first();

            $submissionIds = $group ? json_decode($group->submissions_id, true) : []; 

            $this->submissions = FormStackSubmissions::whereIn('submission_id', $submissionIds)->get();
        }
        else if(Auth::user()->hasRole('Juror'))
        {
            $this->assigns = FormStackAssigns::with('submission')
                ->where('juror_id', Auth::id())
                ->get();

            foreach($this->assigns as $assign){
                $submission=FormStackSubmissions::where('submission_id', $assign->submission_id)->first(); 
                if($submission){
                    $this->submissions[]=$submission;
                }
            }
        }
        else if(Auth::user()->hasRole('Reader')){
            $this->assigns = FormStackAssigns::with('submission')
                ->where('reader_id', Auth::id())
                ->get();

            foreach($this->assigns as $assign){
                $submission=FormStackSubmissions::where('submission_id', $assign->submission_id)->first(); 
                if($submission){
                    $this->submissions[]=$submission;
                }
            }

        }
        else
        {
            $this->submissions=FormStackSubmissions::WHERE('form_id',$this->form_id)->get();
        }

        $this->users = User::role('Program Manager')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        $this->dispatch('users-loaded'); 

    }

    public function fetchSubmissions(){ 

        $page = 1;
        $allSubmissions = [];

        // Load the form language to pick the correct name label
        $form = FormStackForms::where('form_id', $this->form_id)->first();
        $formLang = strtolower($form->form_lang ?? 'english');
        
        do {
            $response = Http::withToken(config('services.formstack.token'))
                ->acceptJson()
                ->get("https://www.formstack.com/api/v2/form/{$this->form_id}/submission.json", [
                    'data' => 1,
                    'page' => $page,
                ]);

            if (! $response->successful()) {
                dd($response->status(), $response->body());
            }

            $json = $response->json();

            // adjust this key if needed after one dd($json)
            $submissions = $json['submissions'] ?? [];

            $allSubmissions = array_merge($allSubmissions, $submissions);

            $page++;
        } while (! empty($submissions));

        foreach($allSubmissions as $submission){
            $submissionId=$submission["id"];

            //get data
            $data=$submission["data"]; 

            //extract email
            $email = collect($data)
            ->firstWhere('label', 'Contact email')['value'] ?? null;

             //extract email
            $name = collect($data)
            ->firstWhere('label', 'Full name')['value'] ?? null;

            //extract admin id
            $admin_id = collect($data)
            ->firstWhere('label', 'ID')['value'] ?? null;

            FormStackSubmissions::updateOrCreate(
                [
                    'submission_id' => $submissionId,
                ],
                [
                    'form_id' => $this->form_id,
                    'email' => $email,
                    'name' => $name,
                    'admin_id' => $admin_id,
                ]
            );

        }

        return redirect()->route('formstack.submissions',$this->form_id);

    }


    public function saveAssign(){
        $this->selected_submissions=json_encode($this->selected_submissions);
        
        // create/update current users
        foreach ($this->users_id as $user_id) {
            FormStackGroups::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'form_id' => $this->form_id,
                ],
                [
                    'submissions_id' => $this->selected_submissions,
                ]
            );
        }
        
        return to_route('formstack.forms')->with('success', 'Assigning done successfully!');

    }

    public function setSubmission($id){
        $this->id=$id;
        $submission=FormStackSubmissions::find($this->id);
        $this->admin_notes=$submission->admin_notes;
        $this->admin_status=$submission->admin_status;

    }

    public function saveRate(){

        FormStackSubmissions::where('id', $this->id)->update([
            'admin_status' => $this->admin_status,
            'admin_notes'  => $this->admin_notes,
        ]);

        return to_route('formstack.submissions',['formId'=>$this->form_id])->with('success', 'Action done successfully!');
    }


    public function render()
    {
        return view('livewire.formstack.submissions-view');
    }

}
