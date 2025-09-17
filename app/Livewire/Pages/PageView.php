<?php

namespace App\Livewire\Pages;

use App\Models\Pages;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageView extends Component
{

    use AuthorizesRequests; 

    public $pages;

    public function mount(){

        $this->authorize('page-list');

        $this->pages=Pages::all();

    }


    public function toggleInMenu($id)
    {
        $page = Pages::findOrFail($id);

        $page->in_menu = $page->in_menu == 0 ? 1 : 0;

        $text_action = $page->in_menu == 1 ? 'added to menu' : 'removed from menu';

        $page->save();

        return to_route('pages')->with('success', 'Page '.$text_action.' successfully!');
    }


    public function togglePublish($id)
    {
        $page = Pages::findOrFail($id);

        $page->published = $page->published == 0 ? 1 : 0;

        $text_action = $page->published == 1 ? 'published' : 'unpublished';

        $page->save();

        return to_route('pages')->with('success', 'Page '.$text_action.' successfully!');
    }


    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('page-delete');

        $page = Pages::find($id);

        $page->delete();

        return to_route('pages')->with('success', 'Page deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pages.page-view');
    }
}
