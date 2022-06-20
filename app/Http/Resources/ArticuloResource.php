<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticuloResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'                => $this->id,
            'nombre'            => $this->nombre,
            'referencia'        => $this->codigo,
            'portada'           => $this->portada,
            'imagen'            => $this->imagen,
            'agrupado_por'      => $this->agrupado_por,
            'caracteristica'    => $this->caracteristica,
            'orden'             => $this->n_orden,
            'baja'              => $this->baja,
            'g_articulos'       => ArticuloResource::collection($this->grupos),
 
        ];
    }
}
