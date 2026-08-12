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

    @if(@$pageShowName==1)
        <div class="section" style="background:{{@$headerBgCode}};">
            <div class="bigger black ABCDiatype">{{ app()->getLocale() == 'ar' ? $pageNameArabic : $pageName }}</div>
        </div>
    @endif

    {!! $pageHTML !!}

    <div class="collection">

        <!--Filter-->
        <div class="filters" style="">
            <div class="filter">
                <select class="filterDpd filter_project_country ABCDiatypeMedium tiny" style="width:130px;">    
                    <option value="">@if(app()->getLocale() == 'en') Country @else الدولة @endif</option>';
                    @foreach($project_countries as $key=>$country)
                        <option value="{{ $key }}">{{$country}}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <select class="filterDpd filter_project_category ABCDiatypeMedium tiny" style="width:120px;">
                    <option value="">@if(app()->getLocale() == 'en') Theme @else الموضوع @endif</option>';
                    @foreach($project_categories as $key=>$category){
                        <option value="{{ $key }}">{{$category}}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <select class="filterDpd filter_project_program_year ABCDiatypeMedium tiny" style="width:105px;">
                    <option value="">@if(app()->getLocale() == 'en') Year @else السنة @endif</option>
                    @foreach($project_program_years as $project_program_year)
                        <option value="{{ $project_program_year['name'] }}">{{$project_program_year["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <select class="filterDpd filter_project_program ABCDiatypeMedium tiny" style="width:135px;">
                    <option value="">@if(app()->getLocale() == 'en') Program @else البرنامج @endif</option>
                    @foreach($project_programs as $project_program){
                        <option value="{{ $project_program['id'] }}"> @if(app()->getLocale() == 'en') {{$project_program["name"]}} @else {{$project_program["name_arabic"]}} @endif</option>
                    @endforeach
                </select>
            </div>
            <div class="filter">
                <input type="button" class="filterBtn ABCDiatypeMedium tiny" id="filterBtn" value="@if(app()->getLocale() == 'en') Filter @else تصفية @endif" />
            </div>
            <div class="filter">
                <input type="button" class="clearBtn ABCDiatypeMedium tiny" id="clearBtn" value="@if(app()->getLocale() == 'en') Clear @else مسح @endif" />
            </div>
            <div class="sort">
                <select class="filterDpd sortDpd ABCDiatypeMedium tiny" id="sortDpd" style="width:100px;">
                    <option value="">@if(app()->getLocale() == 'en') Sort by @else الترتيب @endif</option>
                    <option value="1">@if(app()->getLocale() == 'en') Name @else الاسم @endif</option>
                    <!-- <option value="2">@if(app()->getLocale() == 'en') Name DESC @else الاسم تنازلي @endif</option> -->
                    <!-- <option value="3">@if(app()->getLocale() == 'en') Date ASC @else التاريخ تصاعدي @endif</option> -->
                    <option value="4">@if(app()->getLocale() == 'en') Date @else التاريخ @endif</option>
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
