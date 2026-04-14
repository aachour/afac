<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\FormStackForms;
use App\Models\FormStackSubmissions;
use App\Models\FormStackAssigns;


class SubmissionView extends Component
{

    public array $fieldData = [];

    public $form_id;
    public $submission_id;
    public $assign_id;
    public $formStackAssign;
    public $form_type;

    public function mount($formId,$submissionId,$assignId = null){

        $this->authorize('formstack-submissionView');

        $this->form_id = $formId;
        $this->submission_id = $submissionId;
        $this->assign_id = $assignId;

        if ($assignId) {
            $this->formStackAssign = FormStackAssigns::find($assignId);
            $this->form_type = $this->formStackAssign->form_type ?? null;
        }

        $submission = Http::withToken(config('services.formstack.token'))
            ->get("https://www.formstack.com/api/v2/submission/{$submissionId}.json")
            ->json();

        $realFormId = $submission['form_id'] ?? $formId;

        if (!$realFormId) {
            $this->fieldData = [];
            return;
        }

        $form = Http::withToken(config('services.formstack.token'))
            ->get("https://www.formstack.com/api/v2/form/{$realFormId}.json")
            ->json();

        // Build submitted values indexed by field id
        $submittedValues = [];
        foreach (($submission['data'] ?? []) as $item) {
            $fieldId = (string) ($item['field'] ?? '');
            $submittedValues[$fieldId] = $item['value'] ?? null;
        }

        // Build all form fields with matching submitted values
        $fieldData = [];
        foreach (($form['fields'] ?? []) as $field) {
            $fieldId = (string) ($field['id'] ?? '');

            $fieldData[] = [
                'field_id' => $fieldId,
                'label' => $field['label']
                    ?? $field['name']
                    ?? $field['title']
                    ?? "Field #{$fieldId}",
                'value' => $submittedValues[$fieldId] ?? null,
                'type'  => $field['type'] ?? null,
            ];
        }

        $this->fieldData = $fieldData;

    }

    public function render()
    {
        return view('livewire.formstack.submission-view');
    }
}
