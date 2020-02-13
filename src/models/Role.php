<?php


namespace crazycharlyday\models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'role';
    protected $primaryKey = 'libelle';
    public $timestamps = false;

    public function toArray() {
        $this->getAttributes();
    }
}