<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Forms List</h4>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Lang</th>
                        <th>System Submissions</th>
                        <th>Current Submissions</th>
                        <!-- <th>In workflow</th>
                        <th>Published</th> -->
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forms as $form)
                        <tr>
                            <td>{{ $form->form_id }}</td>
                            <td>{{ $form->form_name }}</td>
                            <td>{{ $form->form_lang }}</td>
                            <td>{{ $form->form_submissions }}</td>
                            <td>{{$form->submissions->count()}}</td>
                            {{--<td>{{ $form->form_is_workflow_form == 1 ? 'Yes': 'No' }}</td>
                            <td>{{ $form->form_is_workflow_published == 1 ? 'Yes': 'No' }}</td>--}}
                            <td>{{ date('d-M-Y',strtotime($form->form_created_at))}}</td>
                            <td>{{ date('d-M-Y',strtotime($form->form_updated_at))}}</td>
                            <td>
                                @can('formstack-submissions')
                                    <a href="{{ route('formstack.submissions', ['formId' => $form->form_id]) }}" 
                                        class="text-body view-user-button"
                                        data-bs-title="View Submissions"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <i class="ti ti-list-details ti-sm"></i>
                                    </a>
                                @endcan
                                @can('formstack-formAssign')
                                    <button wire:click="setFormId({{ $form->form_id }})" type="button" 
                                    data-bs-target="#assignModal" 
                                    data-bs-toggle="modal" 
                                    data-bs-title="Assign PMs"
                                    data-bs-placement="top"
                                    class="text-body view-user-button border-0 bg-transparent p-0">
                                        <i class="ti ti-user-plus ti-sm"></i>
                                    </button>
                                @endcan
                                @can('formstack-viewAssignedPM')
                                    <a href="{{ route('formstack.pm', ['formId' => $form->form_id]) }}" 
                                        class="text-body view-user-button"
                                        data-bs-title="View Assigned PMs"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <i class="ti ti-users-group ti-sm"></i>
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
