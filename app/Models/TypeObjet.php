<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeObjet extends Model
{
    protected $table = 'types_objets';

    protected $fillable = ['nom'];

    public function objets()
    {
        return $this->hasMany(\App\Models\ObjetConnecte::class);
    }
}
