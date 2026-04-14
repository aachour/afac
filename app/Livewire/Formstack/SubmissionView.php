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
    public $form_status = null;
    public $form_notes = null;

    public function mount($formId,$submissionId,$assignId = null){

        $this->authorize('formstack-submissionView');

        $this->form_id = $formId;
        $this->submission_id = $submissionId;
        $this->assign_id = $assignId;

        if ($assignId) {
            $this->formStackAssign = FormStackAssigns::find($assignId);
            $this->form_type = $this->formStackAssign->form_type ?? null;
            $this->form_status = $this->formStackAssign->form_status ?? null;
            $this->form_notes = $this->formStackAssign->form_notes ?? null;
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

    public function saveRating()
    {
        if (!$this->assign_id) return;

        $this->validate(
            ['form_status' => 'required'],
            ['form_status.required' => 'Please select a status.']
        );

        FormStackAssigns::where('id', $this->assign_id)->update([
            'form_status' => $this->form_status,
            'form_notes'  => $this->form_notes,
        ]);

        $this->dispatch('rating-saved');
    }

    public function render()
    {
        return view('livewire.formstack.submission-view');
    }
}
