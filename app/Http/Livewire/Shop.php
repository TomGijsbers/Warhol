<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Painting;
use Http;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;

    // public properties
    public $perPage = 6;
    public $name;
    public $genre = '%';

    public $price;
    public $priceMin, $priceMax;

    public $loading = 'Hold on, I need to blend these colors a bit more...';

    public function updated($propertyName, $propertyValue)
    {
        if (in_array($propertyName, ['perPage', 'name', 'genre', 'price']))
            $this->resetPage();
    }

    public function mount()
    {
        $this->priceMin = ceil(Painting::min('price'));
        $this->priceMax = ceil(Painting::max('price'));
        $this->price = $this->priceMax;
    }


    public function render()
    {

        $allGenres = Genre::has('paintings')->withCount('paintings')->get();
        $paintings = Painting::orderBy('artist')->orderBy('title')
            ->searchTitleOrArtist($this->name)
            ->maxPrice($this->price)
            ->where('genre_id', 'like', $this->genre)
            ->paginate($this->perPage);


        return view('livewire.shop', compact('paintings', 'allGenres'))
            ->layout('layouts.warholshop', [
                'description' => 'Shop',
                'title' => 'Shop'
            ]);
    }
}
