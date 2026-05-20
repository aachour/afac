<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackForms;
use App\Models\FormStackSubmissions;
use App\Models\FormStackAssigns;
use App\Models\FormStackGroups;
use Illuminate\Support\Facades\Auth;


class SubmissionView extends Component
{

    public array $fieldData = [];

    public $form_id;
    public $submission_id;
    public $pm_id;
    public $assign_id;
    public $assigned_to;
    public $formStackAssign;
    public $form_type;
    public $form_status = null;
    public $form_notes = null;
    public $pm_form_status = null;
    public $pm_form_notes = null;
    public $form_rate1 = null;
    public $form_rate2 = null;
    public $form_rate3 = null;
    public $form_rate4 = null;
    public $canView1 = false;
    public $canEdit1 = false;
    public $canEdit2 = false;

    public function mount($formId,$submissionId,$pmId = null,$assignId = null){

        $this->authorize('formstack-submissionView');

        $this->form_id = $formId;
        $this->submission_id = $submissionId;
        $this->pm_id = $pmId; 
        $this->assign_id = $assignId;

        if($this->pm_id){
        
            $formstackGroup = FormStackGroups::where('user_id', $this->pm_id)
                ->whereJsonContains('submissions_id', $this->submission_id)
                ->first();

            //get PM evaluation if exists
            if ($formstackGroup && $formstackGroup->submissions_status) {
                $submissionsStatus = is_string($formstackGroup->submissions_status) 
                    ? json_decode($formstackGroup->submissions_status, true) 
                    : $formstackGroup->submissions_status;
                
                if (is_array($submissionsStatus) && isset($submissionsStatus[$this->submission_id])) {
                    $this->pm_form_status = $submissionsStatus[$this->submission_id]['status'] ?? null;
                    $this->pm_form_notes = $submissionsStatus[$this->submission_id]['notes'] ?? null;
                }
            }
        }

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

            if($this->pm_id){

                $checkAssign = FormStackGroups::where('user_id', $this->pm_id)->whereJsonContains('submissions_id', $this->submission_id)
                    ->first();

                // Check if current user is the assigned Juror or Reader
                
                $currentUser = User::find($this->pm_id);
                $currentUserCanRate = $currentUser->can_rate;
                $this->canView1 = ($checkAssign->user_id == $currentUser->id && $this->pm_id != null);
                $this->canEdit1 = ($checkAssign->user_id == $currentUser->id && $currentUserCanRate);

                if (!$checkAssign) {
                    abort(403, 'Unauthorized');
                }
            }

        } 
        else if(Auth::user()->hasrole('Admin') && $this->pm_id!=null){
            $this->canView1 = true;
        }


        if ($this->assign_id) {
            $this->formStackAssign = FormStackAssigns::find($this->assign_id);
            $this->form_type = $this->formStackAssign->form_type ?? null;
            $this->form_status = $this->formStackAssign->form_status ?? null;
            $this->form_notes = $this->formStackAssign->form_notes ?? null;
            $this->form_rate1 = $this->formStackAssign->form_rate1 ?? null;
            $this->form_rate2 = $this->formStackAssign->form_rate2 ?? null;
            $this->form_rate3 = $this->formStackAssign->form_rate3 ?? null;
            $this->form_rate4 = $this->formStackAssign->form_rate4 ?? null;

            if($this->formStackAssign->juror_id!=null){$this->assigned_to="Juror";}
            else if($this->formStackAssign->reader_id!=null){$this->assigned_to="Reader";}

            // Check if current user is the assigned Juror or Reader
            $currentUserId = Auth::id();
            $currentUserCanRate = Auth::user()->can_rate;
            $this->canEdit2 = ( ($this->formStackAssign->juror_id == $currentUserId || $this->formStackAssign->reader_id == $currentUserId) && $currentUserCanRate );
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
            $type = $field['type'] ?? null;

            $value = $submittedValues[$fieldId] ?? null;

            // Always include section headers; for non-admins skip other fields with no value
            $isSection = ($type === 'section');
            if (!Auth::user()->hasrole('Admin') && is_null($value) && !$isSection) {
                continue;
            }

            $fieldData[] = [
                'field_id'      => $fieldId,
                'label'         => $field['label']
                    ?? $field['name']
                    ?? $field['title']
                    ?? "Field #{$fieldId}",
                'section_heading'  => $field['section_heading'] ?? null,
                'value'         => $value,
                'type'          => $type,
            ];
        }

        // Remove section entries that have no filled fields beneath them
        $filtered = [];
        foreach ($fieldData as $index => $item) {
            if ($item['type'] === 'section') {
                $hasFields = false;
                for ($i = $index + 1; $i < count($fieldData); $i++) {
                    if ($fieldData[$i]['type'] === 'section') break;
                    if (!is_null($fieldData[$i]['value']) && $fieldData[$i]['value'] !== '') {
                        $hasFields = true;
                        break;
                    }
                }
                if (!$hasFields) continue;
            }
            $filtered[] = $item;
        }

        $this->fieldData = $filtered;

        // dd($this->fieldData);

    }   

    public function savePmRating()
    {
        $this->validate(
            ['pm_form_status' => 'required'],
            ['pm_form_status.required' => 'Please select a status.']
        );

        $submissionKey = $this->normalizeSubmissionKey($this->submission_id);
        if ($submissionKey === null) {
            return;
        }

        $group = FormStackGroups::where('user_id', Auth::id())
            ->whereJsonContains('submissions_id', $submissionKey)
            ->first();

        if ($group) {
            $rawStatus = $group->submissions_status ?? [];
            $status = is_string($rawStatus)
                ? (json_decode($rawStatus, true) ?: [])
                : (is_array($rawStatus) ? $rawStatus : []);

            $status[$submissionKey] = [
                'status' => $this->pm_form_status,
                'notes' => $this->pm_form_notes,
            ];
            $group->update(['submissions_status' => $status]);
        }

        return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Rating added successfully!');

        // $this->dispatch('rating-saved');
    }

    public function saveJRRating()
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
        } elseif ($this->form_type == 2) {
            $this->validate(
                [
                    'form_rate1' => 'required|integer|min:1|max:4',
                    'form_rate2' => 'required|integer|min:1|max:4',
                    'form_rate3' => 'required|integer|min:1|max:2',
                ],
                [
                    'form_rate1.required' => 'Please answer question 1.',
                    'form_rate2.required' => 'Please answer question 2.',
                    'form_rate3.required' => 'Please answer question 3.',
                ]
            );

            FormStackAssigns::where('id', $this->assign_id)->update([
                'form_rate1' => $this->form_rate1,
                'form_rate2' => $this->form_rate2,
                'form_rate3' => $this->form_rate3,
                'form_notes' => $this->form_notes,
            ]);
        }
        elseif ($this->form_type == 3) {
            $this->validate(
                [
                    'form_rate1' => 'required|integer|min:1|max:4',
                    'form_rate2' => 'required|integer|min:1|max:4',
                    'form_rate3' => 'required|integer|min:1|max:2',
                    'form_rate4' => 'required|integer|min:0|max:1',
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

        return to_route('formstack.submissions')->with('success', 'Rating added successfully!');

        //$this->dispatch('rating-saved');
    }

    
    public function render()
    {
        return view('livewire.formstack.submission-view');
    }

    private function normalizeSubmissionKey($value): ?string
    {
        while (is_array($value)) {
            if (empty($value)) {
                return null;
            }

            $value = reset($value);
        }

        if (is_object($value) && !method_exists($value, '__toString')) {
            return null;
        }

        $key = trim((string) $value);

        return $key !== '' ? $key : null;
    }
}
