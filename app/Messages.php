<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $guarded = [];
    protected $table = "messages";

    public function getSender() {
        return $this->hasOne("\App\User","id","user_id_sent");
    }

    public function getReceiver() {
        return $this->hasOne("\App\User","id","user_id_received");
    }

    public function getSeance() {
        return $this->hasOne("\App\Seances","id","seance_id");
    }
}
