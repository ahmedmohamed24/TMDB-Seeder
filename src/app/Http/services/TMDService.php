<?php

namespace App\Http\services;

use App\Http\Repository\Movie\IMovieRepository;
use App\Models\Genre;
use App\Models\Movie;

class TMDService
{
    protected $movieRepository;

    public function __construct(IMovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getTopRatedMovies($page = 1)
    {
        $this->getMoviesByCategory('top_rated', $page);
    }

    public function getGenres()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://api.themoviedb.org/3/genre/tv/list?api_key='.\env('TMD_API_KEY').'&language=en-US&id=2');
        if (200 == $response->getStatusCode()) {
            $response = json_decode($response->getBody()->getContents(), true);
            if (\array_key_exists('genres', $response)) {
                $genres = $response['genres'];
                foreach ($genres as $genre) {
                    Genre::create([
                        'genre_id' => $genre['id'],
                        'name' => $genre['name'],
                    ]);
                }
            }
        }
    }

    private function getMoviesByCategory($category, $page)
    {
        //fetch using curl or GuzzleHTTP
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://api.themoviedb.org/3/movie/'.$category.'?api_key='.\env('TMD_API_KEY').'&language=en-US&page='.$page);

        if (200 == $response->getStatusCode()) {
            $response = json_decode($response->getBody()->getContents(), true);
            if (\array_key_exists('results', $response)) {
                //validate allowed {num_of_records} in .env
                $moviesCount = Movie::count();
                if ($moviesCount + 20 > \config('movies.num_of_records')) {//20 -> number of records returned from API per request
                    $restNumOfMovies = \config('movies.num_of_records') - $moviesCount;
                    if ($restNumOfMovies <= 0) {
                        //to avoid infinity loop
                        return;
                    }
                    $movies = $response['results'];
                    foreach ($movies as $index => $movie) {
                        if ($index >= $restNumOfMovies) {
                            return;
                        }
                        $this->movieRepository->createFromArray($movie);
                    }
                } else {
                    $movies = $response['results'];
                    foreach ($movies as $movie) {
                        $this->movieRepository->createFromArray($movie);
                    }
                }
            }
        }
    }
}
