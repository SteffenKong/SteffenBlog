<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $table = 'admin';

    public function login($account,$password) {

    }
}
