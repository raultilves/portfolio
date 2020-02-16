<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','fecha','descripcion'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }

    public function getFoto() {
        return Storage::disk('s3')->get($this->foto);
    }

}
