<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index(){
        $articulos =  Articulo::join('familias','articulos.familia_id','=','familias.id')
        ->get(['articulos.*','familias.nomfam']);
        return response()->json([
            'articulos' => $articulos
        ],200);
    }
    public function updateGroup(Request $request, Articulo $articulo)
    {
        $articulo->agrupado_por = $request->agrupado_por;
        $articulo->grupo_portada = $request->grupo_portada;
        $articulo->n_orden = $request->n_orden;
        $articulo->caracteristica = $request->caracteristica;

        $articulo->grupo_general = $request->grupo_general;
        $articulo->d1 = $request->d1;
        $articulo->c1 = $request->c1;

        $articulo->save();


        return response()->json([
            "success" => true,
            "message" => "Productos agrupados correctamente."
        ]);


    }
}
