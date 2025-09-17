<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Pages List</h4>
                <a class="btn btn-primary h-50" href="{{ route('pages.create') }}">Add Page</a>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>In Menu</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $page->name }}</td>
                            <td>
                                <button 
                                    wire:click="toggleInMenu({{ $page->id }})" 
                                    class="px-4 rounded text-white 
                                        {{ $page->in_menu ? 'btn-success' : 'btn-danger' }}">
                                    {{ $page->in_menu == 1 ? 'Yes' : 'No' }}
                                </button>
                            </td>
                            <td>
                                <button 
                                    wire:click="togglePublish({{ $page->id }})" 
                                    class="px-4 rounded text-white 
                                        {{ $page->published ? 'btn-success' : 'btn-danger' }}">
                                    {{ $page->published == 1 ? 'Yes' : 'No' }}
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('pages.edit', $page->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $page->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
