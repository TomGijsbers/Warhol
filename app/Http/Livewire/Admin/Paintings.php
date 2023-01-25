<?php

namespace App\Http\Livewire\Admin;

use App\Models\Genre;
use App\Models\Painting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Storage;

class Paintings extends Component
{

    use WithPagination, WithFileUploads;
    // filter and pagination
    public $genres;
    public $search;
    public $noStock = false;
    public $noCover = false;
    public $perPage = 5;
    // show/hide the modal
    public $showModal = false;
    // array that contains the values for a new or updated version of the record
    public $newPainting = [
        'id' => null,
        'artist' => null,
        'title' => null,
        'image' => null,
        'stock' => null,
        'price' => null,
        'genre_id' => null,
        'cover' => '/storage/covers/no-cover.png',
    ];

    public function mount()
    {
        $this->genres = Genre::all();
    }

    // validation rules (use the rules() method, not the $rules property)
    protected function rules()
    {
        return [
            'newPainting.image' => 'required',
            'newPainting.artist' => 'required',
            'newPainting.title' => 'required',
            'newPainting.genre_id' => 'required|exists:genres,id',
            'newPainting.stock' => 'required|numeric|min:0',
            'newPainting.price' => 'required|numeric|min:0',
        ];
    }

    // validation attributes
    protected $validationAttributes = [];

    // set/reset $newPainting and validation
    public function setNewPainting(Painting $painting = null)
    {
        $this->resetErrorBag();
        if ($painting) {
            $this->newPainting['id'] = $painting->id;
            $this->newPainting['artist'] = $painting->artist;
            $this->newPainting['title'] = $painting->title;
            $this->newPainting['image'] = $painting->image;
            $this->newPainting['stock'] = $painting->stock;
            $this->newPainting['price'] = $painting->price;
            $this->newPainting['genre_id'] = $painting->genre_id;
            $this->newPainting['cover'] =
                Storage::disk('public')->exists('painting/' . $painting->image . '.jpg')
                    ? '/storage/painting/' . $painting->image . '.jpg'
                    : '/storage/painting/no-cover.png';
        } else {
            $this->reset('newPainting');
        }
        $this->showModal = true;
    }

    // reset the paginator
    public function updated($propertyName, $propertyValue)
    {
        if ($propertyName == 'newPainting.image') {
            $this->newPainting['image'] = '/storage/' . $this->newPainting['image']->store('painting', 'public');
        }

        $this->resetPage();
    }

    // create a new Painting
    public function createPainting()
    {
        $this->validate();
        $painting = Painting::create([
            'image' => $this->newPainting['image'],
            'artist' => $this->newPainting['artist'],
            'title' => $this->newPainting['title'],
            'stock' => $this->newPainting['stock'],
            'price' => $this->newPainting['price'],
            'genre_id' => $this->newPainting['genre_id'],
        ]);
        $this->showModal = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The painting <b><i>{$painting->title} from {$painting->artist}</i></b> has been added",
        ]);

    }

    // update an existing Painting
    public function updatePainting(Painting $painting)
    {
        // update an existing record
        $this->validate();
        $painting->update([
            'image' => $this->newPainting['image'],
            'artist' => $this->newPainting['artist'],
            'title' => $this->newPainting['title'],
            'stock' => $this->newPainting['stock'],
            'price' => $this->newPainting['price'],
            'genre_id' => $this->newPainting['genre_id'],
        ]);
        $this->showModal = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The painting <b><i>{$painting->title} from {$painting->artist}</i></b> has been updated",
        ]);
    }


    // delete an existing Painting
    public function deletePainting(Painting $painting)
    {
        $painting->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The painting <b><i>{$painting->title} from {$painting->artist}</i></b> has been deleted",
        ]);
    }

    public function render()
    {
        // filter by $search
        $query = Painting::orderBy('artist')->orderBy('title')
            ->searchTitleOrArtist($this->search);
        // only if $noCover is true, filter the query further, else, skip this step
        if($this->noStock)
            $query->where('stock', false);
        // paginate the $query
        $paintings = $query->paginate($this->perPage);
        return view('livewire.admin.paintings', compact('paintings'))
            ->layout('layouts.warholshop', [
                'description' => 'Manage the paintings of your art shop',
                'title' => 'Paintings',
            ]);
    }
}
