<?php

namespace App;
use DB;
use Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\PeliculaNotification;
use Notification;
use Input;
use Auth;

class Pelicula extends Model
{
use SoftDeletes;

protected $primaryKey="idPelicula" ;
protected $table="peliculas";
public $timestamps=true;
public $fillable = ['titulo','duracion','anio','imagen', 'idUser'];

protected $dates = ['deleted_at'];


protected $hidden = ['pivot'];

public function usuario()
{
    return $this->belongsTo('\App\User', 'idUser');
}


public function generos(){
    return $this->belongsToMany('\App\Genero','peliculas_generos','idPelicula','idGenero');
}
public function actores(){
    return $this->belongsToMany('\App\Actor','peliculas_actores','idPelicula','idActor');
}
 

public function scopeCortas($query){
    return $query->where('duracion','<','120');
} 
// CONST CREATED_AT ='fecha_registro';

public function scopeAcCtuales($query){
    return $query->where('anio','2018');
}

public function scopeActuales($query){
    return $query->where('anio',date('Y'));
}
public function scopeAgrupar($query){
    return $query->select('anio',DB::raw('count(*) as resgistros'))
    ->groupBy('anio','duracion');
}
public static function findGenero($array, $idGenero)
    {
        foreach ($array as $item) {
            foreach ($item as $value) {
                if ($value == $idGenero) {
                    return true;
                }
            }
        }
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pelicula) { // before delete() method call this
            $pelicula->generos()->detach();
            $pelicula->actores()->detach();
            // if ($pelicula->imagen != null) {
            //     Storage::delete($pelicula->imagen);
            // }
        });


        static::creating(function ($pelicula) {
            $pelicula->idUser = Auth::id();
            if (Input::hasFile('imagen') && $pelicula->imagen != null) {
                $image = Input::file('imagen');
                $pelicula->imagen = $image->store('public/peliculas');
            }
        });

        static::restored(function ($pelicula) {
            $user = Auth::user();
            $user->notify(new peliculaNotification($pelicula, true));
        });

 


    }


}
