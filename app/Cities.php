<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $guarded = [];
    protected $table = "cities";
    public $timestamps = false;

    public static function store(Array $city)
    {
        $city = array_only($city,array('id', 'title', 'alias'));
        $city['city'] = $city['title'];
        unset($city['title']);
        $cities = Cities::firstOrNew($city);

        $cities->save();
    }
}
