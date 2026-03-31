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
                        <th>In workflow</th>
                        <th>Published</th>
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
                            <td>{{ $form->form_is_workflow_form == 1 ? 'Yes': 'No' }}</td>
                            <td>{{ $form->form_is_workflow_published == 1 ? 'Yes': 'No' }}</td>
                            <td>{{ date('d-M-Y',strtotime($form->form_created_at))}}</td>
                            <td>{{ date('d-M-Y',strtotime($form->form_updated_at))}}</td>
                            <td>
                                @can('formstack-submissions')
                                <a href="{{ route('formstack.submissions', ['formId' => $form->form_id]) }}" class="text-body view-user-button">
                                    <i class="ti ti-list-details ti-sm"></i>
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

</div>
