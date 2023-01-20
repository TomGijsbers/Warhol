<x-warholshop-layout>
    <x-slot name="description">Admin paintings</x-slot>
    <x-slot name="title">Paintings</x-slot>

    <h2>Paintings with a price ≤ € 20.000.00$</h2>
    <div class="mb-4">{{ $paintings->withQueryString()->links() }}</div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
        @foreach ($paintings as $painting)
            <div class="flex space-x-4 bg-white shadow-md rounded-lg p-4 ">

                <div class="flex-1 relative">
                    <p class="text-lg font-medium">{{ $painting->artist }}</p>
                    <p class="italic text-right pb-2 mb-2 border-b border-gray-300">{{ $painting->title }}</p>
                    <p>{{ $painting->genre_name }}</p>
                    <p>Price: {{ $painting->price_euro }}</p>
                    @if($painting->stock > 0)
                        <p>Stock: {{ $painting->stock }}</p>
                    @else
                        <p class="absolute bottom-4 right-0 -rotate-12 font-bold  text-red-500">STOLEN</p>
                    @endif
                    <p></p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mb-4">{{ $paintings->withQueryString()->links() }}</div>

    <h2>Genres with painting</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @foreach ($genres as $genre)
            <div class="flex space-x-4 bg-white shadow-md rounded-lg p-4">
                <div class="flex-none w-36 border-r border-gray-200">
                    <h3 class="font-bold text-xl">{{ $genre->name }}</h3>
                    <p>Has {{ $genre->paintings()->count() }} {{ Str::plural('painting', $genre->paintings()->count()) }}</p>
                </div>
                <div>
                    @foreach($genre->paintings as $painting)
                        <x-tmk.list class="list-outside ml-4">
                            <li>
                                <span class="font-bold">{{ $painting->artist }}</span><br>
                                {{ $painting->title }}
                            </li>
                        </x-tmk.list>

                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-warholshop-layout>


