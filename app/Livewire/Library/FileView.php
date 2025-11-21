<?php

namespace App\Livewire\Library;

use App\Models\LibraryFiles;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\WithFileUploads;

class FileView extends Component
{

    use WithFileUploads;
    use AuthorizesRequests; 

    public $modalId = null;

    public $files;

    public $file;
    public $filePreview;
    public $path;
    public $old_path;
    public $title;
    public $title_arabic;
    


    public function mount(){

        $this->authorize('file-list');

        $this->modalId=null;

        $this->files=LibraryFiles::all();

    }

    public function editFile($id)
    {
        $file=LibraryFiles::find($id);
        $this->path=$file->path;
        $this->old_path=$file->old_path;
        $this->title=$file->title;
        $this->title_arabic=$file->title_arabic;
        $this->filePreview = asset('storage/' . $file->path);
        $this->modalId=$id;
    }


    public function saveEntry()
    {

        if($this->modalId==null){   
            
            // Save to storage/app/public/gallery
            $path = $this->file->store('files', 'public');

            LibraryFiles::create([
                'path' => $path,
                'title'     => $this->title,
                'title_arabic'       => $this->title_arabic
            ]);

            return to_route('files')->with('success', 'File added successfully!');
        }
        else if($this->modalId!=null){

            $path=$this->path;
            if($this->file){
                $path = $this->file->store('files', 'public');
            }

            LibraryFiles::where('id', $this->modalId)->update(
                [
                    'path' => $path,
                    'title' => $this->title,
                    'title_arabic' => $this->title_arabic,
                ]
            );

            return to_route('files')->with('success', 'File edited successfully!');
        }
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('file-delete');

        $file = LibraryFiles::find($id);

        $file->delete();

        return to_route('files')->with('success', 'File deleted successfully!');
    }

    public function render()
    {
        return view('livewire.library.file-view');
    }
}
