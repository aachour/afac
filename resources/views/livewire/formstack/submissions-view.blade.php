<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Submissions List</h4>

                <div class="d-flex gap-2">
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Manager'))
                    <a href="{{ route('formstack.forms') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                    @endif
                    @can('formstack-formFetchSubmissions')
                    <button type="button" wire:click="fetchSubmissions" class="btn btn-primary d-flex align-items-center">
                        Fetch Submissions
                    </button>
                    @endcan
                    @can('formstack-formClearSubmissions')
                    <button type="button" id="clear-submissions-btn" class="btn btn-primary d-flex align-items-center">
                        Clear Submissions
                    </button>
                    @endcan
                    @can('formstack-formAssignPM')
                    <button type="button" 
                    data-bs-target="#assignPMModal" 
                    data-bs-toggle="modal" 
                    class="btn btn-primary d-flex align-items-center">
                        Assign Program Manager(s)
                    </button>
                    @endcan
                    @if(Auth::user()->hasRole('Program Manager'))
                    <button type="button"
                        data-bs-target="#assignJurorsModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary d-flex align-items-center">
                        Assign Juror(s)
                    </button>
                    <button type="button"
                        data-bs-target="#assignReadersModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary d-flex align-items-center">
                        Assign Reader(s)
                    </button>

                    <a href="{{ route('formstack.export.jurors', $form_id) }}"
                        class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-file-spreadsheet me-1"></i> Export Juror(s) Rates
                    </a>
                    
                    <a href="{{ route('formstack.export.readers', $form_id) }}"
                        class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-file-spreadsheet me-1"></i> Export Reader(s) Rates
                    </a>
                    
                    @endif

                </div>
                
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table" data-order='[[2, "asc"]]'>
                    <thead>
                    @if(Auth::user()->hasRole('Juror') || Auth::user()->hasRole('Reader'))
                    <tr>
                        <th>ID</th>
                        <th>Type of Applicant</th>
                        <th>Project Stage (for cinema applications)</th>
                        <th>Name of Applicant</th>
                        <th>Project Title</th>
                        <th>Name of Institution </th>
                        <th>Rate</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                    @else
                    <tr>
                        <th><input type="checkbox" id="select-all-submissions" title="Select all on this page" /></th>
                        <th>Form ID</th>
                        <th>Form Name</th>
                        <th>Submission ID</th>
                        <th>Admin ID</th>
                        <th>Email</th>
                        @if(Auth::user()->hasRole('Admin'))
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Assigned To PM</th>
                        @elseif(Auth::user()->hasRole('Program Manager'))
                        <th>Assigned To Jurors</th>
                        <th>Assigned To Readers</th>
                        <th>Status</th>
                        <th>Notes</th>
                        @endif
                        <th>Action</th>
                    </tr>
                    @endif
                    </thead>
                    <tbody>
                    @if(Auth::user()->hasRole('Juror') || Auth::user()->hasRole('Reader'))
                        @foreach($assigns as $assign)
                            <tr>
                                @foreach($assign->submission->juror_internal_labels ?? [] as $key => $value)
                                <td> {{ $value }}</td>
                                @endforeach
                                <td>
                                    @if($assign->form_type==1)
                                        Status: {{ $assign->form_status }}<br />
                                    @elseif($assign->form_type==2)
                                        {{ ($assign->form_rate1 + $assign->form_rate2 + $assign->form_rate3) }} / 10<br />
                                    @elseif($assign->form_type==3)
                                        {{ ($assign->form_rate1 + $assign->form_rate2 + $assign->form_rate3 + $assign->form_rate4) }} / 11<br />
                                    @endif
                                </td>
                                <td>{{ $assign->form_notes }}</td>
                                <td>
                                    <a href="{{ route('formstack.submission', ['formId' => $assign->submission->form_id,'submissionId' => $assign->submission->submission_id , 'pmId' => $assign->group->user_id , 'assignId' => $assign->id]) }}" 
                                        class="view-user-button {{ ($assign->form_status || $assign->form_rate1 || $assign->form_rate2 || $assign->form_rate3 || $assign->form_rate4) ? 'text-success' : 'text-body' }}"
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
                                <td>
                                    <input type="checkbox" class="submission-checkbox" value="{{ $submission->submission_id }}" />
                                </td>
                                <td>{{ $submission->form_id }}</td>
                                <td>{{ $submission->form->form_name ?? '' }}</td>
                                <td>{{ $submission->submission_id }}</td>
                                <td>{{ $submission->admin_id }}</td>
                                <td>{{ $submission->email }}</td>
                                @if(Auth::user()->hasRole('Admin'))
                                <td>{{ $submission->admin_status }}</td>
                                <td>{{ $submission->admin_notes }}</td>
                                <td>
                                    @foreach($submissionPMs[$submission->submission_id] ?? [] as $pm)
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <span>{{ $pm['name'] }}</span>
                                            <button type="button"
                                                onclick="confirmRemovePM({{ $pm['group_id'] }}, '{{ $submission->submission_id }}')"
                                                class="btn btn-sm btn-icon btn-label-danger border-0 p-0 ms-1"
                                                title="Remove from PM">
                                                <i class="ti ti-x ti-xs"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </td>
                                @elseif(Auth::user()->hasRole('Program Manager'))
                                <td>
                                    @foreach($submissionJurors[$submission->submission_id] ?? [] as $juror)
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <a href="{{ route('formstack.submission', [$form_id, $submission->submission_id, $juror['pm_id'], $juror['assign_id']]) }}">{{ $juror['name'] }}
                                                @if($juror['form_type']) 
                                                <small class="text-muted">({{ $juror['form_type'] == 1 ? 'Admin check' : ($juror['form_type'] == 2 ? 'Special Programs 1' : 'General Grants') }})</small><br />
                                                @endif
                                                
                                            </a>
                                            <button type="button"
                                                onclick="confirmDeleteJuror({{ $juror['assign_id'] }})"
                                                class="btn btn-sm btn-icon btn-label-danger border-0 p-0 ms-1"
                                                title="Remove Juror">
                                                <i class="ti ti-x ti-xs"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($submissionReaders[$submission->submission_id] ?? [] as $reader)
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <a href="{{ route('formstack.submission', [$form_id, $submission->submission_id, $reader['pm_id'], $reader['assign_id']]) }}">{{ $reader['name'] }}@if($reader['form_type']) <small class="text-muted">({{ $reader['form_type'] == 1 ? 'Admin check' : ($reader['form_type'] == 2 ? 'Special Programs 1' : 'General Grants') }})</small>@endif</a>
                                            <button type="button"
                                                onclick="confirmDeleteReader({{ $reader['assign_id'] }})"
                                                class="btn btn-sm btn-icon btn-label-danger border-0 p-0 ms-1"
                                                title="Remove Reader">
                                                <i class="ti ti-x ti-xs"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @php $statusEntry = $submissionStatuses[$submission->submission_id] ?? null; @endphp
                                    @if($statusEntry)
                                        @if($statusEntry['status'])<span class="{{ $statusEntry['status'] === 'yes' ? 'text-success' : ($statusEntry['status'] === 'maybe' ? 'text-warning' : ($statusEntry['status'] === 'no' ? 'text-danger' : '')) }}">{{ $statusEntry['status'] }}</span>@endif
                                    @endif
                                </td>
                                <td>
                                    @php $statusEntry = $submissionStatuses[$submission->submission_id] ?? null; @endphp
                                    @if($statusEntry)
                                        @if($statusEntry['notes']){{ $statusEntry['notes'] }}@endif
                                    @endif
                                </td>
                                
                                @endif
                                <td>
                                    @can('formstack-submissionRate')
                                        <button wire:click="setAdminRate({{ $submission->id }})" type="button" 
                                        data-bs-target="#rateAdminModal" 
                                        data-bs-toggle="modal" 
                                        data-bs-title="Rate Submission"
                                        data-bs-placement="top"
                                        class="text-body view-user-button border-0 bg-transparent p-0">
                                            <i class="ti ti-star ti-sm"></i>
                                        </button>
                                    @endcan
                                    @if(Auth::user()->hasRole('Admin'))
                                        <a href="{{ route('formstack.submission', ['formId' => $submission->form_id,'submissionId' => $submission->submission_id]) }}" 
                                            target="_blank" 
                                            class="text-body view-user-button"
                                            data-bs-title="View Submission"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                            <i class="ti ti-eye ti-sm"></i>
                                        </a>
                                    @elseif(Auth::user()->hasRole('Program Manager'))
                                        <a href="{{ route('formstack.submission', ['formId' => $submission->form_id,'submissionId' => $submission->submission_id , 'pmId' => Auth::id()]) }}" 
                                            class="text-body view-user-button"
                                            data-bs-title="View Submission"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                            <i class="ti ti-eye ti-sm"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div wire:ignore.self class="modal fade" id="assignJurorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Juror(s) to Selected Submissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="assign_juror_ids" class="form-label">Jurors</label>
                        <select id="assign_juror_ids" class="form-control" multiple>
                            @foreach($pm_jurors as $juror)
                                <option value="{{ $juror->id }}">
                                    {{ $juror->first_name }} {{ $juror->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="assign_form_type" class="form-label">Form Type</label>
                        <select id="assign_form_type" class="form-control" wire:model="assign_form_type">
                            <option value="">Select Form Type</option>
                            <option value="1">Admin check</option>
                            <option value="2">Special Programs 1</option>
                            <option value="3">General Grants</option>
                        </select>
                        @error('assign_form_type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
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
                        <span wire:loading.remove wire:target="saveSubmissionJurors">Save</span>
                        <span wire:loading wire:target="saveSubmissionJurors">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assignReadersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Reader(s) to Selected Submissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3" wire:ignore>
                        <label for="assign_reader_ids" class="form-label">Readers</label>
                        <select id="assign_reader_ids" class="form-control" multiple>
                            @foreach($pm_readers as $reader)
                                <option value="{{ $reader->id }}">
                                    {{ $reader->first_name }} {{ $reader->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="assign_reader_form_type" class="form-label">Form Type</label>
                        <select id="assign_reader_form_type" class="form-control" wire:model="assign_reader_form_type">
                            <option value="">Select Form Type</option>
                            <option value="1">Admin check</option>
                            <option value="2">Special Programs 1</option>
                            <option value="3">General Grants</option>
                        </select>
                        @error('assign_reader_form_type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
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
                        <span wire:loading.remove wire:target="saveSubmissionReaders">Save</span>
                        <span wire:loading wire:target="saveSubmissionReaders">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assignPMModal" tabindex="-1" aria-hidden="true">
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
                        wire:click="savePMAssign"
                        wire:loading.attr="disabled"
                        wire:target="savePMAssign"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="savePMAssign">
                            {{ @$modalId ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="savePMAssign">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="rateAdminModal" tabindex="-1" aria-hidden="true">
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
                        wire:click="saveAdminRate"
                        wire:loading.attr="disabled"
                        wire:target="saveAdminRate"
                        class="btn btn-primary"
                    >
                        <span wire:loading.remove wire:target="saveAdminRate">
                            {{ @$modalId ? 'Update' : 'Save' }}
                        </span>

                        <span wire:loading wire:target="saveAdminRate">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        window.confirmDeleteReader = function(assignId) {
            Swal.fire({
                title: 'Remove Reader',
                text: 'Are you sure you want to remove this reader assignment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteReaderAssign(assignId);
                }
            });
        }

        window.confirmDeleteJuror = function(assignId) {
            Swal.fire({
                title: 'Remove Juror',
                text: 'Are you sure you want to remove this juror assignment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteJurorAssign(assignId);
                }
            });
        }

        window.confirmRemovePM = function(groupId, submissionId) {
            Swal.fire({
                title: 'Remove Submission',
                text: 'Are you sure you want to remove this submission from the Program Manager?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deletePMSubmission(groupId, submissionId);
                }
            });
        }

        document.getElementById('clear-submissions-btn')?.addEventListener('click', function () {
            Swal.fire({
                title: 'Clear Submissions',
                text: 'Are you sure you want to delete all submissions related to this form? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete all!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $wire.clearSubmissions();
                }
            });
        });

        // ── Save & restore DataTable state across submission navigation ──
        (function () {
            const DT_KEY = 'submissions_dt_state_{{ $form_id }}';

            function getDt() {
                return $.fn.DataTable.isDataTable('#table') ? $('#table').DataTable() : null;
            }

            // Capture state before navigating into a submission page
            document.addEventListener('click', function (e) {
                const link = e.target.closest('a.view-user-button');
                if (!link) return;
                const dt = getDt();
                if (!dt) return;
                sessionStorage.setItem(DT_KEY, JSON.stringify({
                    page:   dt.page(),
                    length: dt.page.len(),
                    search: dt.search(),
                    order:  dt.order()
                }));
            }, true);

            // Restore state when returning to this page
            function restoreState() {
                const raw = sessionStorage.getItem(DT_KEY);
                if (!raw) return;
                sessionStorage.removeItem(DT_KEY);
                const state = JSON.parse(raw);
                const dt = getDt();
                if (!dt) return;
                dt.page.len(state.length);
                dt.search(state.search || '');
                if (state.order && state.order.length) dt.order(state.order);
                dt.draw();                        // apply length/search/order (resets to page 0)
                dt.page(state.page).draw(false);  // jump back to the saved page
            }

            // Run restore once DataTable is ready
            if (getDt()) {
                restoreState();
            } else {
                $('#table').one('init.dt', restoreState);
            }
        }());

        // ── Persist checkbox state across DataTables pagination / sort / filter ──
        let _selectedSubmissions = new Set((@json($selected_submissions ?? [])).map(String));

        // Track individual row checkbox changes and sync to Livewire
        document.addEventListener('change', function (e) {
            if (!e.target.matches('#table tbody input[type="checkbox"]')) return;
            const cb = e.target;
            if (cb.checked) _selectedSubmissions.add(cb.value);
            else _selectedSubmissions.delete(cb.value);
            $wire.set('selected_submissions', [..._selectedSubmissions], false);
            syncSelectAll();
        });

        // Re-apply selections after every DataTables draw (pagination, sort, filter)
        $('#table').on('draw.dt', function () {
            $(this).find('tbody input.submission-checkbox').each(function () {
                this.checked = _selectedSubmissions.has(this.value);
            });
            syncSelectAll();
        });

        // Select-all header checkbox — use delegation so DataTables re-renders don't break it
        document.addEventListener('click', function (e) {
            if (e.target.id === 'select-all-submissions') e.stopPropagation();
        }, true);

        document.addEventListener('change', function (e) {
            if (e.target.id !== 'select-all-submissions') return;
            const checked = e.target.checked;
            const dt = $.fn.DataTable.isDataTable('#table') ? $('#table').DataTable() : null;
            const $rows = dt ? $(dt.rows({ page: 'current' }).nodes()) : $('#table tbody tr');
            $rows.find('input.submission-checkbox').each(function () {
                this.checked = checked;
                if (checked) _selectedSubmissions.add(this.value);
                else _selectedSubmissions.delete(this.value);
            });
            $wire.set('selected_submissions', [..._selectedSubmissions], false);
        });

        function syncSelectAll() {
            const selectAll = document.getElementById('select-all-submissions');
            if (!selectAll) return;
            const cbs = [...document.querySelectorAll('#table tbody input[type="checkbox"]')];
            if (cbs.length === 0) return;
            selectAll.checked = cbs.every(cb => cb.checked);
            selectAll.indeterminate = !selectAll.checked && cbs.some(cb => cb.checked);
        }

        // Initialize Select2 for readers when the modal opens
        document.getElementById('assignReadersModal')?.addEventListener('shown.bs.modal', function () {
            let $el = $('#assign_reader_ids');

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

            $el.on('change', function () {
                $wire.set('assign_reader_ids', $(this).val() || [], false);
            });
        });

        // Initialize Select2 for jurors when the modal opens
        document.getElementById('assignJurorsModal')?.addEventListener('shown.bs.modal', function () {
            let $el = $('#assign_juror_ids');

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

            $el.on('change', function () {
                $wire.set('assign_juror_ids', $(this).val() || [], false);
            });
        });

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
                    dropdownParent: $('#assignPMModal'),
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