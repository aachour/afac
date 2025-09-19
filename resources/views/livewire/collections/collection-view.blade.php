<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Collections List</h4>
                @can('collection-create')
                <a class="btn btn-primary h-50" href="{{ route('collections.create') }}">Add Collection</a>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($collections as $collection)
                        <tr>
                            <td>{{ $collection->id }}</td>
                            <td>{{ $collection->type->name }}</td>
                            <td>{{ $collection->name }}</td>
                            <td>{{ $collection->description }}</td>
                            <td>
                                @can('collection-view')
                                <a href="{{ route('collections.view', $collection->id) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                @endcan
                                @can('collection-edit')
                                <a href="{{ route('collections.edit', $collection->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                @endcan
                                @can('collection-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $collection->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>


        @script
            @include('livewire.deleteConfirm')
        @endscript

    </div>

</div>
