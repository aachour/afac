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
                </div>
                
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Form ID</th>
                        <th>Submission ID</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            <td>{{ $submission->form_id }}</td>
                            <td>{{ $submission->submission_id }}</td>
                            <td>{{ $submission->email }}</td>
                            <td>
                                @can('formstack-submissionView')
                                <a href="{{ route('formstack.submission', ['formId' => $submission->form_id,'submissionId' => $submission->submission_id]) }}" target="_blank" class="text-body view-user-button">
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

</div>