<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->boolean('adult')->default(false);
            $table->string('backdrop_path')->nullable();
            $table->string('original_language')->nullable();
            $table->string('original_title')->nullable();
            $table->text('overview')->nullable();
            $table->decimal('popularity')->default(0);
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->string('title')->unique(); //it should be the Slug
            $table->decimal('vote_average')->nullable();
            $table->integer('vote_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
