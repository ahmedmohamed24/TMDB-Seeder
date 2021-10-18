<?php

namespace App\Http\Repository\Movie;

use Illuminate\Database\Eloquent\Model;

interface IMovieRepository
{
    public function createFromArray(array $movie): ?Model;

    public function paginate(?int $perPage = null, array $columns = ['*'], string $pageName = 'page', ?int $page = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
