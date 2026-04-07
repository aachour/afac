<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackForms;
use App\Models\FormStackSubmissions;
use App\Models\FormStackGroups;
use Spatie\Permission\Models\Role;


class FormsView extends Component
{

    use AuthorizesRequests; 

    public $forms = [];

    public $form_id = '';
    public $users_id = '';
    public $users = [];
    public $roles = [];

    public function mount()
    {
        $this->authorize('formstack-forms');
        
        $response = Http::withToken(config('services.formstack.token'))
            ->acceptJson()
            ->get('https://www.formstack.com/api/v2/form.json');

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to fetch forms',
                'details' => $response->json()
            ], $response->status());
        }


        $data = $response->json();
        
        // Normalize the result
        $forms = collect($data['forms'] ?? [])
            ->map(fn ($form) => [
                'id'                    => $form['id'],
                'name'                  => $form['name'],
                'language'              => $form['language'],
                'submissions'           => $form['submissions'],
                'is_workflow_form'      => $form['is_workflow_form'],
                'is_workflow_published' => $form['is_workflow_published'],
                'created_at'  => $form['created'] ?? null,
                'updated_at'  => $form['updated'] ?? null,
            ])
        ->values();

        foreach($forms as $form){

            //get submissions
            $formId=$form["id"];
            $formName=$form["name"];
            $formLang=$form["language"];
            $formSubmissions=$form["submissions"];
            $formWorkflow=$form["is_workflow_form"];
            $formPublished=$form["is_workflow_published"];
            $formDateCreate=$form["created_at"];
            $formDateUpdate=$form["updated_at"];

            FormStackForms::updateOrCreate(
                ['form_id' => $formId], // check if this exists
                [
                    'form_name'                  => $formName,
                    'form_lang'              => $formLang,
                    'form_submissions'           => $formSubmissions,
                    'form_is_workflow_form'      => $formWorkflow,
                    'form_is_workflow_published' => $formPublished,
                    'form_created_at'     => $formDateCreate,
                    'form_updated_at'     => $formDateUpdate,
                ]
            );

        }

        $this->forms=FormStackForms::all();
        
        $this->users = User::role('Program Manager')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        
    }

    
    public function setFormId($formId)
    {
        $this->form_id=$formId;

        //get all form submission as json
        $submissionIds = FormStackSubmissions::where('form_id', $this->form_id)
            ->pluck('submission_id')
            ->map(fn ($id) => (string) $id)
            ->sort()
            ->values()
            ->all();

        $this->users_id = FormStackGroups::where('form_id', $this->form_id)
            ->get()
            ->filter(function ($group) use ($submissionIds) {
                $stored = collect(json_decode($group->submissions_id, true) ?? [])
                    ->map(fn ($id) => (string) $id)
                    ->sort()
                    ->values()
                    ->all();

                return $stored === $submissionIds;
            })
            ->pluck('user_id')
            ->values()
            ->toArray();


        $this->dispatch('users-loaded'); 
    }


    public function saveAssign()
    {
        //get all submissions for this form
        $submissionIdsJson = FormStackSubmissions::where('form_id', $this->form_id)
            ->pluck('submission_id')
            ->values()
            ->toJson();

        $newUserIds = collect($this->users_id)->unique()->values();

        // existing user_ids for this form
        $existingUserIds = FormStackGroups::where('form_id', $this->form_id)
            ->pluck('user_id');

        // users removed from selection
        $userIdsToDelete = $existingUserIds->diff($newUserIds);

        // delete removed users
        FormStackGroups::where('form_id', $this->form_id)
            ->whereIn('user_id', $userIdsToDelete)
            ->delete();

        // create/update current users
        foreach ($newUserIds as $user_id) {
            FormStackGroups::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'form_id' => $this->form_id,
                ],
                [
                    'submissions_id' => $submissionIdsJson,
                ]
            );
        }
        
        return to_route('formstack.forms')->with('success', 'Assigning done successfully!');
        
    }
    

    public function render()
    {
        return view('livewire.formstack.forms-view');
    }

}
