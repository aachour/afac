<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Program Managers List</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('formstack.forms') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pms as $pm)
                        <tr>
                            <td>{{ $pm->user->id }}</td>
                            <td>{{ $pm->user->first_name.' '.$pm->user->last_name }}</td>
                            <td>{{ $pm->user->email }}</td>
                            <td>{{ $pm->user->phone }}</td>
                            <td>
                                @can('formstack-viewAssignedJurors')
                                    <button wire:click="setGroupId({{ $pm->id }},'Jurors')" type="button" 
                                    data-bs-target="#assignJurorsModal" 
                                    data-bs-toggle="modal" 
                                    data-bs-title="Assign Jurors to PM"
                                    data-bs-placement="top"
                                    class="text-body view-user-button border-0 bg-transparent p-0">
                                        <i class="ti ti-users-plus ti-sm"></i>
                                    </button>
                                @endcan
                                @can('formstack-viewAssignedReaders')
                                    <button wire:click="setGroupId({{ $pm->id }},'Readers')" type="button" 
                                    data-bs-target="#assignReadersModal" 
                                    data-bs-toggle="modal" 
                                    data-bs-title="Assign Readers to PM"
                                    data-bs-placement="top"
                                    class="text-body view-user-button border-0 bg-transparent p-0">
                                    <i class="ti ti-user-check ti-sm"></i>
                                    </button>
                                @endcan
                                @can('formstack-submissionAssignView')
                                    <button wire:click="viewAssignments({{ $pm->id }})" type="button" 
                                    data-bs-target="#viewAssignmentsModal" 
                                    data-bs-toggle="modal" 
                                    data-bs-title="View Assignments"
                                    data-bs-placement="top"
                                    class="text-body view-user-button border-0 bg-transparent p-0">
                                        <i class="ti ti-list-details ti-sm"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div wire:ignore.self class="modal fade" id="assignJurorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Juror(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="jurors_id" class="form-label">Jurors</label>
                        <select id="jurors_id" class="form-control" multiple> 
                            @foreach($jurors as $juror)
                                <option value="{{ $juror->id }}">
                                    {{ $juror->first_name }} {{ $juror->last_name }}
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
                        wire:click="saveJurors"
                        wire:loading.attr="disabled"
                        wire:target="saveJurors"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveJurors">
                            {{ @$modalId ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="saveJurors">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assignReadersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Reader(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="readers_id" class="form-label">Readers</label>
                        <select id="readers_id" class="form-control" multiple> 
                            @foreach($readers as $reader)
                                <option value="{{ $reader->id }}">
                                    {{ $reader->first_name }} {{ $reader->last_name }}
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
                        wire:click="saveReaders"
                        wire:loading.attr="disabled"
                        wire:target="saveReaders"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveReaders">
                            {{ @$modalId ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="saveReaders">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="viewAssignmentsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submission Assignments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div wire:ignore>
                        <table id="assignmentsTable" class="table border-top" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Submission ID</th>
                                    <th>Jurors</th>
                                    <th>Readers</th>
                                </tr>
                            </thead>
                            <tbody id="assignmentsTableBody"></tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('jurors-loaded', () => {
            setTimeout(() => {
                let $el = $('#jurors_id');

                if (!$el.length) return;

                if ($el.hasClass('select2-hidden-accessible')) {
                    $el.off('change');
                    $el.select2('destroy');
                }

                $el.select2({
                    placeholder: 'Select Jurors',
                    width: '100%',
                    dropdownParent: $('#assignJurorsModal'),
                    closeOnSelect: false
                });

                // load selected values from Livewire
                let selectedValues = $wire.jurors_id || [];

                // select2 expects string values
                selectedValues = selectedValues.map(String);

                $el.val(selectedValues).trigger('change.select2');

                $el.on('change', function () {
                    $wire.set('jurors_id', $(this).val() || [], false);
                });
            }, 100);
        });

        $wire.on('readers-loaded', () => {
            setTimeout(() => {
                let $el = $('#readers_id');

                if (!$el.length) return;

                if ($el.hasClass('select2-hidden-accessible')) {
                    $el.off('change');
                    $el.select2('destroy');
                }

                $el.select2({
                    placeholder: 'Select Readers',
                    width: '100%',
                    dropdownParent: $('#assignReadersModal'),
                    closeOnSelect: false
                });

                // load selected values from Livewire
                let selectedValues = $wire.readers_id || [];

                // select2 expects string values
                selectedValues = selectedValues.map(String);

                $el.val(selectedValues).trigger('change.select2');

                $el.on('change', function () {
                    $wire.set('readers_id', $(this).val() || [], false);
                });
            }, 100);
        });

        let assignmentsDataTable = null;
        let currentFormId = null;
        let currentPmId = null;

        $wire.on('view-assignments-loaded', ({ rows, formId, pmId }) => {
            currentFormId = formId;
            currentPmId = pmId;
            setTimeout(() => {
                if (assignmentsDataTable) {
                    assignmentsDataTable.destroy();
                    assignmentsDataTable = null;
                }

                let $tbody = $('#assignmentsTableBody');
                $tbody.empty();

                rows.forEach(function (row) {
                    let sid = row.submission_id;
                    let displayId = row.admin_id || sid;

                    let jurorsList = row.jurors.length
                        ? row.jurors.map(j =>
                            '<span class="badge bg-label-primary me-1 assignment-badge" style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;" data-submission-id="' + sid + '" data-assign-id="' + (j.assign_id || '') + '" title="Click to view submission">' + j.name +
                            (j.form_type ? ' <small>(Form Type ' + j.form_type + ')</small>' : '') +
                            '</span>'
                        ).join('')
                        : '<span class="text-muted">—</span>';

                    let readersList = row.readers.length
                        ? row.readers.map(r =>
                            '<span class="badge bg-label-success me-1 assignment-badge" style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;" data-submission-id="' + sid + '" data-assign-id="' + (r.assign_id || '') + '" title="Click to view submission">' + r.name +
                            (r.form_type ? ' <small>(Form Type ' + r.form_type + ')</small>' : '') +
                            '</span>'
                        ).join('')
                        : '<span class="text-muted">—</span>';

                    $tbody.append(
                        '<tr>' +
                        '<td>' + displayId + '</td>' +
                        '<td>' + jurorsList + '</td>' +
                        '<td>' + readersList + '</td>' +
                        '</tr>'
                    );
                });

                assignmentsDataTable = $('#assignmentsTable').DataTable({
                    pageLength: 10,
                    order: [[0, 'asc']],
                    columnDefs: [{ targets: '_all', searchable: true }],
                });
            }, 100);
        });

        $('#assignmentsTable').on('click', '.assignment-badge', function (e) {
            // Don't navigate if clicking the delete button
            if ($(e.target).closest('.delete-assignment-btn').length) {
                return;
            }
            let submissionId = $(this).data('submission-id');
            let assignId = $(this).data('assign-id');
            if (currentFormId && submissionId && currentPmId) {
                let url = `/formstackSubmissionView/${currentFormId}/${submissionId}/${currentPmId}/${assignId}`;
                window.open(url, '_blank');
            } else {
                console.error('Missing required parameters', { formId: currentFormId, submissionId: submissionId, pmId: currentPmId, assignId: assignId });
            }
        });

        window.confirmRemoveSubmission = function (groupId, submissionId) {
            Swal.fire({
                title: 'Remove Submission?',
                text: 'This will remove the submission from this group along with any juror/reader assignments.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.removeSubmissionFromGroup(groupId, submissionId);
                }
            });
        };


    </script>
    @endscript

</div>
