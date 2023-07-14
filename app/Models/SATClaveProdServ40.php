<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SATClaveProdServ40 extends Model
{
    protected $connection = 'sqlite_sat_cProductosUnidades40';
    protected $table = 'c_ClaveProdServ';
    protected $primaryKey = 'c_ClaveProdServ';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $cast = [
        'c_ClaveProdServ' => 'string',
        'Descripción' => 'string',
        'IncluirIVAtrasladado' => 'string',
        'IncluirIEPStrasladado' => 'string',
        'Complementoquedebeincluir' => 'string',
        'FechaInicioVigencia' => 'date',
        'EstímuloFranjaFronteriza' => 'boolean',
        'Palabrassimilares' => 'string',
    ];
}