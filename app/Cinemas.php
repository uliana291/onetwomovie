<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
    protected $guarded = [];
    protected $table = "cinemas";
    public $timestamps = false;

    public static function store(Array $cinema)
    {
        $cinema = array_only($cinema, array('id', 'title', 'cityId', 'address', 'location'));
        $cinema['city_id'] = $cinema['cityId'];
        unset($cinema['cityId']);
        $cinema['longitude'] = $cinema['location']['longitude'];
        $cinema['latitude'] = $cinema['location']['latitude'];
        unset($cinema['location']);
        $cinemas = Cinemas::firstOrNew(array('id' => $cinema['id']));
        $cinemas->save();
        $cinemas->update($cinema);
    }

    public function getSeances()
    {
        return $this->hasMany("\App\Seances", "cinema_id", "id");
    }

}
