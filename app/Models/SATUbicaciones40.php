<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SATUbicaciones40 extends Model
{
    protected $connection = 'sqlite_sat_cUbicaciones40';
    protected $table = 'c_Estado';
    protected $primaryKey = 'c_Estado';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $cast = [
        'c_Estado' => 'string',
        'Nombredelestado' => 'string',
    ];
}