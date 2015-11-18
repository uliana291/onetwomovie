<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MoviesGenres;

class Movies extends Model
{
    protected $guarded = [];
    protected $table = "movies";
    public $timestamps = false;

    public static function store(Array $movie)
    {
        $movie = array_only($movie, array('id', 'title', 'duration', 'originalTitle', 'productionYear', 'genres', 'images',
            'rating', 'poster', 'ageRestriction'));

        $movie['original_title'] = $movie['originalTitle'];
        unset($movie['originalTitle']);
        $movie['production_year'] = $movie['productionYear'];
        unset($movie['productionYear']);
        $movie['age_restriction'] = $movie['ageRestriction'];
        unset($movie['ageRestriction']);

        if ($movie['genres'] <> null) {
            $genre = [];
            foreach ($movie['genres'] as $key => $value) {
                $genre['genre_id'] = $value['id'];
                $genre['movie_id'] = $movie['id'];
                $mGenre = MoviesGenres::firstOrNew($genre);
                $mGenre->save();
            }
        }
        unset($movie['genres']);


        $images = json_encode($movie['images']);

        $movie['images'] = $images;

        $poster = json_encode($movie['poster']);

        $movie['poster'] = $poster;

        foreach ($movie as $key => $value) {
            if ($value == null)
                unset($movie[$key]);
        }

        $movies = Movies::firstOrNew($movie);

        $movies->save();
    }
}
