<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['genre_id', 'name'];

    public function movies()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }
}
