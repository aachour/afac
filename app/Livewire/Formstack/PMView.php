<?php

namespace App\Livewire\Formstack;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Models\FormStackGroups;
use App\Models\FormStackSubmissions;
use App\Models\FormStackAssigns;

class PMView extends Component
{

    use AuthorizesRequests; 

    public $pms = [];
    public $form_id;
    public $group_id;
    public $jurors=[];
    public $jurors_id;
    public $readers=[];
    public $readers_id;

    public $view_assignments = [];

    public $rate_group_id = null;
    public $rate_submission_id = null;
    public $submission_pm_status = null;
    public $submission_pm_notes = null;

    public function mount($formId)
    {
        $this->authorize('formstack-viewAssignedSubmissions');
        
        $this->form_id=$formId;

        $query = FormStackGroups::where('form_id', $formId);
        if (!auth()->user()->can('formstack-viewAssignedPM')) {
            $query->where('user_id', auth()->id());
        }
        $this->pms = $query->get();

        $this->jurors = User::role('Juror')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        $this->readers = User::role('Reader')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();
    }

    public function setGroupId($groupId,$type)
    {
        $this->group_id=$groupId;
        $formStackGroup= FormStackGroups::find($this->group_id);
        $this->jurors_id=json_decode($formStackGroup->jurors_id) ?? [];
        $this->readers_id=json_decode($formStackGroup->readers_id) ?? [];
        
        if($type=="Jurors")
        {
            $this->dispatch('jurors-loaded');
        }
        else if($type=="Readers")
        {
            $this->dispatch('readers-loaded');
        }
    }

    public function saveJurors()
    {   

        FormStackGroups::where('id', $this->group_id)
            ->update([
                'jurors_id' => json_encode($this->jurors_id),
            ]);

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Jurors assigned successfully!');
        
    }

    public function saveReaders()
    {   

        FormStackGroups::where('id', $this->group_id)
            ->update([
                'readers_id' => json_encode($this->readers_id),
            ]);

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Readers assigned done successfully!');
        
    }

    public function viewAssignments($groupId)
    {
        $this->group_id = $groupId;

        $group = FormStackGroups::find($groupId);
        $pmUserId = $group->user_id;

        $assignments = FormStackAssigns::where('group_id', $groupId)
            ->where('form_id', $this->form_id)
            ->get();

        $grouped = $assignments->groupBy('submission_id');

        $rows = $grouped->map(function ($items, $submissionId) {
            $jurors = $items->filter(fn($a) => $a->juror_id)
                ->map(function ($a) {
                    $user = User::find($a->juror_id);
                    return $user ? ['id' => $a->juror_id, 'name' => $user->first_name . ' ' . $user->last_name, 'form_type' => $a->form_type, 'assign_id' => $a->id] : null;
                })
                ->filter()
                ->unique('id')
                ->values();

            $readers = $items->filter(fn($a) => $a->reader_id)
                ->map(function ($a) {
                    $user = User::find($a->reader_id);
                    return $user ? ['id' => $a->reader_id, 'name' => $user->first_name . ' ' . $user->last_name, 'form_type' => $a->form_type, 'assign_id' => $a->id] : null;
                })
                ->filter()
                ->unique('id')
                ->values();

            return [
                'submission_id' => $submissionId,
                'admin_id'      => \App\Models\FormStackSubmissions::where('submission_id', $submissionId)->value('admin_id') ?? $submissionId,
                'jurors'        => $jurors->all(),
                'readers'       => $readers->all(),
            ];
        })->values();

        $this->view_assignments = $rows;

        $this->dispatch('view-assignments-loaded', rows: $rows, formId: $this->form_id, pmId: $pmUserId);
    }

    public function setRateSubmission($groupId, $submissionId)
    {
        $this->rate_group_id = $groupId;
        $this->rate_submission_id = $submissionId;

        $group = FormStackGroups::find($groupId);
        $statuses = json_decode($group->submissions_status ?? '{}', true) ?? [];
        $entry = $statuses[$submissionId] ?? null;
        $this->submission_pm_status = is_array($entry) ? ($entry['status'] ?? null) : $entry;
        $this->submission_pm_notes = is_array($entry) ? ($entry['notes'] ?? null) : null;
    }


    public function removeSubmissionFromGroup($groupId, $submissionId)
    {
        $group = FormStackGroups::find($groupId);
        if (!$group) return;

        $ids = array_values(array_filter(
            json_decode($group->submissions_id ?? '[]', true) ?? [],
            fn($id) => $id !== $submissionId
        ));
        $group->submissions_id = json_encode($ids);

        $statuses = json_decode($group->submissions_status ?? '{}', true) ?? [];
        unset($statuses[$submissionId]);
        $group->submissions_status = json_encode($statuses);

        $group->save();

        // Also remove any juror/reader assignments for this submission in this group
        FormStackAssigns::where('group_id', $groupId)
            ->where('form_id', $this->form_id)
            ->where('submission_id', $submissionId)
            ->delete();

        $this->pms = FormStackGroups::where('form_id', $this->form_id)
            ->when(!auth()->user()->can('formstack-viewAssignedPM'), fn($q) => $q->where('user_id', auth()->id()))
            ->get();

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Submission deleted successfully!');
    }

    public function deleteAssignment($submissionId, $type, $personId)
    {
        $query = FormStackAssigns::where('group_id', $this->group_id)
            ->where('form_id', $this->form_id)
            ->where('submission_id', $submissionId);

        if ($type === 'juror') {
            $query->where('juror_id', $personId);
        } else {
            $query->where('reader_id', $personId);
        }

        $query->delete();

        $this->viewAssignments($this->group_id);
    }

    public function render()
    {
        return view('livewire.formstack.p-m-view');
    }
}
