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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        DB::table('genres')->insert(
            [
                ['name' => 'Renaissance Art',      'created_at' => now()],
                ['name' => 'Romanticism',          'created_at' => now()],
                ['name' => 'Neoclassicism',    'created_at' => now()],
                ['name' => 'Academic Art',      'created_at' => now()],
                ['name' => 'Ancient Art',      'created_at' => now()],
                ['name' => 'Realism',         'created_at' => now()],
                ['name' => 'Pop Art',        'created_at' => now()],
                ['name' => 'Ukiyo-e',          'created_at' => now()],
                ['name' => 'Japonism',       'created_at' => now()],
                ['name' => 'Baroque',         'created_at' => now()],
                ['name' => 'Dutch Golden Age',    'created_at' => now()],
                ['name' => 'Impressionism',         'created_at' => now()],
                ['name' => 'Neo-impressionism',       'created_at' => now()],
                ['name' => 'Fauvism',        'created_at' => now()],
                ['name' => 'Expressionism',          'created_at' => now()],
                ['name' => 'Surrealism',       'created_at' => now()],
                ['name' => 'Contemporary Art',       'created_at' => now()],
                ['name' => 'Cubism',       'created_at' => now()],
                ['name' => 'Folk Art',       'created_at' => now()],
                ['name' => 'Art Nouveau',          'created_at' => now()],
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
        Schema::dropIfExists('genres');
    }
};
