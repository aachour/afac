<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Years List</h4>

                <div class="d-flex gap-2">
                    <button wire:click="openModal()" class="btn btn-primary">
                        Add Year
                    </button>
                    <a href="{{ route('entries','2') }}" class="btn btn-secondary text-nowrap">
                        Back
                    </a>
                </div>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Year</th>
                        <th>Jurors</th>
                        <th>Projects</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($years as $year)
                            <tr>
                                <td>{{ $year->id }}</td>
                                <td>{{ $year->year }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="#" wire:click="openModal({{ $year->id }})" class="text-body edit-user-button">
                                        <i class="ti ti-edit ti-sm"></i>
                                    </a>
                                    @can('section-list')
                                        <a href="#" wire:click="openJurorModal({{ $year->id }})" class="text-body edit-user-button">
                                            <i class="ti ti-gavel ti-sm"></i>
                                        </a>
                                        <a href="#" wire:click="openProjectModal({{ $year->id }})" class="text-body edit-user-button">
                                            <i class="ti ti-briefcase ti-sm"></i>
                                        </a>
                                    @endcan
                                    <a href="#" class="text-body delete-record delete-button" data-id="{{ $year->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        @if($showModal)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalTitle }}</h5>
                            <button type="button" wire:click="closeModal" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="text"
                                    class="form-control @error('year') is-invalid @enderror"
                                    id="year"
                                    wire:model="year"
                                    placeholder="Year">
                                @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button" wire:click="saveYear" class="btn btn-primary">
                                {{ $editingId ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showModalJuror)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalJurorTitle}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeJurorModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="juror_id" class="form-label">Juror</label>
                                <select wire:model="juror_id" id="juror_id" class="form-control">
                                    <option value="">Select Juror</option>
                                    @foreach($jurors as $juror)
                                        <option value="{{ $juror->id }}">{{ $juror->jury_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeJurorModal" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="button" wire:click="saveJuror" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showModalProject)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalProjectTitle}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeJurorModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Project</label>
                                <select wire:model="project_id" id="project_id" class="form-control">
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->project_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeProjectModal" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="button" wire:click="saveProject" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @script
            @include('livewire.deleteConfirm')
        @endscript

    </div>

</div>
