<?php

namespace App\Http\Repository\Movie;

use App\Http\Repository\BaseRepository;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;

class MovieRepository extends BaseRepository implements IMovieRepository
{
    protected static $model;

    public function __construct(Movie $model)
    {
        self::$model = $model;
    }

    public function createFromArray(array $movie): ?Model
    {
        //prevent movie duplication
        if (self::$model->where('title', $movie['title'])->count() > 0) {
            return self::$model->where('title', $movie['title'])->first();
        }

        $movieModel = self::$model->create([
            'adult' => (bool) $movie['adult'],
            'backdrop_path' => \strlen($movie['backdrop_path']) > 255 ? \substr($movie['backdrop_path'], 0, 255) : $movie['backdrop_path'], //cut string if length exceeded DB constraint
            'original_language' => \strlen($movie['original_language']) > 255 ? \substr($movie['original_language'], 0, 255) : $movie['original_language'],
            'original_title' => \strlen($movie['original_title']) > 255 ? \substr($movie['original_title'], 0, 255) : $movie['original_title'],
            'overview' => $movie['overview'],
            'popularity' => \number_format($movie['popularity'], 2, '.', ''),
            'poster_path' => \strlen($movie['poster_path']) > 255 ? \substr($movie['poster_path'], 0, 255) : $movie['poster_path'],
            'release_date' => $movie['release_date'],
            'title' => \strlen($movie['title']) > 255 ? \substr($movie['title'], 0, 255) : $movie['title'],
            'vote_average' => \number_format($movie['vote_average'], 2, '.', ''),
            'vote_count' => $movie['vote_count'],
        ]);
        //attach genres
        if (\array_key_exists('genre_ids', $movie) && \count($movie['genre_ids']) > 0) {
            $genres = Genre::whereIn('genre_id', $movie['genre_ids'])->get()->pluck('id');
            if (\count($genres) > 0) {
                $movieModel->genres()->attach($genres);
            }
        }

        return $movieModel;
    }

    public function paginate(?int $perPage = null, array $columns = ['*'], string $pageName = 'page', ?int $page = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return self::$model->filter()->paginate($perPage, $columns, $pageName, $page);
    }
}
