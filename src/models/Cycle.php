<?php


namespace crazycharlyday\models;


use Illuminate\Database\Eloquent\Model;

class Cycle extends Model {

    protected $table = 'cycle';
    protected $primaryKey = 'numero';
    public $timestamps = false;

    public function toArray() {
        $this->getAttributes();
    }
}