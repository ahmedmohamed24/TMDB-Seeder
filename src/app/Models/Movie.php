<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['adult', 'backdrop_path', 'original_language', 'original_title', 'overview', 'popularity', 'poster_path', 'release_date', 'title', 'vote_average', 'vote_count'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    /**
     * Scope a query to only include.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed                                 $q
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query)
    {
        if (request()->has('original_language')) {
            $query->where('original_language', \request('original_language'));
        }
        if (\request()->has('popular') && ('desc' === \request('popular') || 'asc' === \request('popular'))) {
            $query->orderBy('popularity', \request('popular'));
        }
        if (\request()->has('rated') && ('desc' === \request('rated') || 'asc' === \request('rated'))) {
            $query->orderBy('vote_average', \request('rated'));
        }
        if (\request()->has('recently') && ('desc' === \request('recently') || 'asc' === \request('recently'))) {
            $query->orderBy('created_at', \request('recently'));
            $query->orderBy('id', \request('recently')); //if time is equal, order by id
        }

        return $query;
    }
}
