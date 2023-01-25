<div>
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-jet-input id="search" type="text" placeholder="Filter Artist Or Painting"
                         wire:model.debounce.500ms="search"
                         class="w-full shadow-md placeholder-gray-300"/>
        </div>
        <x-tmk.form.switch id="noStock"
                           wire:model="noStock"
                           text-off="No stock"
                           color-off="bg-gray-100 before:line-through"
                           text-on="No stock"
                           color-on="text-white bg-lime-600"
                           class="w-20 h-11"/>
{{--        <x-tmk.form.switch id="noCover"--}}
{{--                           text-off="Painting without canvas"--}}
{{--                           color-off="bg-gray-100 before:line-through"--}}
{{--                           text-on="Records without cover"--}}
{{--                           color-on="text-white bg-lime-600"--}}
{{--                           class="w-44 h-11"/>--}}
        <x-jet-button wire:click="setNewPainting()">
            new Painting
        </x-jet-button>
    </x-tmk.section>

    <x-tmk.section>
        <div class="my-4">{{ $paintings->links() }}</div>
        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-14">
                <col class="w-20">
                <col class="w-20">
                <col class="w-14">
                <col class="w-max">
                <col class="w-24">
            </colgroup>
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>#</th>
                <th></th>
                <th>Price</th>
                <th>Stock</th>
                <th class="text-left">Painting</th>
                <th>
                    <x-tmk.form.select id="perPage"
                                       wire:model="perPage"
                                       class="block mt-1 w-full">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </x-tmk.form.select>
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($paintings as $painting)
            <tr wire:key="painting_{{ $painting->id }}"
                class="border-t border-gray-300">
                <td>{{ $painting->id }}</td>
                <td>
                    <img src="{{ is_null($painting->image) ? \Storage::url("painting/$painting->title") . '.jpg' : $painting->image }}"
                         onerror="this.onerror=null;this.src='/404.png';" alt="{{ $painting->title }} by {{ $painting->artist }}"
                         class="my-2 border object-cover">
                </td>
                <td>{{ $painting->price_euro }}</td>
                <td>{{ $painting->stock }}</td>
                <td class="text-left">
                    <p class="text-lg font-medium">{{ $painting->artist }}</p>
                    <p class="italic">{{ $painting->title }}</p>
                    <p class="text-sm text-teal-700">{{ $painting->genre_name }}</p>
                </td>
                <td>
                    <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                        <button
                            wire:click="setNewPainting({{ $painting->id }})"
                            class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                        </button>
                        <button
                            x-data=""
                            @click="confirm('Are you sure you want to delete this painting?') ? $wire.deletePainting{{ $painting->id }}) : ''"
                            class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                            <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            </tbody>
            @endforelse
        </table>
        <div class="my-4">{{ $paintings->links() }}</div>
    </x-tmk.section>

    <x-jet-dialog-modal  id="paintingModal"
                         wire:model="showModal">
        <x-slot name="title">
            <h2>{{ is_null($newPainting['id']) ? 'New painting' : 'Edit painting' }}</h2>
        </x-slot>
        <x-slot name="content">
            @if ($errors->any())
                <x-tmk.alert type="danger">
                    <x-tmk.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-tmk.list>
                </x-tmk.alert>
            @endif

                <div class="flex flex-row gap-4 mt-4">
                    <div class="flex-1 flex-col gap-2">
                        <x-jet-label for="title" value="Title" class="mt-4" />
                        <x-jet-input id="title" type="text" wire:model.defer="newPainting.title"
                                     class="mt-1 block w-full" placeholder="Title" />

                        <x-jet-label for="genre_id" value="Genre" class="mt-4" />
                        <x-tmk.form.select wire:model.defer="newPainting.genre_id" id="genre_id" class="block mt-1 w-full">
                            <option value="">Select a genre</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </x-tmk.form.select>

                        <x-jet-label for="price" value="Price" class="mt-4" />
                        <x-jet-input id="price" type="number" step="0.01" wire:model.defer="newPainting.price"
                                     class="mt-1 block w-full" placeholder="Price" />

                        <x-jet-label for="artist" value="Artist" class="mt-4" />
                        <x-jet-input id="artist" type="text" wire:model.defer="newPainting.artist"
                                     class="mt-1 block w-full" placeholder="Artist" />

                        <x-jet-label for="stock" value="Stock" class="mt-4" />
                        <x-jet-input id="stock" type="number" wire:model.defer="newPainting.stock"
                                     class="mt-1 block w-full" placeholder="Stock" />

                        <x-jet-label for="image" class="mt-2" value="Upload your painting" />
                        <div class="flex flex-row gap-2 mt-4">
                            <x-jet-input id="image" type="file" placeholder="Upload your own painting"
                                         wire:model.defer="newPainting.image" class="flex-1" />
                            <div class="mt-2" wire:loading wire:target="newPainting.image">
                                Uploading Image...
                            </div>
                        </div>
                    </div>

                    @if ($newPainting['image'])
                        <img src="{{ $newPainting['image'] }}" alt="New Image"
                             class="mt-4 w-40 h-40 border border-gray-300 object-cover">
                    @endif
                </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button @click="show = false">Cancel</x-jet-secondary-button>
            @if (is_null($newPainting['id']))
                <x-jet-button wire:click="createPainting()" wire:loading.attr="disabled" class="ml-2">Save new
                    painting
                </x-jet-button>
            @else
                <x-jet-button color="success" wire:click="updatePainting({{ $newPainting['id'] }})"
                              wire:loading.attr="disabled" class="ml-2">Update painting
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
