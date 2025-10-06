<?php

namespace App\Livewire\Events;

use App\Models\EventCategories;
use App\Models\Events;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventForm extends Component
{

    use AuthorizesRequests; 

    public $eventCategories;

    public $editing = false;
    public $event;
    public $id;
    public $category_id;
    public $title;
    public $title_arabic;
    public $date;
    public $from_time;
    public $to_time;
    public $image;
    public $image_width;
    public $background_color_id ;
    public $button_link;
    public $button_value;
    public $button_value_arabic;
    

    public function mount($id=''){

        if($id==''){
            $this->authorize('event-create');
        }
        else{

            $this->authorize('event-edit');
            $this->editing = true;

            $this->id=$id;
            $this->event=Events::find($id);
            $this->category_id=$this->event->category_id;
            $this->title=$this->event->title;
            $this->title_arabic=$this->event->title_arabic;
            $this->date=$this->event->date;
            $this->from_time=$this->event->from_time;
            $this->to_time=$this->event->to_time;
            $this->image=$this->event->image;
            $this->image_width=$this->event->image_width;
            $this->background_color_id=$this->event->background_color_id;
            $this->button_link=$this->event->button_link;
            $this->button_value=$this->event->button_value;
            $this->button_value_arabic=$this->event->button_value_arabic;
            
        }

        $this->eventCategories=EventCategories::all();
        
    }


    public function rules()
    {
        $data = [
            'category_id' => ['required'],
            'title' => ['required'],
            'title_arabic' => ['required'],
            'date' => ['required'],
            'from_time' => ['required'],
            'to_time' => ['required'],
            'image' => ['nullable'],
            'image_width' => ['nullable'],
            'background_color_id' => ['nullable'],
            'button_link' => ['nullable'],
            'button_value' => ['nullable'],
            'button_value_arabic' => ['nullable'],
        ];

        return $data;
    }

    public function store()
    {
        $this->validate();

        if($this->id==''){
            Events::create([
                'category_id' => $this->category_id,
                'title' => $this->title,
                'title_arabic' => $this->title_arabic,
                'date' => $this->date,
                'from_time' => $this->from_time,
                'to_time' => $this->to_time,
                'image' => $this->image,
                'image_width' => $this->image_width,
                'background_color_id' => $this->background_color_id,
                'button_link' => $this->button_link,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
            ]);

            return to_route('events')->with('success', 'Event created successfully!');
        }
        else if($this->id!=''){

            $data = [
                'category_id' => $this->category_id,
                'title' => $this->title,
                'title_arabic' => $this->title_arabic,
                'date' => $this->date,
                'from_time' => $this->from_time,
                'to_time' => $this->to_time,
                'image' => $this->image,
                'image_width' => $this->image_width,
                'background_color_id' => $this->background_color_id,
                'button_link' => $this->button_link,
                'button_value' => $this->button_value,
                'button_value_arabic' => $this->button_value_arabic,
            ];

            $this->event->update($data);

            return to_route('events')->with('success', 'Event updated successfully!');
            
        }
        
    }
    
    public function render()
    {
        return view('livewire.events.event-form');
    }
}
