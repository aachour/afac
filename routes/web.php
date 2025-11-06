<?php

use App\Http\Controllers\HomeController;
use App\Livewire\RolesPermissions\PermissionView;
use App\Livewire\RolesPermissions\RoleView;
use App\Livewire\Users\UserView;
use App\Livewire\Users\UserForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;

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

use App\Livewire\Events\EventCategoryView;
use App\Livewire\Events\EventView;
use App\Livewire\Events\EventForm;

use App\Livewire\Projects\ProjectCategoryView;

use App\Livewire\Entries\EntryView;
use App\Livewire\Entries\EntryForm;

use App\Livewire\Entries\ProgramYearsView;
use App\Livewire\Entries\ProjectGranteesView;

Route::get('/', [HomeController::class, 'home'])->name('home'); 

Route::get('/home', [HomeController::class, 'home'])->name('home'); 

Route::get('/view/collection/{id}', [HomeController::class, 'ViewCollection'])->name('view.collection'); 


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
    // |Entries
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'entries'], function () {
        Route::get('/{typeId?}', EntryView::class)->name('entries');
        Route::get('/{typeId?}/create', EntryForm::class)->name('entry.create');
        Route::get('/{typeId?}/edit/{id}', EntryForm::class)->name('entry.edit');
        Route::get('/{typeId?}/view/{id}/{status?}', EntryForm::class)->name('entry.view');

        Route::get('/{entryId}/sections/', SectionView::class)->name('entry.sections');
        Route::get('/{entryId}/sections/create/', SectionForm::class)->name('entry.sections.create');
        Route::get('/{entryId}/sections/edit/{id}', SectionForm::class)->name('entry.sections.edit');
        Route::get('/{entryId}/sections/view/{id}', SectionForm::class)->name('entry.sections.view');

        Route::get('/section/{sectionId}/general/view/{id}', GeneralInputsView::class)->name('entry.general.view');
        Route::get('/section/{sectionId}/timeline/view/{id}', TimelineView::class)->name('entry.timeline.view');
        Route::get('/section/{sectionId}/accordion/view/{id}', AccordionView::class)->name('entry.accordion.view');
        Route::get('/section/{sectionId}/countdown/view/{id}', CountdownView::class)->name('entry.countdown.view');

        Route::get('/{programId}/years/', ProgramYearsView::class)->name('entry.program.years');
        Route::get('/{projectId}/grantees/', ProjectGranteesView::class)->name('entry.project.grantees');
        
    }); 


});
