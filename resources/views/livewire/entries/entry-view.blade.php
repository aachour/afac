<div>

    <div>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">{{$type_name}} List</h4>
                @can('page-create')
                <a class="btn btn-primary h-50" href="{{ route('entry.create',['typeId'=>$type_id]) }}">
                    Add {{$type_name}}
                </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        @if($type_id==1)
                            <th>Title</th>
                            <th>Title Arabic</th>
                            <th>Date</th>
                            <th>From Time</th>
                            <th>to Time</th>
                        @elseif($type_id==2)
                            <th>Title</th>
                            <th>Title Arabic</th>
                            <th>Status</th>
                        @elseif($type_id==3)

                        @elseif($type_id==4)

                        @elseif($type_id==5)

                        @elseif($type_id==6)

                        @elseif($type_id==7)

                        @endif
                        
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($entries as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            @if($type_id==1)
                                <td>{{ $entry->title }}</td>
                                <td>{{ $entry->title_arabic }}</td>
                                <td>{{ $entry->date }}</td>
                                <td>{{ $entry->start_time }}</td>
                                <td>{{ $entry->end_time }}</td>
                            @elseif($type_id==2)
                                <td>{{ $entry->title }}</td>
                                <td>{{ $entry->title_arabic }}</td>
                                <td>{{ $entry->status }}</td>
                            @elseif($type_id==3)

                            @elseif($type_id==4)

                            @elseif($type_id==5)

                            @elseif($type_id==6)

                            @elseif($type_id==7)

                            @endif
                            
                            <td>
                                @can('entry-view')
                                <a href="{{ route('entry.view', $entry->id) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm"></i></a>
                                @endcan
                                @can('entry-edit')
                                <a href="{{ route('entry.edit', $entry->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                @endcan
                                @can('entry-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $entry->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
