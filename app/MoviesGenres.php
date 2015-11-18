<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviesGenres extends Model
{
    protected $guarded = [];
    protected $table = "movies_genres";
    public $timestamps = false;

}
