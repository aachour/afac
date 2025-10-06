<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Events List</h4>
                @can('page-create')
                <a class="btn btn-primary h-50" href="{{ route('events.create') }}">Add Event</a>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>From Time</th>
                        <th>to Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->title_arabic }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ $event->from_time }}</td>
                            <td>{{ $event->to_time }}</td>
                            <td>
                                @can('event-view')
                                <a href="{{ route('events.view', $event->id) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm"></i></a>
                                @endcan
                                @can('event-edit')
                                <a href="{{ route('events.edit', $event->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                @endcan
                                @can('event-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $event->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
