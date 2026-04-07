<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Submissions List</h4>

                <div class="d-flex gap-2">
                    <a href="{{ route('formstack.forms') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                    <button type="button" wire:click="fetchSubmissions" class="btn btn-primary d-flex align-items-center">
                        Fetch Submissions
                    </button>
                    @can('formstack-formAssign')
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
                    <tr>
                        <th></th>
                        <th>Form ID</th>
                        <th>Submission ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            <td>
                                <input type="checkbox" wire:model="selected_submissions" value="{{ $submission->submission_id }}" />
                            </td>
                            <td>{{ $submission->form_id }}</td>
                            <td>{{ $submission->submission_id }}</td>
                            <td>{{ $submission->email }}</td>
                            <td>{{ $submission->admin_status }}</td>
                            <td>{{ $submission->admin_notes }}</td>
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
                                @can('formstack-submissionView')
                                    <a href="{{ route('formstack.submission', ['formId' => $submission->form_id,'submissionId' => $submission->submission_id]) }}" 
                                        target="_blank" 
                                        class="text-body view-user-button"
                                        data-bs-title="View Submission"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <i class="ti ti-eye ti-sm"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
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

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="admin_status" name="status" id="status_pending" value="pending">
                            <label class="form-check-label" for="status_pending">
                                Pending
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="admin_status" name="status" id="status_approved" value="approved">
                            <label class="form-check-label" for="status_approved">
                                Approved
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="admin_status" name="status" id="status_rejected" value="rejected">
                            <label class="form-check-label" for="status_rejected">
                                Rejected
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