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
                            <th>Category</th>
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
                            <th>Category</th>
                            <th>Title</th>
                            <th>Title Arabic</th>
                        @elseif($type_id==4)
                            <th>Name</th>
                            <th>Name Arabic</th>
                            <th>Country</th>
                        @elseif($type_id==5)
                            <th>Name</th>
                            <th>Name Arabic</th>
                            <th>Country</th>
                        @elseif($type_id==6)
                            <th>Title</th>
                            <th>Title Arabic</th>
                            <th>Date</th>
                        @elseif($type_id==7)
                            <th>Title</th>
                            <th>Title Arabic</th>
                            <th>Date</th>
                        @elseif($type_id==8)
                            <th>Title</th>
                            <th>Title Arabic</th>
                            <th>Link</th>
                        @elseif($type_id==9)
                            <th>Name</th>
                            <th>Name Arabic</th>
                        @elseif($type_id==10)
                            <th>Name</th>
                            <th>Name Arabic</th>
                        @endif
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($entries as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            @if($type_id==1)
                                <td>{{ $entry->eventCategory->name }} </td>
                                <td>{{ $entry->event_title }}</td>
                                <td>{{ $entry->event_title_arabic }}</td>
                                <td>{{ $entry->event_date }}</td>
                                <td>{{ $entry->event_start_time }}</td>
                                <td>{{ $entry->event_end_time }}</td>
                            @elseif($type_id==2)
                                <td>{{ $entry->program_title }}</td>
                                <td>{{ $entry->program_title_arabic }}</td>
                                <td>{{ $entry->program_status }}</td>
                            @elseif($type_id==3)
                                <td>{{ $entry->projectCategory->name }}</td>
                                <td>{{ $entry->project_title }}</td>
                                <td>{{ $entry->project_title_arabic }}</td>
                            @elseif($type_id==4)
                                <td>{{ $entry->grantee_name }}</td>
                                <td>{{ $entry->grantee_name_arabic }}</td>
                                <td>{{ $entry->granteeCountry->name }}</td>
                            @elseif($type_id==5)
                                <td>{{ $entry->jury_name }}</td>
                                <td>{{ $entry->jury_name_arabic }}</td>
                                <td>{{ $entry->juryCountry->name }}</td>
                            @elseif($type_id==6)
                                <td>{{ $entry->resource_title }}</td>
                                <td>{{ $entry->resource_title_arabic }}</td>
                                <td>{{ $entry->resource_date }}</td>
                            @elseif($type_id==7)
                                <td>{{ $entry->news_title }}</td>
                                <td>{{ $entry->news_title_arabic }}</td>
                                <td>{{ $entry->news_date }}</td>
                            @elseif($type_id==8)
                                <td>{{ $entry->external_title }}</td>
                                <td>{{ $entry->external_title_arabic }}</td>
                                <td>{{ $entry->external_link }}</td>
                            @elseif($type_id==9)
                                <td>{{ $entry->team_name }}</td>
                                <td>{{ $entry->team_name_arabic }}</td>
                            @elseif($type_id==10)
                                <td>{{ $entry->member_name }}</td>
                                <td>{{ $entry->member_name_arabic }}</td>
                            @endif
                            
                            <td>
                                @can('entry-view')
                                    @if($type_id==1)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'event' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==2)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'program' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==3)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'project' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==4)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'grantee' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==5)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'juror' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==6)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'resource' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==7)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'news' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==8)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'external' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==9)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'team' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @elseif($type_id==10)
                                    <a href="{{ route('entry.view', [ 'entryType'=> 'member' , 'id'=> $entry->id] ) }}" class="text-body view-user-button" target="_blank"><i class="ti ti-eye ti-sm"></i></a>
                                    @endif
                                @endcan
                                @can('entry-edit')
                                    <a href="{{ route('entry.edit', [ 'typeId'=> $type_id , 'id'=> $entry->id] ) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                @endcan
                                @can('section-list')
                                    @if($type_id<=7)
                                    <a href="{{ route('entry.sections', $entry->id) }}" class="text-body edit-user-button"><i class="ti ti-news ti-sm"></i></a>
                                    @endif
                                    @if($type_id==2)
                                    <a href="{{ route('entry.program.years', $entry->id) }}" class="text-body edit-user-button"><i class="ti ti-calendar ti-sm"></i></a>
                                    @endif
                                    @if($type_id==3)
                                    <a href="{{ route('entry.project.grantees', $entry->id) }}" class="text-body edit-user-button"><i class="ti ti-user ti-sm"></i></a>
                                    @endif
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
