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
                        <th>&nbsp;</th>
                        <th>Projects</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($years as $year)
                            <tr>
                                <td>{{ $year->id }}</td>
                                <td>{{ $year->year }}</td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if(count($year->jurors)>0)
                                            <div>
                                                @foreach($year->jurors as $juror)
                                                -{{$juror->jurorDetails->jury_name}}<br />
                                                @endforeach
                                            </div>

                                            <i  class="ti ti-adjustments ti-sm cursor-pointer"
                                            data-bs-target="#jurorsModal"
                                            data-bs-toggle="modal"
                                            wire:click="openJurorsModal({{ $year->id}})"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if(count($year->projects) > 0)
                                            <div>
                                                @foreach($year->projects as $project)
                                                    - {{ $project->projectDetails->project_title }}<br>
                                                @endforeach
                                            </div>
                                            <i  class="ti ti-adjustments ti-sm cursor-pointer"
                                            data-bs-target="#projectsModal"
                                            data-bs-toggle="modal"
                                            wire:click="openProjectsModal({{ $year->id}})"></i>
                                        @endif
                                    </div>
                                </td>
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

        <!-- Add Juror-->
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


        <!-- Sort Jurors-->
        <div wire:ignore.self class="modal fade" id="jurorsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalJurorsTitle}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeJurorsModal"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table border-top" id="tableJurors">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Juror Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($programJurors)>0)
                                @foreach ($programJurors as $programJuror)
                                    <tr data-id="{{ @$programJuror->id }}" style="cursor: move;">
                                        <td>{{$programJuror->list_order}}</td>
                                        <td>{{$programJuror->jurorDetails->jury_name}}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="deleteJuror({{ @$programJuror->id }})" class="text-body">
                                                <i class="ti ti-trash ti-sm mx-2 text-danger"></i>
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
        </div>


        <!--Add Project-->
        @if($showModalProject)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalProjectTitle}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeProjectModal"></button>
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

        <!--Sort Projects-->
        <div wire:ignore.self class="modal fade" id="projectsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalProjectsTitle}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeProjectsModal"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table border-top" id="tableProjects">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Project Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($programProjects)>0)
                                @foreach ($programProjects as $programProject)
                                    <tr data-id="{{ @$programProject->id }}" style="cursor: move;">
                                        <td>{{$programProject->list_order}}</td>
                                        <td>{{$programProject->projectDetails->project_title}}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="deleteProject({{ @$programProject->id }})" class="text-body">
                                                <i class="ti ti-trash ti-sm mx-2 text-danger"></i>
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
        </div>


        @script
            @include('livewire.deleteConfirm')
        @endscript

        <script>    
           
            //load jurors table
            document.addEventListener('livewire:init', function() {

                const el = document.querySelector("#tableJurors tbody");

                if (el) {
                    Sortable.create(el, {
                        handle: 'td',
                        animation: 150,
                        onEnd: function(evt) {
                            const order = [];
                            el.querySelectorAll("tr").forEach((row) => {
                                order.push(row.getAttribute("data-id"));
                            });

                            Livewire.dispatch('updateJurorOrder', {order: order});
                        }
                    });
                }
            });

            //load projects table
            document.addEventListener('livewire:init', function() {

                const el = document.querySelector("#tableProjects tbody");

                if (el) {
                    Sortable.create(el, {
                        handle: 'td',
                        animation: 150,
                        onEnd: function(evt) {
                            const order = [];
                            el.querySelectorAll("tr").forEach((row) => {
                                order.push(row.getAttribute("data-id"));
                            });

                            Livewire.dispatch('updateProjectOrder', {order: order});
                        }
                    });
                }
            });


        </script>

    </div>

</div>
