@extends('frontend.layout.layout')

@section('title-meta')
    <title>Projects | AFAC</title>
    <meta property="og:title" content="">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">
@endsection

@section('content')

    {!! $pageHTML !!}

    <div class="collection">

        <!--Filter-->
        <div class="filters" style="">
            <div class="filter">
                <select class="filterDpd filter_project_country">    
                    <option value="">@if(app()->getLocale() == 'en') Select country @else اختر الدولة @endif</option>';
                    @foreach($project_countries as $key=>$country)
                        <option value="{{ $key }}">{{$country}}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <select class="filterDpd filter_project_category">
                    <option value="">@if(app()->getLocale() == 'en') Select theme @else اختر الموضوع @endif</option>';
                    @foreach($project_categories as $key=>$category){
                        <option value="{{ $key }}">{{$category}}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <select class="filterDpd filter_project_program_year">
                    <option value="">@if(app()->getLocale() == 'en') Select year @else اختر السنة @endif</option>
                    @foreach($project_program_years as $project_program_year)
                        <option value="{{ $project_program_year['name'] }}">{{$project_program_year["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <select class="filterDpd filter_project_program">
                    <option value="">@if(app()->getLocale() == 'en') Select program @else اختر البرنامج @endif</option>
                    @foreach($project_programs as $project_program){
                        <option value="{{ $project_program['id'] }}"> @if(app()->getLocale() == 'en') {{$project_program["name"]}} @else {{$project_program["name_arabic"]}} @endif</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <input type="button" class="filterBtn" id="filterBtn" value="@if(app()->getLocale() == 'en') Filter @else تصفية @endif" />
            </div>
            <div class="filter">
                <input type="button" class="clearBtn" id="clearBtn" value="@if(app()->getLocale() == 'en') Clear @else مسح @endif" />
            </div>
            <div class="sort">
                <select class="filterDpd sortDpd" id="sortDpd">
                    <option value="">@if(app()->getLocale() == 'en') Select sort @else اختر الترتيب @endif</option>
                    <option value="1">@if(app()->getLocale() == 'en') Name ASC @else الاسم تصاعدي @endif</option>
                    <option value="2">@if(app()->getLocale() == 'en') Name DESC @else الاسم تنازلي @endif</option>
                    <option value="3">@if(app()->getLocale() == 'en') Date ASC @else التاريخ تصاعدي @endif</option>
                    <option value="4">@if(app()->getLocale() == 'en') Date DESC @else التاريخ تنازلي @endif</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>

        <div id="entries_projects"></div>
        <div class="mt-5 text-center d-none" id="loader_projects"><div class="loader"></div></div>

    </div>

    <script>

        function getFilteredEntries(filters=""){
            console.log(filters);
            $("#entries_projects").empty();
            $("#loader_projects").removeClass("d-none");
            $.ajax({
                url: "{{ route('get.projects')}}",
                method: "POST",
                data: {
                    filters: filters,
                },
                success: function(response) {
                    $("#loader_projects").addClass("d-none");
                    $("#entries_projects").html(response);
                },
                error: function(xhr) {
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                        alert(JSON.stringify(xhr.responseJSON.errors));
                    }
                }
            });
        }

        $(document).ready(function(){ 

            //initiate variables
            var project_country='';
            var project_category='';
            var project_program_year='';
            var project_program='';
            var sort='4';
            var page='1';

            var filters = {
                project_country: project_country,
                project_category: project_category,
                project_program_year: project_program_year,
                project_program: project_program,
                sort: sort,
                page: page,
            };

            getFilteredEntries(filters);
                    
            $('#filterBtn').click(function () {
                var parent=$(this).parent().parent();                        
                project_country=$(parent).find('.filter_project_country').val();
                project_category=$(parent).find('.filter_project_category').val();
                project_program_year=$(parent).find('.filter_project_program_year').val();
                project_program=$(parent).find('.filter_project_program').val();

                var filters = {
                    project_country: project_country,
                    project_category: project_category,
                    project_program_year: project_program_year,
                    project_program: project_program,
                    sort: sort,
                    page: page,
                };

                getFilteredEntries(filters);
            });

            $('#clearBtn').click(function () {
                var parent=$(this).parent().parent();                        
                $(parent).find('.filter_project_country').val('');
                $(parent).find('.filter_project_category').val('');
                $(parent).find('.filter_project_program_year').val('');
                $(parent).find('.filter_project_program').val('');

                var filters = {
                    project_country: '',
                    project_category: '',
                    project_program_year: '',
                    project_program: '',
                    sort: sort,
                    page: page,
                };

                getFilteredEntries(filters);
            });

            $('#sortDpd').change(function () {
                var parent=$(this).parent().parent();
                sort=$(parent).find('.sortDpd').val();
                var filters = {
                    project_country: project_country,
                    project_category: project_category,
                    project_program_year: project_program_year,
                    project_program: project_program,
                    sort: sort,
                    page: page,
                };
                getFilteredEntries(filters);
            });

            $('#entries_projects').on('click', '.page-link-1', function () {
                var page=$(this).attr("data-page");
                var filters = {
                    project_country: project_country,
                    project_category: project_category,
                    project_program_year: project_program_year,
                    project_program: project_program,
                    sort: sort,
                    page: page,
                };
                getFilteredEntries(filters);
                
            });

        });

    </script>
    
@endsection
