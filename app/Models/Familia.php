<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;

    public function padre(){
        //pertenece a
        return $this->belongsTo(Familia::class,'claparent');

    }    

    public function categorias(){        
        // tiene muchos
        return $this->hasMany(Familia::class,'claparent');
    }
      
}
