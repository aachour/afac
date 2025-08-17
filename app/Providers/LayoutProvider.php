<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EventCategories;
use App\Models\Footer;
use App\Models\Membership;

class LayoutProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer('*', function ($view) {
            if (!str_contains($view->getName(), 'livewire')) {

            }
        });
    }

    //app.php provider
    // public function boot()
    // {
    //     View::composer('*', function ($view) {
    //         $view->with('eventCategories', EventCategories::all());
    //     });
    // }

    //except siko blade
    // public function boot()
    // {
    //     // Sharing the event categories variable with all views except 'siko.blade.php'
    //     View::composer('*', function ($view) {
    //         if (!str_contains($view->getName(), 'siko')) {
    //             $view->with('eventCategories', EventCategories::all());
    //         }
    //     });
    // }
}
