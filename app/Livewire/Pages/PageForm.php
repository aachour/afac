<?php

namespace App\Livewire\Pages;

use App\Models\Pages;
use App\Models\Colors;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageForm extends Component
{

    use AuthorizesRequests; 

    public $colors;
    public $editing = false;
    public $page;
    public $id;
    public $name;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $header_color_id;
    public $footer_color_id;
    public $in_menu;
    public $published;
 
    public function mount($id=''){

        if($id==''){
            $this->authorize('page-create');
        }
        else{

            $this->authorize('page-edit');

            $this->editing = true;

            $this->id=$id;

            $this->page=Pages::find($id);
            $this->name=$this->page->name;
            $this->meta_title=$this->page->meta_title;
            $this->meta_description=$this->page->meta_description;
            $this->meta_keywords=$this->page->meta_keywords;
            $this->header_color_id=$this->page->header_color_id;
            $this->footer_color_id=$this->page->footer_color_id;
            $this->in_menu=$this->page->in_menu;
            $this->published=$this->page->published;
            
        }

        $this->colors=Colors::all();
        
    }


    public function rules()
    {
        $data = [
            'name' => ['required'],
            'meta_title' => ['required'],
            'meta_description' => ['required'],
            'meta_keywords' => ['nullable'],
            'header_color_id' => ['required'],
            'footer_color_id' => ['required'],
            'in_menu' => ['nullable'],
            'published' => ['nullable'],
        ];

        return $data;
    }

    public function store()
    {
        $this->validate();

        if($this->id==''){
            Pages::create([
                'name' => $this->name,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'meta_keywords' => $this->meta_keywords,
                'header_color_id' => $this->header_color_id,
                'footer_color_id' => $this->footer_color_id,
                'in_menu' => $this->in_menu,
                'published' => $this->published,
            ]);

            return to_route('pages')->with('success', 'Page created successfully!');
        }
        else if($this->id!=''){

            $data = [
                'name' => $this->name,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'meta_keywords' => $this->meta_keywords,
                'header_color_id' => $this->header_color_id,
                'footer_color_id' => $this->footer_color_id,
                'in_menu' => $this->in_menu,
                'published' => $this->published,
            ];

            $this->page->update($data);

            return to_route('pages')->with('success', 'Page updated successfully!');
            
        }
        
    }

    public function render()
    {
        return view('livewire.pages.page-form');
    }
}
