<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;

use App\Livewire\Dashboard;

use App\Livewire\RolesPermissions\RoleView;
use App\Livewire\RolesPermissions\PermissionView;

use App\Livewire\Users\UserView;
use App\Livewire\Users\UserForm;

use App\Livewire\Countries\CountryView;

use App\Livewire\Colors\ColorView;

use App\Livewire\Types\TypeView;

use App\Livewire\Pages\PageView;
use App\Livewire\Pages\PageForm;

use App\Livewire\Collections\CollectionView;
use App\Livewire\Collections\CollectionForm;
use App\Livewire\Collections\CollectionEntriesView;

use App\Livewire\Sections\SectionView;
use App\Livewire\Sections\SectionForm;

use App\Livewire\Columns\GeneralInputsView;
use App\Livewire\Columns\TimelineView;
use App\Livewire\Columns\AccordionView;
use App\Livewire\Columns\CountdownView;
use App\Livewire\Columns\ExpandingTextView;
use App\Livewire\Columns\PatternView;

use App\Livewire\Events\EventCategoryView;

use App\Livewire\Projects\ProjectCategoryView;

use App\Livewire\Grantees\GranteeCategoryView;

use App\Livewire\Resources\ResourceCategoryView;

use App\Livewire\News\NewsCategoryView;

use App\Livewire\Externals\ExternalCategoryView;

use App\Livewire\Entries\EntryView;
use App\Livewire\Entries\EntryForm;

use App\Livewire\Entries\ProgramYearsView;
use App\Livewire\Entries\ProjectGranteesView;

use App\Livewire\Library\FileView;

use App\Livewire\Logo\LogoView;

use App\Livewire\LogoAnimation\LogoAnimationView;

use App\Livewire\Formstack\FormsView;
use App\Livewire\Formstack\SubmissionsView;
use App\Livewire\Formstack\SubmissionView;
use App\Livewire\Formstack\PMView;
use App\Livewire\Formstack\JurorsView;
use App\Livewire\Formstack\ViewersView;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\FormStackController;


Route::post('/set-language', function () {
    session(['locale' => request('locale')]);

    return response()->json(['ok' => true]);
});

Route::get('/', [HomeController::class, 'home'])->name('home'); 

Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/projects', [ProjectsController::class, 'projects'])->name('projects');

Route::post('/get/projects', [ProjectsController::class, 'getProjects'])->name('get.projects'); 

Route::post('/get/grantees', [ProjectsController::class, 'getGrantees'])->name('get.grantees'); 

Route::get('/animation', [HomeController::class, 'animation'])->name('animation'); 

Route::get('/page/{id}/{name}', [HomeController::class, 'ViewPage'])->name('page.view'); 

Route::get('/{entryType}/{id}', [HomeController::class, 'ViewEntry'])->where('entryType', 'event|program|project|grantee|juror|resource|news|external')->name('entry.view');

Route::get('/view/collection/{id}', [HomeController::class, 'ViewCollection'])->name('view.collection'); 

Route::get('/view/section/{id}', [HomeController::class, 'ViewSection'])->name('view.section'); 

Route::get('/view/logo', [HomeController::class, 'viewLogo'])->name('view.logo'); 

Route::post('/get/entries/', [HomeController::class, 'getFilteredEntries'])->name('get.entries');

// Route::get('/formstack/fetchForms/', [FormStackController::class, 'fetchForms'])->name('formstack.forms'); 

// Route::get('/formstack/fetchFormSubmissions/{formId}', [FormStackController::class, 'fetchFormSubmissions'])->name('formstack.submissions'); 

// Route::get('/formstack/fetchSubmission/{id}', [FormStackController::class, 'fetchSubmission'])->name('formstack.submission'); 


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () { 
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/permissions', PermissionView::class)->name('permissions');
    Route::get('/roles', RoleView::class)->name('roles');

    // |--------------------------------------------------------------------------
    // |Users
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', UserView::class)->name('users');
        Route::get('/create', UserForm::class)->name('users.create');
        Route::get('/edit/{id}', UserForm::class)->name('users.edit');
        Route::get('/view/{id}/{status}', UserForm::class)->name('users.view');
    });


    // |--------------------------------------------------------------------------
    // |Countries
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'countries'], function () {
        Route::get('/', CountryView::class)->name('countries');
        Route::get('/edit/{id}', CountryView::class)->name('countries.edit');
    });


    // |--------------------------------------------------------------------------
    // |Colors
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'colors'], function () {
        Route::get('/', ColorView::class)->name('colors');
        Route::get('/create', ColorView::class)->name('colors.create');
        Route::get('/edit/{id}', ColorView::class)->name('colors.edit');
        Route::get('/view/{id}/{status}', ColorView::class)->name('colors.view');
    });


    // |--------------------------------------------------------------------------
    // |Types
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'types'], function () {
        Route::get('/', TypeView::class)->name('types');
        Route::get('/create', TypeView::class)->name('types.create');
        Route::get('/edit/{id}', TypeView::class)->name('types.edit');
        Route::get('/view/{id}/{status}', TypeView::class)->name('types.view');
    });


    // |--------------------------------------------------------------------------
    // |Pages
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', PageView::class)->name('pages');
        Route::get('/create', PageForm::class)->name('pages.create');
        Route::get('/edit/{id}', PageForm::class)->name('pages.edit');
        Route::get('/view/{id}', PageForm::class)->name('pages.view');
        Route::get('/{pageId}/sections/', SectionView::class)->name('sections');
        Route::get('/{pageId}/sections/create/', SectionForm::class)->name('sections.create');
        Route::get('/{pageId}/sections/edit/{id}', SectionForm::class)->name('sections.edit');
        Route::get('/{pageId}/sections/view/{id}', SectionForm::class)->name('sections.view');

        Route::get('/section/{sectionId}/general/view/{id}', GeneralInputsView::class)->name('general.view');
        Route::get('/section/{sectionId}/timeline/view/{id}', TimelineView::class)->name('timeline.view');
        Route::get('/section/{sectionId}/accordion/view/{id}', AccordionView::class)->name('accordion.view');
        Route::get('/section/{sectionId}/countdown/view/{id}', CountdownView::class)->name('countdown.view');
        Route::get('/section/{sectionId}/expendingText/view/{id}', ExpandingTextView::class)->name('expendingText.view');
        Route::get('/section/{sectionId}/pattern/view/{id}', PatternView::class)->name('pattern.view');
        
    });


    // |--------------------------------------------------------------------------
    // |Collections
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'collections'], function () {
        Route::get('/', CollectionView::class)->name('collections');
        Route::get('/create', CollectionForm::class)->name('collections.create');
        Route::get('/edit/{id}', CollectionForm::class)->name('collections.edit');
        Route::get('/view/{id}', CollectionForm::class)->name('collections.view');
        Route::get('/{id}/entries', CollectionEntriesView::class)->name('collection.entries.edit');
        
    });


    // |--------------------------------------------------------------------------
    // |Event Categories
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'eventCategories'], function () {
        Route::get('/', EventCategoryView::class)->name('event.categories');
        Route::get('/create', EventCategoryView::class)->name('event.categories.create');
        Route::get('/edit/{id}', EventCategoryView::class)->name('event.categories.edit');
        Route::get('/view/{id}/{status}', EventCategoryView::class)->name('event.categories.view');
    });

    // |--------------------------------------------------------------------------
    // |Project Categories
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'projectCategories'], function () {
        Route::get('/', ProjectCategoryView::class)->name('project.categories');
        Route::get('/create', ProjectCategoryView::class)->name('project.categories.create');
        Route::get('/edit/{id}', ProjectCategoryView::class)->name('project.categories.edit');
        Route::get('/view/{id}/{status}', ProjectCategoryView::class)->name('project.categories.view');
    });

    // |--------------------------------------------------------------------------
    // |Grantee Categories
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'granteeCategories'], function () {
        Route::get('/', GranteeCategoryView::class)->name('grantee.categories');
        Route::get('/create', GranteeCategoryView::class)->name('grantee.categories.create');
        Route::get('/edit/{id}', GranteeCategoryView::class)->name('grantee.categories.edit');
        Route::get('/view/{id}/{status}', GranteeCategoryView::class)->name('grantee.categories.view');
    });

    // |--------------------------------------------------------------------------
    // |Resource Categories
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'resourceCategories'], function () {
        Route::get('/', ResourceCategoryView::class)->name('resource.categories');
        Route::get('/create', ResourceCategoryView::class)->name('resource.categories.create');
        Route::get('/edit/{id}', ResourceCategoryView::class)->name('resource.categories.edit');
        Route::get('/view/{id}/{status}', ResourceCategoryView::class)->name('resource.categories.view');
    });

    // |--------------------------------------------------------------------------
    // |News Categories
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'newsCategories'], function () {
        Route::get('/', NewsCategoryView::class)->name('news.categories');
        Route::get('/create', NewsCategoryView::class)->name('news.categories.create');
        Route::get('/edit/{id}', NewsCategoryView::class)->name('news.categories.edit');
        Route::get('/view/{id}/{status}', NewsCategoryView::class)->name('news.categories.view');
    });

    // |--------------------------------------------------------------------------
    // |External Categories
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'externalCategories'], function () {
        Route::get('/', ExternalCategoryView::class)->name('external.categories');
        Route::get('/create', ExternalCategoryView::class)->name('external.categories.create');
        Route::get('/edit/{id}', ExternalCategoryView::class)->name('external.categories.edit');
        Route::get('/view/{id}/{status}', ExternalCategoryView::class)->name('external.categories.view');
    });


    // |--------------------------------------------------------------------------
    // |Entries
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'entries'], function () {
        Route::get('/{typeId?}', EntryView::class)->name('entries');
        Route::get('/{typeId?}/create', EntryForm::class)->name('entry.create');
        Route::get('/{typeId?}/edit/{id}', EntryForm::class)->name('entry.edit');

        Route::get('/{entryId}/sections/', SectionView::class)->name('entry.sections');
        Route::get('/{entryId}/sections/create/', SectionForm::class)->name('entry.sections.create');
        Route::get('/{entryId}/sections/edit/{id}', SectionForm::class)->name('entry.sections.edit');
        Route::get('/{entryId}/sections/view/{id}', SectionForm::class)->name('entry.sections.view');

        Route::get('/section/{sectionId}/general/view/{id}', GeneralInputsView::class)->name('entry.general.view');
        Route::get('/section/{sectionId}/timeline/view/{id}', TimelineView::class)->name('entry.timeline.view');
        Route::get('/section/{sectionId}/accordion/view/{id}', AccordionView::class)->name('entry.accordion.view');
        Route::get('/section/{sectionId}/countdown/view/{id}', CountdownView::class)->name('entry.countdown.view');
        Route::get('/section/{sectionId}/expendingText/view/{id}', ExpandingTextView::class)->name('entry.expendingText.view');
        Route::get('/section/{sectionId}/pattern/view/{id}', PatternView::class)->name('entry.pattern.view');
        

        Route::get('/{programId}/years/', ProgramYearsView::class)->name('entry.program.years');
        Route::get('/{projectId}/grantees/', ProjectGranteesView::class)->name('entry.project.grantees');
        
    }); 


    // |--------------------------------------------------------------------------
    // |Library Files
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'files'], function () {
        Route::get('/', FileView::class)->name('files');
    });

    // |--------------------------------------------------------------------------
    // |Logo Animation
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'logoAnimation'], function () {
        Route::get('/', LogoAnimationView::class)->name('logo.animation');
    });

    // |--------------------------------------------------------------------------
    // |Logo
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'logoElements'], function () {
        Route::get('/', LogoView::class)->name('logo.elements');
    });


    // |--------------------------------------------------------------------------
    // |Formstack
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'formstackForms'], function () {
        Route::get('/', FormsView::class)->name('formstack.forms');
    });

    Route::group(['prefix' => 'formstackPM'], function () {
        Route::get('/{formId}/', PMView::class)->name('formstack.pm');
    });
    
    Route::group(['prefix' => 'formstackSubmissions'], function () {
        Route::get('/{formId?}', SubmissionsView::class)->name('formstack.submissions');
    });

    Route::group(['prefix' => 'formstackSubmissionView'], function () {
        Route::get('/{formId}/{submissionId}/{assignId?}', SubmissionView::class)->name('formstack.submission');
        
    });
    
});
