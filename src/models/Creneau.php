<?php


namespace crazycharlyday\models;


use Illuminate\Database\Eloquent\Model;

class Creneau extends Model {

    protected $table = 'creneau';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function toArray() {
        $this->getAttributes();
    }
}