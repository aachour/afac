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

    public $pm_group_id = null;
    public $pm_jurors = [];
    public $assign_juror_ids = [];
    public $assign_form_type = null;

    public $pm_readers = [];
    public $assign_reader_ids = [];
    public $assign_reader_form_type = null;

    public $submissionPMs = [];
    public $submissionJurors = [];
    public $submissionReaders = [];
    public $submissionStatuses = [];
    

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

            $this->submissions = FormStackSubmissions::whereIn('submission_id', $submissionIds)
                ->whereNull('deleted_at')
                ->get();

            $this->pm_group_id = $group?->id;
            $jurorIds = $group ? (json_decode($group->jurors_id, true) ?? []) : [];
            $this->pm_jurors = User::whereIn('id', $jurorIds)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();
            $readerIds = $group ? (json_decode($group->readers_id, true) ?? []) : [];
            $this->pm_readers = User::whereIn('id', $readerIds)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();

            if ($this->pm_group_id) {
                $statusMap = [];
                $submissionsStatus = json_decode($group->submissions_status, true) ?? [];
                foreach ($submissionsStatus as $sid => $entry) {
                    $statusMap[$sid] = [
                        'status' => is_array($entry) ? ($entry['status'] ?? null) : $entry,
                        'notes'  => is_array($entry) ? ($entry['notes'] ?? null) : null,
                    ];
                }
                $this->submissionStatuses = $statusMap;
            }

            if ($this->pm_group_id) {
                $jurorMap = [];
                $assigns = FormStackAssigns::where('group_id', $this->pm_group_id)
                    ->whereNotNull('juror_id')
                    ->get();
                foreach ($assigns as $assign) {
                    $jurorUser = User::find($assign->juror_id);
                    if (!$jurorUser) continue;
                    $jurorMap[$assign->submission_id][] = [
                        'pm_id' => $assign->group->user_id,
                        'assign_id' => $assign->id,
                        'name'      => trim($jurorUser->first_name . ' ' . $jurorUser->last_name),
                        'form_type' => $assign->form_type,
                    ];
                }
                $this->submissionJurors = $jurorMap;
            }

            if ($this->pm_group_id) {
                $readerMap = [];
                $readerAssigns = FormStackAssigns::where('group_id', $this->pm_group_id)
                    ->whereNotNull('reader_id')
                    ->get();
                foreach ($readerAssigns as $assign) {
                    $readerUser = User::find($assign->reader_id);
                    if (!$readerUser) continue;
                    $readerMap[$assign->submission_id][] = [
                        'pm_id' => $assign->group->user_id,
                        'assign_id' => $assign->id,
                        'name'      => trim($readerUser->first_name . ' ' . $readerUser->last_name),
                        'form_type' => $assign->form_type,
                    ];
                }
                $this->submissionReaders = $readerMap;
            }
        }
        else if(Auth::user()->hasRole('Juror'))
        {
            $this->assigns = FormStackAssigns::with(['submission','form', 'group.user'])
                ->where('juror_id', Auth::id())
                ->get();
        }
        else if(Auth::user()->hasRole('Reader')){
            $this->assigns = FormStackAssigns::with(['submission', 'form', 'group.user'])
                ->where('reader_id', Auth::id())
                ->get();
        }
        else
        {
            $this->submissions=FormStackSubmissions::where('form_id',$this->form_id)
                ->whereNull('deleted_at')
                ->get();

            $groups = FormStackGroups::where('form_id', $this->form_id)->get();
            $map = [];
            foreach ($groups as $group) {
                $ids = json_decode($group->submissions_id, true) ?? [];
                $pmUser = User::find($group->user_id);
                if (!$pmUser) continue;
                $pmName = trim($pmUser->first_name . ' ' . $pmUser->last_name);
                foreach ($ids as $sid) {
                    $map[$sid][] = ['name' => $pmName, 'group_id' => $group->id, 'user_id' => $group->user_id];
                }
            }
            $this->submissionPMs = $map;
        }

        $this->users = User::role('Program Manager')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        $this->dispatch('users-loaded'); 

    }

    ##############################################################################
    ##############################################################################
    ##############################################################################
    

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

            // get internal labels for juror
            $application_number = collect($data)
            ->firstWhere('internal_label', 'application_number')['value'] ?? null;

            $applicant_type = collect($data)
            ->firstWhere('internal_label', 'applicant_type')['value'] ?? null;

            $film_project_stage = collect($data)
            ->firstWhere('internal_label', 'film_project_stage')['value'] ?? null;

            $full_name = collect($data)
            ->firstWhere('internal_label', 'full_name')['value'] ?? null;

            $project_title = collect($data)
            ->firstWhere('internal_label', 'project_title')['value'] ?? null;

            $institution_name = collect($data)
            ->firstWhere('internal_label', 'institution_name')['value'] ?? null;
            
            $juror_internal_labels = [
                'application_number' => $application_number,
                'applicant_type' => $applicant_type,
                'film_project_stage' => $film_project_stage,
                'full_name' => $full_name,
                'project_title' => $project_title,
                'institution_name' => $institution_name,
            ];

            // Check if a non-deleted submission exists
            $submission = FormStackSubmissions::where('submission_id', $submissionId)
                ->whereNull('deleted_at')
                ->first();

            if ($submission) {
                // Update existing non-deleted submission
                $submission->update([
                    'form_id' => $this->form_id,
                    'email' => $email,
                    'name' => $name,
                    'admin_id' => $admin_id,
                    'juror_internal_labels' => $juror_internal_labels,
                ]);
            } else {
                // Create new submission (even if a deleted one exists with same submission_id)
                FormStackSubmissions::create([
                    'submission_id' => $submissionId,
                    'form_id' => $this->form_id,
                    'email' => $email,
                    'name' => $name,
                    'admin_id' => $admin_id,
                    'juror_internal_labels' => $juror_internal_labels,
                ]);
            }

        }

        return redirect()->route('formstack.submissions',$this->form_id);

    }

    ##############################################################################
    ##############################################################################
    ##############################################################################
    

    public function savePMAssign(){
        // create/update current users
        foreach ($this->users_id as $user_id) {
            $group = FormStackGroups::firstOrNew([
                'user_id' => $user_id,
                'form_id' => $this->form_id,
            ]);

            $existing = json_decode($group->submissions_id ?? '[]', true) ?? [];
            $merged   = array_values(array_unique(array_merge($existing, $this->selected_submissions)));

            $group->submissions_id = json_encode($merged);
            $group->save();
        }
        
        return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Submission(s) assigned successfully!');

    }


    public function saveSubmissionJurors()
    {
        $this->validate(
            [
                'assign_juror_ids'   => 'required|array|min:1',
                'assign_form_type'   => 'required',
                'selected_submissions' => 'required|array|min:1',
            ],
            [
                'assign_juror_ids.required'      => 'Please select at least one juror.',
                'assign_juror_ids.min'           => 'Please select at least one juror.',
                'assign_form_type.required'      => 'Please select a form type.',
                'selected_submissions.required'  => 'Please select at least one submission.',
                'selected_submissions.min'       => 'Please select at least one submission.',
            ]
        );

        foreach ($this->selected_submissions as $submissionId) {
            foreach ($this->assign_juror_ids as $jurorId) {
                $assign = FormStackAssigns::withTrashed()->updateOrCreate(
                    [
                        'group_id'      => $this->pm_group_id,
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

        $this->assign_juror_ids = [];
        $this->assign_form_type = null;

        return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Jurors assigned to submissions successfully!');
    }

    
    public function saveSubmissionReaders()
    {
        $this->validate(
            [
                'assign_reader_ids'    => 'required|array|min:1',
                'assign_reader_form_type' => 'required',
                'selected_submissions'  => 'required|array|min:1',
            ],
            [
                'assign_reader_ids.required'      => 'Please select at least one reader.',
                'assign_reader_ids.min'           => 'Please select at least one reader.',
                'assign_reader_form_type.required' => 'Please select a form type.',
                'selected_submissions.required'   => 'Please select at least one submission.',
                'selected_submissions.min'        => 'Please select at least one submission.',
            ]
        );

        foreach ($this->selected_submissions as $submissionId) {
            foreach ($this->assign_reader_ids as $readerId) {
                $assign = FormStackAssigns::withTrashed()->updateOrCreate(
                    [
                        'group_id'      => $this->pm_group_id,
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

        $this->assign_reader_ids = [];
        $this->assign_reader_form_type = null;

        return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Readers assigned to submissions successfully!');
    }

    ##############################################################################
    ##############################################################################
    ##############################################################################
    

    public function deletePMSubmission($groupId, $submissionId)
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

        FormStackAssigns::where('group_id', $groupId)
            ->where('submission_id', $submissionId)
            ->delete();

       return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Submission removed successfully!');
    }


    public function deleteJurorAssign($assignId)
    {
        FormStackAssigns::where('id', $assignId)
            ->where('group_id', $this->pm_group_id)
            ->delete();

        return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Juror assignment removed successfully!');
    }


    public function deleteReaderAssign($assignId)
    {
        FormStackAssigns::where('id', $assignId)
            ->where('group_id', $this->pm_group_id)
            ->delete();

        return to_route('formstack.submissions', ['formId' => $this->form_id])->with('success', 'Reader assignment removed successfully!');
    }


    ##############################################################################
    ##############################################################################
    ##############################################################################
    

    public function setAdminRate($id){
        $this->id=$id;
        $submission=FormStackSubmissions::find($this->id);
        $this->admin_notes=$submission->admin_notes;
        $this->admin_status=$submission->admin_status;
    }


    public function saveAdminRate(){

        FormStackSubmissions::where('id', $this->id)->update([
            'admin_status' => $this->admin_status,
            'admin_notes'  => $this->admin_notes,
        ]);

        return to_route('formstack.submissions',['formId'=>$this->form_id])->with('success', 'Action done successfully!');
    }

    ##############################################################################
    ##############################################################################
    ##############################################################################
    

    //Delete all submissions for the form - with confirmation
    public function clearSubmissions(){
        $this->authorize('formstack-formClearSubmissions');

        // get all submission ids for the form
        $submissionIds = FormStackSubmissions::where('form_id', $this->form_id)->pluck('submission_id');

        FormStackSubmissions::where('form_id', $this->form_id)->delete();
        FormStackGroups::where('form_id', $this->form_id)->delete();
        FormStackAssigns::whereIn('submission_id', $submissionIds)->delete();
        
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text'  => 'All submissions for this form have been deleted successfully!',
        ]);

        return to_route('formstack.submissions',['formId'=>$this->form_id]);
    }


    public function render()
    {
        return view('livewire.formstack.submissions-view');
    }

}
