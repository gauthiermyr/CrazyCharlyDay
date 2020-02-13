<?php

namespace crazycharlyday\models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    protected $table = 'account';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function toArray() {
        return $this->getAttributes();
    }

}