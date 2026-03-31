<?php

namespace App\Livewire\Formstack;


use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\FormStackForms;
use App\Models\FormStackSubmissions;


class SubmissionsView extends Component
{

use AuthorizesRequests; 

    public $submissions = [];
    public $form_id;

    public function mount($formId)
    {
        $this->authorize('formstack-submissions');

        $this->form_id=$formId;
        
        $this->submissions=FormStackSubmissions::WHERE('form_id',$this->form_id)->get();

    }

    public function fetchSubmissions(){ 

        $page = 1;
        $allSubmissions = [];

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
            ->firstWhere('type', 'email')['value'] ?? null;

            FormStackSubmissions::updateOrCreate(
                [
                    'submission_id' => $submissionId,
                ],
                [
                    'form_id' => $this->form_id,
                    'email' => $email,
                ]
            );

        }

        return redirect()->route('formstack.submissions',$this->form_id);

    }

    public function render()
    {
        return view('livewire.formstack.submissions-view');
    }
}
