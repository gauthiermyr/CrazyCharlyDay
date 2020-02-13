<?php


namespace crazycharlyday\models;


use Illuminate\Database\Eloquent\Model;

class Poste extends Model {

    protected $table = 'poste';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function toArray() {
        $this->getAttributes();
    }
}