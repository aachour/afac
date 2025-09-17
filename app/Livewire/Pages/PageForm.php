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
    public $name_arabic;
    public $meta_title;
    public $meta_title_arabic;
    public $meta_description;
    public $meta_description_arabic;
    public $meta_keywords;
    public $meta_keywords_arabic;
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
            $this->name_arabic=$this->page->name_arabic;
            $this->meta_title=$this->page->meta_title;
            $this->meta_title_arabic=$this->page->meta_title_arabic;
            $this->meta_description=$this->page->meta_description;
            $this->meta_description_arabic=$this->page->meta_description_arabic;
            $this->meta_keywords=$this->page->meta_keywords;
            $this->meta_keywords_arabic=$this->page->meta_keywords_arabic;
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
            'name_arabic' => ['required'],
            'meta_title' => ['required'],
            'meta_title_arabic' => ['required'],
            'meta_description' => ['required'],
            'meta_description_arabic' => ['required'],
            'meta_keywords' => ['nullable'],
            'meta_keywords_arabic' => ['nullable'],
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
                'name_arabic' => $this->name_arabic,
                'meta_title' => $this->meta_title,
                'meta_title_arabic' => $this->meta_title_arabic,
                'meta_description' => $this->meta_description,
                'meta_description_arabic' => $this->meta_description_arabic,
                'meta_keywords' => $this->meta_keywords,
                'meta_keywords_arabic' => $this->meta_keywords_arabic,
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
                'name_arabic' => $this->name_arabic,
                'meta_title' => $this->meta_title,
                'meta_title_arabic' => $this->meta_title_arabic,
                'meta_description' => $this->meta_description,
                'meta_description_arabic' => $this->meta_description_arabic,
                'meta_keywords' => $this->meta_keywords,
                'meta_keywords_arabic' => $this->meta_keywords_arabic,
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
