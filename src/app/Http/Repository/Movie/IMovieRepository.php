<?php

namespace App\Http\Repository\Movie;

use Illuminate\Database\Eloquent\Model;

interface IMovieRepository
{
    public function createFromArray(array $movie): ?Model;
}
