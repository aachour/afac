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
                        <th>Assigned Submissions</th>
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
                                @php
                                    $submissionIds = json_decode($pm->submissions_id, true) ?? [];
                                    $submissionStatus = json_decode($pm->submissions_status, true) ?? [];
                                    
                                @endphp

                                @foreach($submissionIds as $submissionId)
                                    @php
                                        $submission = \App\Models\FormStackSubmissions::where('submission_id', $submissionId)->first();
                                    @endphp
                                    @php
                                        $submissionsStatus = json_decode($pm->submissions_status, true) ?? [];
                                        $statusEntry = $submissionsStatus[$submissionId] ?? null;
                                        $currentStatus = is_array($statusEntry) ? ($statusEntry['status'] ?? null) : $statusEntry;
                                    @endphp
                                    <div class="d-flex align-items-center gap-1">-{{ $submission?->admin_id ?? '—' }}/{{$submission?->email ?? '—' }} / <span class="{{ $currentStatus === 'yes' ? 'text-success' : ($currentStatus === 'maybe' ? 'text-warning' : ($currentStatus === 'no' ? 'text-danger' : '')) }}">{{$currentStatus ?? '—'}}</span>&nbsp;<a href="{{ route('formstack.submission', ['formId' => $pm->form_id , 'submissionId' => $submissionId , 'pmId' => $pm->user->id ]) }}" target="_blank"><i class="ti ti-eye ti-sm text-body"></i></a>
                                    @can('formstack-formAssignPM')
                                        &nbsp;<button type="button" onclick="confirmRemoveSubmission({{ $pm->id }}, '{{ $submissionId }}')" class="border-0 bg-transparent p-0 text-danger"><i class="ti ti-x ti-sm"></i></button>
                                    @endcan
                                    </div>
                                @endforeach
                            </td>
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
                                @can('formstack-submissionAssignJurors')
                                    <button wire:click="assignJurors({{ $pm->id }})" type="button" 
                                    data-bs-target="#assignSubmissionsJurorsModal" 
                                    data-bs-toggle="modal" 
                                    data-bs-title="Assign Jurors to Submissions"
                                    data-bs-placement="top"
                                    class="text-body view-user-button border-0 bg-transparent p-0">
                                        <i class="ti ti-gavel ti-sm"></i>

                                    </button>
                                @endcan
                                @can('formstack-submissionAssignReaders')
                                    <button wire:click="assignReaders({{ $pm->id }})" type="button" 
                                    data-bs-target="#assignSubmissionsReadersModal" 
                                    data-bs-toggle="modal" 
                                    data-bs-title="Assign Readers to Submissions"
                                    data-bs-placement="top"
                                    class="text-body view-user-button border-0 bg-transparent p-0">
                                        <i class="ti ti-eyeglass ti-sm"></i>
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
                                @can('formstack-deleteAssignedPM')
                                    <button type="button"
                                    data-bs-title="Delete PM"
                                    data-bs-placement="top"
                                    onclick="confirmDeletePM({{ $pm->id }})"
                                    class="text-danger view-user-button border-0 bg-transparent p-0">
                                        <i class="ti ti-trash ti-sm"></i>
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

    <div wire:ignore.self class="modal fade" id="assignSubmissionsJurorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Juror(s) to Submission(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="assign_submission_ids" class="form-label">Submissions</label>
                        <select id="assign_submission_ids" class="form-control" multiple></select>
                    </div>

                    <div class="mb-3" wire:ignore>
                        <label for="assign_juror_ids" class="form-label">Jurors</label>
                        <select id="assign_juror_ids" class="form-control" multiple></select>
                    </div>

                    <div class="mb-3">
                        <label for="assign_form_type" class="form-label">Form Type</label>
                        <select id="assign_form_type" class="form-control" wire:model="assign_form_type">
                            <option value="">Form Type</option>
                            <option value="1">Type 1</option>
                            <option value="2">Type 2</option>
                            <option value="3">Type 3</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="saveSubmissionJurors"
                        wire:loading.attr="disabled"
                        wire:target="saveSubmissionJurors"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveSubmissionJurors">
                            Save
                        </span>
                        <span wire:loading wire:target="saveSubmissionJurors">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assignSubmissionsReadersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Reader(s) to Submission(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="assign_reader_submission_ids" class="form-label">Submissions</label>
                        <select id="assign_reader_submission_ids" class="form-control" multiple></select>
                    </div>

                    <div class="mb-3" wire:ignore>
                        <label for="assign_reader_ids" class="form-label">Readers</label>
                        <select id="assign_reader_ids" class="form-control" multiple></select>
                    </div>

                    <div class="mb-3">
                        <label for="assign_reader_form_type" class="form-label">Form Type</label>
                        <select id="assign_reader_form_type" class="form-control" wire:model="assign_reader_form_type">
                            <option value="">Form Type</option>
                            <option value="1">Type 1</option>
                            <option value="2">Type 2</option>
                            <option value="3">Type 3</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="saveSubmissionReaders"
                        wire:loading.attr="disabled"
                        wire:target="saveSubmissionReaders"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveSubmissionReaders">
                            Save
                        </span>
                        <span wire:loading wire:target="saveSubmissionReaders">
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

        $wire.on('submission-jurors-loaded', ({ submissions, jurors }) => {
            setTimeout(() => {
                let $subs = $('#assign_submission_ids');
                let $jurors = $('#assign_juror_ids');

                [$subs, $jurors].forEach(function ($el) {
                    if (!$el.length) return;
                    if ($el.hasClass('select2-hidden-accessible')) {
                        $el.off('change');
                        $el.select2('destroy');
                    }
                    $el.empty();
                });

                submissions.forEach(function (s) {
                    $subs.append(new Option(s.label, s.id, false, false));
                });

                jurors.forEach(function (j) {
                    $jurors.append(new Option(j.label, j.id, false, false));
                });

                $subs.select2({
                    placeholder: 'Select Submissions',
                    width: '100%',
                    dropdownParent: $('#assignSubmissionsJurorsModal'),
                    closeOnSelect: false
                });

                $jurors.select2({
                    placeholder: 'Select Jurors',
                    width: '100%',
                    dropdownParent: $('#assignSubmissionsJurorsModal'),
                    closeOnSelect: false
                });

                $subs.val([]).trigger('change.select2');
                $jurors.val([]).trigger('change.select2');

                $subs.on('change', function () {
                    $wire.set('assign_submission_ids', $(this).val() || [], false);
                });

                $jurors.on('change', function () {
                    $wire.set('assign_juror_ids', $(this).val() || [], false);
                });
            }, 100);
        });

        $wire.on('close-submission-jurors-modal', () => {
            let modal = bootstrap.Modal.getInstance(document.getElementById('assignSubmissionsJurorsModal'));
            if (modal) modal.hide();
        });

        $wire.on('submission-readers-loaded', ({ submissions, readers }) => {
            setTimeout(() => {
                let $subs = $('#assign_reader_submission_ids');
                let $readers = $('#assign_reader_ids');

                [$subs, $readers].forEach(function ($el) {
                    if (!$el.length) return;
                    if ($el.hasClass('select2-hidden-accessible')) {
                        $el.off('change');
                        $el.select2('destroy');
                    }
                    $el.empty();
                });

                submissions.forEach(function (s) {
                    $subs.append(new Option(s.label, s.id, false, false));
                });

                readers.forEach(function (r) {
                    $readers.append(new Option(r.label, r.id, false, false));
                });

                $subs.select2({
                    placeholder: 'Select Submissions',
                    width: '100%',
                    dropdownParent: $('#assignSubmissionsReadersModal'),
                    closeOnSelect: false
                });

                $readers.select2({
                    placeholder: 'Select Readers',
                    width: '100%',
                    dropdownParent: $('#assignSubmissionsReadersModal'),
                    closeOnSelect: false
                });

                $subs.val([]).trigger('change.select2');
                $readers.val([]).trigger('change.select2');

                $subs.on('change', function () {
                    $wire.set('assign_reader_submission_ids', $(this).val() || [], false);
                });

                $readers.on('change', function () {
                    $wire.set('assign_reader_ids', $(this).val() || [], false);
                });
            }, 100);
        });

        $wire.on('close-submission-readers-modal', () => {
            let modal = bootstrap.Modal.getInstance(document.getElementById('assignSubmissionsReadersModal'));
            if (modal) modal.hide();
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
                            '<button type="button" class="delete-assignment-btn btn-close btn-close-sm" style="font-size:.1rem;" data-submission-id="' + sid + '" data-type="juror" data-person-id="' + j.id + '"></button>' +
                            '</span>'
                        ).join('')
                        : '<span class="text-muted">—</span>';

                    let readersList = row.readers.length
                        ? row.readers.map(r =>
                            '<span class="badge bg-label-success me-1 assignment-badge" style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;" data-submission-id="' + sid + '" data-assign-id="' + (r.assign_id || '') + '" title="Click to view submission">' + r.name +
                            (r.form_type ? ' <small>(Form Type ' + r.form_type + ')</small>' : '') +
                            '<button type="button" class="delete-assignment-btn btn-close btn-close-sm" style="font-size:.1rem;" data-submission-id="' + sid + '" data-type="reader" data-person-id="' + r.id + '"></button>' +
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

        $('#assignmentsTable').on('click', '.delete-assignment-btn', function (e) {
            e.stopPropagation();
            let submissionId = $(this).closest('.assignment-badge').data('submission-id');
            let type         = $(this).data('type');
            let personId     = $(this).data('person-id');
            $wire.deleteAssignment(submissionId, type, personId);
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

        window.confirmDeletePM = function (groupId) {
            Swal.fire({
                title: 'Delete Program Manager?',
                text: 'This will remove the PM and all their assigned submissions from this form.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deletePM(groupId);
                }
            });
        };
    </script>
    @endscript

</div>
