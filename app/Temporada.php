<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    public function episodios()
    {
        return $this->hasMany(Episodio::class); // relação de episodios com uma temporada
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class); //aqui informa a relação de temporadas com uma serie (belongs to: pertence a)
    }
}
