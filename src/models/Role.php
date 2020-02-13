<?php


namespace crazycharlyday\models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'role';
    protected $primaryKey = 'libelle';
    protected $keyType = 'string';
    public $timestamps = false;

    public function toArray() {
        $this->getAttributes();
    }
}