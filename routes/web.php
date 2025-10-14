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
use App\Livewire\Collections\EntriesView;

use App\Livewire\Sections\SectionView;
use App\Livewire\Sections\SectionForm;

use App\Livewire\Columns\GeneralInputsView;
use App\Livewire\Columns\TimelineView;
use App\Livewire\Columns\AccordionView;
use App\Livewire\Columns\CountdownView;

use App\Livewire\Events\EventCategoryView;
use App\Livewire\Events\EventView;
use App\Livewire\Events\EventForm;


use App\Livewire\Entries\EntryView;
use App\Livewire\Entries\EntryForm;



Route::get('/', [HomeController::class, 'home'])->name('home'); 

Route::get('/home', [HomeController::class, 'home'])->name('home'); 

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
        Route::get('/{pageId}/section/{sectionId}/general/view/{id}', GeneralInputsView::class)->name('general.view');
        Route::get('/{pageId}/section/{sectionId}/timeline/view/{id}', TimelineView::class)->name('timeline.view');
        Route::get('/{pageId}/section/{sectionId}/accordion/view/{id}', AccordionView::class)->name('accordion.view');
        Route::get('/{pageId}/section/{sectionId}/countdown/view/{id}', CountdownView::class)->name('countdown.view');
    });


    // |--------------------------------------------------------------------------
    // |Collections
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'collections'], function () {
        Route::get('/', CollectionView::class)->name('collections');
        Route::get('/create', CollectionForm::class)->name('collections.create');
        Route::get('/edit/{id}', CollectionForm::class)->name('collections.edit');
        Route::get('/view/{id}', CollectionForm::class)->name('collections.view');
        Route::get('/{id}/entries', EntriesView::class)->name('entries.edit');
        
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
    // |Entries
    // |--------------------------------------------------------------------------
    
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', EventView::class)->name('events');
        Route::get('/create', EventForm::class)->name('events.create');
        Route::get('/edit/{id}', EventForm::class)->name('events.edit');
        Route::get('/view/{id}/{status?}', EventForm::class)->name('events.view');
    }); 


});
