<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('artist');
            $table->string('title');
            $table->float('price', 8, 2)->default(100.999);
            $table->unsignedInteger('stock')->default(1);
            $table->timestamps();
//            $table->string('file_path');
        });


        DB::table('paintings')->insert(
            [
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Leonardo Da Vinci',
                    'title' => 'Mona Lisa',
                    'price' => 94999.99,
                    'file_path' => 'Mona Lisa.jpg'
                ],
                [
                    'genre_id' => 11,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Johannes Vermeer',
                    'title' => 'Girl with a Pearl Earring',
                    'price' => 82221.00
                ],
                [
                    'genre_id' => 13,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Vincent van Gogh',
                    'title' => 'The Starry Night',
                    'price' => 63924.99
                ],
                [
                    'genre_id' => 17,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Gustav Klimt',
                    'title' => 'The Kiss',
                    'price' => 2212.50
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Sandro Botticelli',
                    'title' => 'The Birth of Venus',
                    'price' => 6419.99
                ],
                [
                    'genre_id' => 17,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'James Abbott McNeill Whistler',
                    'title' => 'Arrangement in Grey and Black',
                    'price' => 3524.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Michelangelo',
                    'title' => 'The Creation of Adam',
                    'price' => 81419.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Jan van Eyck',
                    'title' => 'The Arnolfini Portrait',
                    'price' => 8119.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'Hieronymus Bosch',
                    'title' => 'The Garden of Earthly Delights',
                    'price' => 4224.00
                ],
                [
                    'genre_id' => 12,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'Georges Seurat',
                    'title' => 'A Sunday Afternoon on the Island of La Grande',
                    'price' => 5119.99
                ],
                [
                    'genre_id' => 18,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Pablo Picasso',
                    'title' => 'Les Demoiselles d’Avignon',
                    'price' => 31616.49
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Pieter Bruegel the Elder',
                    'title' => 'The Harvesters',
                    'price' => 4225.00
                ],
                [
                    'genre_id' => 10,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Édouard Manet',
                    'title' => 'Le Déjeuner sur l’herbe',
                    'price' => 1114.00
                ],
                [
                    'genre_id' => 17,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'Piet Mondrian',
                    'title' => 'Composition with Red Blue and Yellow',
                    'price' => 1219.99
                ],
                [
                    'genre_id' => 10,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Diego Rodríguez de Silva y Velázquez',
                    'title' => 'Las Meninas, or The Family of King Philip IV',
                    'price' => 13999.99
                ],
                [
                    'genre_id' => 18,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'Pablo Picasso',
                    'title' => 'Guernica',
                    'price' => 24226.00
                ],
                [
                    'genre_id' => 10,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Francisco de Goya y Lucientes',
                    'title' => 'The Naked Maja',
                    'price' => 1999.90
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Jean Auguste Dominique Ingres',
                    'title' => 'Grande Odalisque',
                    'price' => 1315.00
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Eugène Delacroix',
                    'title' => 'Liberty Leading the People',
                    'price' => 2411.99
                ],
                [
                    'genre_id' => 17,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Claude Monet',
                    'title' => 'Sunrise',
                    'price' => 3921.50
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Caspar David Friedrich',
                    'title' => 'Wanderer above the Sea of Fog',
                    'price' => 2624.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'Théodore Géricault',
                    'title' => 'The Raft of the Medusa',
                    'price' => 1118.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'Edward Hopper',
                    'title' => 'Nighthawks',
                    'price' => 2224.99
                ],
                [
                    'genre_id' => 16,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'Marcel Duchamp',
                    'title' => 'Nude Descending a Staircase',
                    'price' => 8624.99
                ],
                [
                    'genre_id' => 11,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Johannes Vermeer',
                    'title' => 'The Concert',
                    'price' => 14315.99
                ],
                [
                    'genre_id' => 10,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Rembrandt van Rijn',
                    'title' => 'The Storm on the Sea of Galilee',
                    'price' => 71215.99
                ],
                [
                    'genre_id' => 12,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Govert Flinck',
                    'title' => 'Landscape with an Obelisk',
                    'price' => 6429.99
                ],
                [
                    'genre_id' => 12,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Paul Cézanne',
                    'title' => 'View of Auvers-sur-Oise',
                    'price' => 6316.99
                ],
                [
                    'genre_id' => 10,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Diego Velázquez',
                    'title' => 'Infante and Dog',
                    'price' => 8519.99
                ],
                [
                    'genre_id' => 13,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Vincent Van Gogh',
                    'title' => 'Poppy Flowers',
                    'price' => 28114.99
                ],
                [
                    'genre_id' => 18,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Jean Metzinger',
                    'title' => 'Man with a Pipe',
                    'price' => 1117.50
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Jacopo Palma il Giovane',
                    'title' => 'Venus with a Mirror',
                    'price' => 3147.50
                ],
                [
                    'genre_id' => 18,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Pablo Picasso',
                    'title' => 'Le pigeon aux petits pois',
                    'price' => 4322.50
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Jan van Eyck',
                    'title' => 'The Just Judges',
                    'price' => 2232.50
                ],
                [
                'genre_id' => 3,
                'created_at' => now(),
                'stock' => 1,
                'artist' => 'Jacques-Louis David',
                'title' => 'The Death of Socrates',
                'price' => 7581.50
                ],
                [
                    'genre_id' => 7,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Andy Warhol',
                    'title' => 'Marilyn Monroe',
                    'price' => 3782.50
                ],
                [
                    'genre_id' => 8,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Katsushika Hokusai',
                    'title' => 'Kanagawa-oki nami-ura',
                    'price' => 6458.50
                ],
                [
                    'genre_id' => 6,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Ilya Repin',
                    'title' => 'Ivan the Terrible and His Son Ivan',
                    'price' => 4322.50
                ],
                [
                    'genre_id' => 14,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'André Derain',
                    'title' => 'landscape near chatou',
                    'price' => 1958.00
                ],
                [
                'genre_id' => 14,
                'created_at' => now(),
                'stock' => 2,
                'artist' => 'Albert Marquet',
                'title' => 'Street Lamp',
                'price' => 4322.50
            ],

            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paintings');
    }
};
