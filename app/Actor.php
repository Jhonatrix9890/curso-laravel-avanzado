<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Storage;
use App\Notifications\ActorNotification;
use Input;
use Lang;

class Actor extends Model
{
    use SoftDeletes;
    protected $primaryKey="idActor" ;
    protected $table="actores" ;
    public $timestamps=true;
    public $fillable = ['nombres','apellidos','imagen'];
    protected $hidden = ['pivot'];

    protected $dates = ['deleted_at'];


    public function peliculas(){
        return $this->belongsToMany('\App\Pelicula','peliculas_actores','idActor','idPelicula');
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

/*     protected static function boot()
    {
        parent::boot();

        static::deleting(function ($actor) { // before delete() method call this
            $actor->peliculas()->detach();
            if($actor->imagen != null){
                Storage::delete($actor->imagen);
            }
        });
    } */

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($actor) {
            info('deleted');
            $user = Auth::user();
            $user->notify(new ActorNotification($actor));
        });
        static::restored(function ($actor) {
            $user = Auth::user();
            $user->notify(new ActorNotification($actor, true));
        });
        static::creating(function ($actor) {
            if (Input::hasFile('imagen') && $actor->imagen != null) {
                $image = Input::file('imagen');
                $actor->imagen = $image->store('public/actores');
            }
        });

    }

   

    
}
