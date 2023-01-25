<div>
{{--     show preloader while fetching data in the background--}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-tmk.preloader class="bg-lime-700/60 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-tmk.preloader>
    </div>
{{--     filter section: artist or title, genre, max price and paintings per page--}}
    <div class="grid grid-cols-10 gap-4">
        <div class="col-span-10 md:col-span-5 lg:col-span-3">
            <x-jet-label for="name" value="Filter"/>
            <div
                x-data="{ name: @entangle('name') }"
                class="relative">
                <x-jet-input id="name" type="text"
                             x-model.debounce.500ms="name"
                             wire:model.debounce.500ms="name"
                             wire:model.debounce.500ms="name"
                             class="block mt-1 w-full"
                             placeholder="Filter Artist Or Painting"/>
                <div
                    x-show="name"
                    @click="name = '';"
                    class="w-5 absolute right-4 top-3 cursor-pointer">
                    <x-phosphor-x-duotone/>
                </div>
            </div>
        </div>
        <div class="col-span-5 md:col-span-2 lg:col-span-2">
            <x-jet-label for="genre" value="Genre"/>
            <x-tmk.form.select
                               wire:model="genre"
                               class="block mt-1 w-full">
                <option value="%">All Genres</option>
                @foreach($allGenres as $g)
                    <option value="{{ $g->id }}">
                        {{ $g->name }} ({{ $g->paintings_count }})
                    </option>
                @endforeach
            </x-tmk.form.select>
        </div>
        <div class="col-span-5 md:col-span-3 lg:col-span-2">
            <x-jet-label for="perPage" value="Paintings per page"/>
            <x-tmk.form.select id="perPage" wire:model="perPage" class="block mt-1 w-full">
                                    @foreach([3,6,9,12,15,18,24] as $paintingsPerPage)
                                        <option value="{{$paintingsPerPage}}">{{$paintingsPerPage}}</option>
                                    @endforeach
            </x-tmk.form.select>
        </div>
        <div class="col-span-10 lg:col-span-3">
            <x-jet-label for="price">Price &le;
                <output id="pricefilter" name="pricefilter">{{ $price }}</output>
            </x-jet-label>
            <x-jet-input type="range" id="price" name="price"
                         wire:model.debounce.500ms="price"
                         min="{{ $priceMin }}"
                         max="{{ $priceMax }}"
                         oninput="pricefilter.value = price.value"
                         class="block mt-4 w-full h-2 bg-indigo-100 accent-indigo-600 appearance-none"/>
        </div>
    </div>

{{--     master section: cards with paginationlinks--}}
    <div class="my-4">{{ $paintings->links() }}</div>

        <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8 mt-8">

    {{--         No paintings found--}}
            @if($paintings->isEmpty())
                <x-tmk.alert type="danger" class="w-full">
                    Can't find any artist or painting with <b>'{{ $name }}'</b> for this genre
                </x-tmk.alert>
            @endif

            @foreach ($paintings as $painting)
                <div
                    wire:key="painting-{{ $painting->id }}"
                     class="flex bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                    <img class="w-52 h-52 border-r border-gray-300 object-cover"
{{--                         src="/painting/{{ $painting->title }}.jpg" alt="{{ $painting->title }}"--}}
                         src="{{ is_null($painting->image) ? \Storage::url("painting/$painting->title") . '.jpg' : $painting->image }}" alt="{{ $painting->title }}"
                         alt="{{ $painting->title }}"
                         title="{{ $painting->title }}">
                    <div class="flex-1 flex flex-col">
                        <div class="flex-1 p-4">
                            <p class="text-lg font-medium">{{ $painting->artist }}</p>
                            <p class="italic pb-2">{{ $painting->title }}</p>
                            <p class="italic font-thin text-right pt-2 mb-2">{{ $painting->genre_name }}</p>
                        </div>
                        <div class="flex justify-between border-t border-gray-300 bg-gray-100 px-4 py-2">
                            <div>{{ $painting->price_euro }}</div>
                            <div class="flex space-x-4">
                                @if($painting->stock > 0)
                                    <div class="w-6 cursor-pointer hover:text-red-900">
                                        <x-phosphor-shopping-bag-light
                                            class="outline-0"
                                            data-tippy-content="Add to basket<br><span class='text-red-300'>NOT IMPLEMENTED YET</span>" />
                                    </div>
                                @else
                                    <p class="font-extrabold text-red-700">STOLEN!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    <div class="my-4">{{ $paintings->links() }}</div>

{{--     Detail section--}}
</div>
