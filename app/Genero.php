<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\GeneroNotification;
use Notification;
use OneSignal;
use Lang;
class Genero extends Model
{
    use SoftDeletes;

    protected $primaryKey="idGenero";
    protected $table="generos";
    public $timestamps=true;

    protected $fillable = ['nombre'];
    protected $hidden = ['pivot'];

    protected $dates = ['deleted_at'];

    public function peliculas(){
        return $this->belongsToMany('\App\Pelicula', 'peliculas_generos','idGenero', 'idPelicula');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($genero) {
            $route=route("generos.index");
            OneSignal::sendNotificationToAll("Se envio el género a papalera". $genero->nombre." A las ".$genero->deleted_at, $route, null,null, null);
            $user = Auth::user();
            $user->notify(new GeneroNotification($genero));
        });
        static::restored(function ($genero) {
            $user = Auth::user();
            $user->notify(new GeneroNotification($genero, true));
        });

    }

    public static function findPelicula($array, $idPelicula)
    {
        foreach ($array as $item) {
            foreach ($item as $value) {
                if ($value == $idPelicula) {
                    return true;
                }
            }
        }
        return false;
    }


}
