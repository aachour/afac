<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\FormStackForms;

class FormsView extends Component
{

    use AuthorizesRequests; 

    public $forms = [];

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

    }
    

    public function render()
    {
        return view('livewire.formstack.forms-view');
    }

}
