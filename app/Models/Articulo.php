<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
   

    public function grupos(){        
        // tiene muchos
        return $this->hasMany(Articulo::class,'grupo_portada','codigo')->orderBy('n_orden');
    }   
}