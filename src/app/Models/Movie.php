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
}
