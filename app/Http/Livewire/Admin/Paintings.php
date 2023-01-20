<?php

namespace App\Http\Livewire\Admin;

use App\Models\Painting;
use Livewire\Component;
use Livewire\WithPagination;

class Paintings extends Component
{

    use WithPagination;
    // filter and pagination
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

    // validation rules (use the rules() method, not the $rules property)
    protected function rules()
    {
        return [
            'newPainting.image' => 'required|size:36|unique:paintings,' . $this->newPainting['id'],
            'newPainting.artist' => 'required',
            'newPainting.title' => 'required',
            'newPainting.genre_id' => 'required|exists:genres,id',
            'newPainting.stock' => 'required|numeric|min:0',
            'newPainting.price' => 'required|numeric|min:0',
        ];
    }

    // validation attributes
    protected $validationAttributes = [

    ];

    // set/reset $newPainting and validation
    public function setNewPainting()
    {
        $this->resetErrorBag();
        $this->reset('newPainting');
        $this->showModal = true;

    }

    // reset the paginator
    public function updated($propertyName, $propertyValue)
    {
        $this->resetPage();
    }

    // create a new Painting
    public function createPainting()
    {

    }

    // update an existing Painting
    public function updatePainting()
    {
        // reset if the $search, $noCover, $noStock or $perPage property has changed (updated)
        if (in_array($propertyName, ['search', 'noCover', 'noStock', 'perPage']))
            $this->resetPage();
    }

    // delete an existing Painting
    public function deletePainting()
    {

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
