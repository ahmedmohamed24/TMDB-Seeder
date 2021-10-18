<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class MoviesTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    // @test
    public function testStatus200WhenListMovies()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/v1/movies');
        $response->assertStatus(200);
    }

    // @test
    public function testPageNumberReturnedInAllMoviesList()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/v1/movies');
        $response->assertJsonFragment(['current_page' => 1]);
    }

    public function testStoredMovieRetrievedInList()
    {
        $this->withoutExceptionHandling();
        Movie::factory()->create();
        $response = $this->getJson('/api/v1/movies');
        $this->assertEquals(1, $response['data']['total']);
    }

    public function testFilterMoviesReturnedOnlyRelatedToCategory()
    {
        $this->withoutExceptionHandling();
        Genre::factory()->create(['name' => 'comedy', 'genre_id' => 1]);
        Genre::factory()->create(['name' => 'action', 'genre_id' => 2]); //default name
        $movie1 = Movie::factory()->create();
        $movie2 = Movie::factory()->create();
        $movie1->genres()->attach(1);
        $movie2->genres()->attach(2);
        $response = $this->getJson('/api/v1/movies?category_id=1');
        $this->assertEquals(1, $response['data']['total']);
    }

    public function testFilterMoviesByOriginalLanguage()
    {
        $this->withoutExceptionHandling();
        Genre::factory()->create(['name' => 'comedy', 'genre_id' => 1]);
        Genre::factory()->create(['name' => 'action', 'genre_id' => 2]); //default name
        $movie1 = Movie::factory()->create(['original_language' => 'ar']);
        $movie2 = Movie::factory()->create(['original_language' => 'en']);
        $movie1->genres()->attach(1);
        $movie2->genres()->attach(2);
        $response = $this->getJson('/api/v1/movies?original_language=en');
        $this->assertEquals(1, $response['data']['total']);
    }

    public function testSortingMoviesByPopularity()
    {
        $this->withoutExceptionHandling();
        Movie::factory()->create(['popularity' => 100]);
        Movie::factory()->create(['popularity' => 200]);
        Movie::factory()->create(['popularity' => 300]);
        $response = $this->getJson('/api/v1/movies?popular=desc');
        $this->assertEquals(3, $response['data']['data'][0]['id']);
        $response = $this->getJson('/api/v1/movies?popular=asc');
        $this->assertEquals(1, $response['data']['data'][0]['id']);
    }

    public function testSortingMoviesByRating()
    {
        $this->withoutExceptionHandling();
        Movie::factory()->create(['vote_average' => 100]);
        Movie::factory()->create(['vote_average' => 200]);
        Movie::factory()->create(['vote_average' => 300]);
        $response = $this->getJson('/api/v1/movies?rated=desc');
        $this->assertEquals(3, $response['data']['data'][0]['id']);
        $response = $this->getJson('/api/v1/movies?rated=asc');
        $this->assertEquals(1, $response['data']['data'][0]['id']);
    }
}
