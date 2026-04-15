<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\FormStackForms;
use App\Models\FormStackSubmissions;
use App\Models\FormStackAssigns;
use Illuminate\Support\Facades\Auth;


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
    public $form_rate1 = null;
    public $form_rate2 = null;
    public $form_rate3 = null;
    public $form_rate4 = null;
    public $canEdit = false;

    public function mount($formId,$submissionId,$assignId = null){

        $this->authorize('formstack-submissionView');

        $this->form_id = $formId;
        $this->submission_id = $submissionId;
        $this->assign_id = $assignId;

        //make sure the user has access to view this submission based on the assignId

        if(Auth::user()->hasrole('Juror')){ //check submission assigned to juror
            $checkAssign=FormStackAssigns::WHERE('id',$this->assign_id)->WHERE('juror_id',Auth::id())->first();
            if(!$checkAssign){
                abort(403,'Unauthorized'); 
            }
        } 
        else if(Auth::user()->hasrole('Reader')){ //check submission assigned to reader
            $checkAssign=FormStackAssigns::WHERE('id',$this->assign_id)->WHERE('reader_id',Auth::id())->first();
            if(!$checkAssign){
                abort(403,'Unauthorized'); 
            }
        } 
        else if(Auth::user()->hasrole('Program Manager')){ //check submission assigned to pm
            $checkAssign = FormStackAssigns::where('id', $this->assign_id)
                ->whereHas('group', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->first();

            if (!$checkAssign) {
                abort(403, 'Unauthorized');
            }
        } 


        if ($assignId) {
            $this->formStackAssign = FormStackAssigns::find($assignId);
            $this->form_type = $this->formStackAssign->form_type ?? null;
            $this->form_status = $this->formStackAssign->form_status ?? null;
            $this->form_notes = $this->formStackAssign->form_notes ?? null;
            $this->form_rate1 = $this->formStackAssign->form_rate1 ?? null;
            $this->form_rate2 = $this->formStackAssign->form_rate2 ?? null;
            $this->form_rate3 = $this->formStackAssign->form_rate3 ?? null;
            $this->form_rate4 = $this->formStackAssign->form_rate4 ?? null;

            // Check if current user is the assigned Juror or Reader
            $currentUserId = Auth::id();
            $this->canEdit = ($this->formStackAssign->juror_id == $currentUserId || $this->formStackAssign->reader_id == $currentUserId);
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

        if ($this->form_type == 1) {
            $this->validate(
                ['form_status' => 'required'],
                ['form_status.required' => 'Please select a status.']
            );

            FormStackAssigns::where('id', $this->assign_id)->update([
                'form_status' => $this->form_status,
                'form_notes'  => $this->form_notes,
            ]);
        } elseif ($this->form_type == 2 || $this->form_type == 3) {
            $this->validate(
                [
                    'form_rate1' => 'required|integer|min:1|max:4',
                    'form_rate2' => 'required|integer|min:1|max:4',
                    'form_rate3' => 'required|integer|min:1|max:2',
                    'form_rate4' => 'required|integer|min:1|max:2',
                ],
                [
                    'form_rate1.required' => 'Please answer question 1.',
                    'form_rate2.required' => 'Please answer question 2.',
                    'form_rate3.required' => 'Please answer question 3.',
                    'form_rate4.required' => 'Please answer question 4.',
                ]
            );

            FormStackAssigns::where('id', $this->assign_id)->update([
                'form_rate1' => $this->form_rate1,
                'form_rate2' => $this->form_rate2,
                'form_rate3' => $this->form_rate3,
                'form_rate4' => $this->form_rate4,
                'form_notes' => $this->form_notes,
            ]);
        }

        $this->dispatch('rating-saved');
    }

    public function render()
    {
        return view('livewire.formstack.submission-view');
    }
}
