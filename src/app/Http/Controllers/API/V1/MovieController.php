<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Repository\Movie\IMovieRepository;
use App\Http\Traits\ApiResponse;
use App\Models\Genre;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use ApiResponse;
    protected $moviesRepository;

    public function __construct(IMovieRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function index(Request $request)
    {
        if ($request->has('category_id')) {
            $genre = Genre::where('genre_id', $request->get('category_id'))->firstOrFail();
            $movies = $genre->movies()->paginate();
        } else {
            $movies = $this->moviesRepository->paginate();
        }

        return $this->response(200, 'success', \null, $movies);
    }
}
