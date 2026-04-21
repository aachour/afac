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

    public $assign_submissions = [];
    public $assign_jurors = [];
    public $assign_submission_ids = [];
    public $assign_juror_ids = [];
    public $assign_form_type = null;

    public $assign_readers_submissions = [];
    public $assign_readers = [];
    public $assign_reader_submission_ids = [];
    public $assign_reader_ids = [];
    public $assign_reader_form_type = null;

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

    public function assignJurors($groupId)
    {
        $this->group_id = $groupId;
        $group = FormStackGroups::find($groupId);

        $submissionIds = json_decode($group->submissions_id, true) ?? [];
        $jurorIds = json_decode($group->jurors_id, true) ?? [];
        $submissionsStatus = json_decode($group->submissions_status, true) ?? [];

        $this->assign_submissions = FormStackSubmissions::whereIn('submission_id', $submissionIds)
            ->get(['id', 'submission_id', 'email', 'admin_id']);

        $this->assign_jurors = User::whereIn('id', $jurorIds)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name']);

        $this->assign_submission_ids = [];
        $this->assign_juror_ids = [];
        $this->assign_form_type = null;

        $submissionsData = $this->assign_submissions->map(fn($s) => [
            'id'    => $s->submission_id,
            'label' => '#' . $s->admin_id . ' — ' . $s->email . ' / ' . $this->getSubmissionStatus($submissionsStatus, $s->submission_id),
        ])->values();

        $jurorsData = $this->assign_jurors->map(fn($j) => [
            'id'    => $j->id,
            'label' => $j->first_name . ' ' . $j->last_name,
        ])->values();

        $this->dispatch('submission-jurors-loaded', submissions: $submissionsData, jurors: $jurorsData);
    }

    private function getSubmissionStatus($submissionsStatus, $submissionId)
    {
        $statusEntry = $submissionsStatus[$submissionId] ?? null;
        $currentStatus = is_array($statusEntry) ? ($statusEntry['status'] ?? null) : $statusEntry;
        return $currentStatus ?? '—';
    }

    public function saveSubmissionJurors()
    {
        $this->validate(
            [
                'assign_submission_ids'   => 'required|array|min:1',
                'assign_juror_ids'        => 'required|array|min:1',
                'assign_form_type'        => 'required',
            ],
            [
                'assign_submission_ids.required' => 'Please select at least one submission.',
                'assign_submission_ids.min'      => 'Please select at least one submission.',
                'assign_juror_ids.required'      => 'Please select at least one juror.',
                'assign_juror_ids.min'           => 'Please select at least one juror.',
                'assign_form_type.required'      => 'Please select a form type.',
            ]
        );

        foreach ($this->assign_submission_ids as $submissionId) {
            foreach ($this->assign_juror_ids as $jurorId) {
                $assign = FormStackAssigns::withTrashed()->updateOrCreate(
                    [
                        'group_id'      => $this->group_id,
                        'form_id'       => $this->form_id,
                        'submission_id' => $submissionId,
                        'juror_id'      => $jurorId,
                    ],
                    [
                        'form_type' => $this->assign_form_type,
                    ]
                );

                if ($assign->trashed()) {
                    $assign->restore();
                }
            }
        }

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Jurors assigned to submissions successfully!');
    }

    public function assignReaders($groupId)
    {
        $this->group_id = $groupId;
        $group = FormStackGroups::find($groupId);

        $submissionIds = json_decode($group->submissions_id, true) ?? [];
        $readerIds = json_decode($group->readers_id, true) ?? [];
        $submissionsStatus = json_decode($group->submissions_status, true) ?? [];

        $this->assign_readers_submissions = FormStackSubmissions::whereIn('submission_id', $submissionIds)
            ->get(['id', 'submission_id', 'email' , 'admin_id']);

        $this->assign_readers = User::whereIn('id', $readerIds)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name']);

        $this->assign_reader_submission_ids = [];
        $this->assign_reader_ids = [];
        $this->assign_reader_form_type = null;

        $submissionsData = $this->assign_readers_submissions->map(fn($s) => [
            'id'    => $s->submission_id,
            'label' => '#' . $s->admin_id . ' — ' . $s->email . ' / ' . $this->getSubmissionStatus($submissionsStatus, $s->submission_id),
        ])->values();

        $readersData = $this->assign_readers->map(fn($r) => [
            'id'    => $r->id,
            'label' => $r->first_name . ' ' . $r->last_name,
        ])->values();

        $this->dispatch('submission-readers-loaded', submissions: $submissionsData, readers: $readersData);
    }

    public function saveSubmissionReaders()
    {
        $this->validate(
            [
                'assign_reader_submission_ids' => 'required|array|min:1',
                'assign_reader_ids'            => 'required|array|min:1',
                'assign_reader_form_type'      => 'required',
            ],
            [
                'assign_reader_submission_ids.required' => 'Please select at least one submission.',
                'assign_reader_submission_ids.min'      => 'Please select at least one submission.',
                'assign_reader_ids.required'            => 'Please select at least one reader.',
                'assign_reader_ids.min'                 => 'Please select at least one reader.',
                'assign_reader_form_type.required'      => 'Please select a form type.',
            ]
        );

        foreach ($this->assign_reader_submission_ids as $submissionId) {
            foreach ($this->assign_reader_ids as $readerId) {
                $assign = FormStackAssigns::withTrashed()->updateOrCreate(
                    [
                        'group_id'      => $this->group_id,
                        'form_id'       => $this->form_id,
                        'submission_id' => $submissionId,
                        'reader_id'     => $readerId,
                    ],
                    [
                        'form_type' => $this->assign_reader_form_type,
                    ]
                );

                if ($assign->trashed()) {
                    $assign->restore();
                }
            }
        }

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Readers assigned to submissions successfully!');

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

    public function deletePM($groupId)
    {
        $this->authorize('formstack-deleteAssignedPM');

        FormStackGroups::where('id', $groupId)
            ->where('form_id', $this->form_id)
            ->delete();

        return to_route('formstack.pm',['formId'=>$this->form_id])->with('success', 'Program Manager deleted successfully!');

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
