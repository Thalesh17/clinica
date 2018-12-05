<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table    = "uf_estado";
    protected $fillable = ['uf', 'estado'];
}