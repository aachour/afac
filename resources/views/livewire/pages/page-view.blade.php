<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Pages List</h4>
                @can('page-create')
                <a class="btn btn-primary h-50" href="{{ route('pages.create') }}">Add Page</a>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <!-- <th>Id</th> -->
                        <th>Name</th>
                        <th>In Menu</th>
                        <th>Published</th>
                        <th>Actions</th>
                        <th>Order</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <!-- <td>{{ $page->id }}</td> -->
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
                                @can('page-view')
                                    @if($page->id=='2') 
                                        <a href="{{ url('/') }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($page->id=='3')
                                        <a href="{{ url('/projects') }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @else
                                        <a href="{{ route('page.view', ['id'=>$page->id , 'name'=>$page->name]) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @endif
                                @endcan
                                @can('page-edit')
                                    <a href="{{ route('pages.edit', $page->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                @endcan
                                @can('section-list')
                                    <a href="{{ route('sections', $page->id) }}" class="text-body edit-user-button"><i class="ti ti-news ti-sm"></i></a>
                                @endcan
                                @can('page-delete')
                                    @if($page->id!='2' && $page->id!='3')
                                    <a href="#" class="text-body delete-record delete-button" data-id="{{ $page->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                    @endif
                                @endcan
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    @can('page-edit')
                                    <div class="d-flex flex-column">
                                        <button wire:click="moveUp({{ $page->id }})" class="btn btn-sm btn-icon btn-outline-secondary p-0" style="line-height:1" title="Move Up"><i class="ti ti-chevron-up"></i></button>
                                        <button wire:click="moveDown({{ $page->id }})" class="btn btn-sm btn-icon btn-outline-secondary p-0" style="line-height:1" title="Move Down"><i class="ti ti-chevron-down"></i></button>
                                    </div>
                                    @endcan
                                </div>
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

        <script>

            document.addEventListener('livewire:navigated', function () {
                setTimeout(() => {
                    if ($.fn.DataTable.isDataTable('.dataTable')) {
                        $('.dataTable').DataTable().destroy();
                    }
                    
                }, 100);
            });

        </script>

    </div>

</div>
