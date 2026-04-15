<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Submissions List</h4>

                <div class="d-flex gap-2">
                    @if(!Auth::user()->hasRole('Juror') && !Auth::user()->hasRole('Reader'))
                    <a href="{{ route('formstack.forms') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                    @endif
                    @can('formstack-formFetchSubmissions')
                    <button type="button" wire:click="fetchSubmissions" class="btn btn-primary d-flex align-items-center">
                        Fetch Submissions
                    </button>
                    @endcan
                    @can('formstack-formAssignPM')
                        <button type="button" 
                        data-bs-target="#assignModal" 
                        data-bs-toggle="modal" 
                        class="btn btn-primary d-flex align-items-center">
                            Assign Program Manager(s)
                        </button>
                    @endcan
                </div>
                
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    @if(Auth::user()->hasRole('Juror') || Auth::user()->hasRole('Reader'))
                    <tr>
                        <th>ID</th>
                        <th>Form ID</th>
                        <th>Submission ID</th>
                        <th>Admin ID</th>
                        <th>Email</th>
                        <!-- <th>Name</th> -->
                        <th>Assigned By PM</th>
                        <th>Action</th>
                    </tr>
                    @else
                    <tr>
                        @can('formstack-formAssignPM')
                        <th></th>
                        @endcan
                        <th>Form ID</th>
                        <th>Submission ID</th>
                        <th>Admin ID</th>
                        <th>Email</th>
                        <!-- <th>Name</th> -->
                        @can('formstack-formAssignPM')
                        <th>Admin Status</th>
                        <th>Admin Notes</th>
                        @endcan
                        <th>Action</th>
                    </tr>
                    @endif
                    </thead>
                    <tbody>
                    @if(Auth::user()->hasRole('Juror') || Auth::user()->hasRole('Reader'))
                        @foreach($assigns as $assign)
                            <tr>
                                <td>{{ $assign->id }}</td>
                                <td>{{ $assign->submission->form_id }}</td>
                                <td>{{ $assign->submission->submission_id }}</td>
                                <td>{{ $assign->submission->admin_id }}</td>
                                <td>{{ $assign->submission->email }}</td>
                                <!-- <td>{{ $assign->submission->name }}</td> -->
                                <td>{{ $assign->group?->user ? trim($assign->group->user->first_name . ' ' .$assign->group->user->last_name): null; }}</td>
                                <td>
                                    <a href="{{ route('formstack.submission', ['formId' => $assign->submission->form_id,'submissionId' => $assign->submission->submission_id , 'assignId' => $assign->id]) }}" 
                                        target="_blank" 
                                        class="text-body view-user-button"
                                        data-bs-title="View Submission"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <i class="ti ti-eye ti-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach($submissions as $submission)
                            <tr>
                                @can('formstack-formAssignPM')
                                <td>
                                    <input type="checkbox" wire:model="selected_submissions" value="{{ $submission->submission_id }}" />
                                </td>
                                @endcan
                                <td>{{ $submission->form_id }}</td>
                                <td>{{ $submission->submission_id }}</td>
                                <td>{{ $submission->admin_id }}</td>
                                <td>{{ $submission->email }}</td>
                                <!-- <td>{{ $submission->name }}</td> -->
                                @can('formstack-formAssignPM')
                                <td>{{ $submission->admin_status }}</td>
                                <td>{{ $submission->admin_notes }}</td>
                                @endcan
                                <td>
                                    @can('formstack-submissionRate')
                                        <button wire:click="setSubmission({{ $submission->id }})" type="button" 
                                        data-bs-target="#rateModal" 
                                        data-bs-toggle="modal" 
                                        data-bs-title="Rate Submission"
                                        data-bs-placement="top"
                                        class="text-body view-user-button border-0 bg-transparent p-0">
                                            <i class="ti ti-star ti-sm"></i>
                                        </button>
                                    @endcan
                                    <a href="{{ route('formstack.submission', ['formId' => $submission->form_id,'submissionId' => $submission->submission_id]) }}" 
                                        target="_blank" 
                                        class="text-body view-user-button"
                                        data-bs-title="View Submission"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <i class="ti ti-eye ti-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div wire:ignore.self class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Program Manager(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="users_id" class="form-label">Users</label>
                        <select id="users_id" class="form-control" multiple> 
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="saveAssign"
                        wire:loading.attr="disabled"
                        wire:target="saveAssign"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveAssign">
                            {{ @$modalId ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="saveAssign">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="rateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Admin Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3"></label>
                        <label for="notes" class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="admin_status" name="status" id="status_later" value="later">
                            <label class="form-check-label" for="status_later">
                                Later
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="admin_status" name="status" id="status_yes" value="yes">
                            <label class="form-check-label" for="status_yes">
                                Yes
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="admin_status" name="status" id="status_no" value="no">
                            <label class="form-check-label" for="status_no">
                                No
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea
                            id="notes"
                            class="form-control"
                            wire:model="admin_notes"
                            rows="4"
                            placeholder="Enter notes here..."
                        ></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="saveRate"
                        wire:loading.attr="disabled"
                        wire:target="saveRate"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveRate">
                            {{ @$modalId ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="saveRate">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('users-loaded', () => {
            setTimeout(() => {
                let $el = $('#users_id');

                if (!$el.length) return;

                if ($el.hasClass('select2-hidden-accessible')) {
                    $el.off('change');
                    $el.select2('destroy');
                }

                $el.select2({
                    placeholder: 'Select Users',
                    width: '100%',
                    dropdownParent: $('#assignModal'),
                    closeOnSelect: false
                });

                $el.on('change', function () {
                    $wire.set('users_id', $(this).val() || [], false);
                });
            }, 100);
        });
    </script>
    @endscript

</div>