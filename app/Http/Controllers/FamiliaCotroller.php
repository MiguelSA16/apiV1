<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticuloResource;
use App\Http\Resources\FamiliaResource;
use App\Models\Articulo;
use App\Models\Familia;

class FamiliaCotroller extends Controller
{
    public function index(){
        
        //$familia = new ResourcesFamilia(Familia::find(409));        
        //$familia = new FamiliaCollection(Familia::all()->keyBy->id);

        $familia = FamiliaResource::
            collection(
                Familia::where('claparent','0')
                ->where('baja_web','FALSO')
                ->where('id','!=','567')
                ->get());
        
        return response()->json([
            'familias' => $familia
        ],200);
    }

    public function listar_articulos($slug)
    {
        $familia_actual = new FamiliaResource(Familia::where('url', $slug)->first());
            
        $articulos = ArticuloResource::
            collection(
                Articulo::where('familia_id', $familia_actual->id)
                ->where('grupo_portada','portada')
                ->where('baja','0')
                ->orderBy('n_orden')
                ->get());        

        return response()->json([
            'articulos' => $articulos,
            'familia'   => $familia_actual,
        ],200);
    }

    public function familia($slug)
    {
        $familia = Familia::where('url',$slug)->first();
        return response()->json(
            $familia, 200);
        //return $familia;
    }
}
