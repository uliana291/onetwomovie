<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviesGenres extends Model
{
    protected $guarded = [];
    protected $table = "movies_genres";
    public $timestamps = false;

    public function getGenre() {
        return $this->hasOne("\App\Genres","id","genre_id");
    }

}
