<?php

namespace App\Http\Resources;

use App\Models\Familia;
use Illuminate\Http\Resources\Json\JsonResource;

class FamiliaResource extends JsonResource
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
            'nombre'            => $this->nomfam,
            'slug'              => $this->url,
            'icono'             => $this->icono,
            'claperent'         => $this->claperent,
            'categorias'        => FamiliaResource::collection($this->categorias),
            'categoria'         => $this->padre ? $this->padre : null,
            'familia'           => $this->padre ? $this->padre->padre : null,
        ];
    }

    //public $preserveKeys=true;
}

/*
 <v-breadcrumbs-divider v-if="familia.categoria != null">/</v-breadcrumbs-divider>
                        <!--Categoria-->
                        <v-breadcrumbs-item v-if="familia.categoria != null">
                            {{familia.categoria.nomfam}}
                        </v-breadcrumbs-item>  
*/