<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actor;
use App\Pelicula;
use Illuminate\Database\QueryException;
use Auth;
use App\Jobs\ProcessEmail;
use App\Notifications\ActorNotification;
use Notification;
use App\Http\Requests\ActorRequest;
use Lang;




class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_api()
    {
        // $actores =  Actor::withCount('peliculas')->orderByDesc('nombres')
        // ->paginate(10);
        // return view('panel.actores.index', compact('actores'));


        $actores = Actor::withCount('peliculas')->orderBy('apellidos')->get();
        return $actores->toJson();

       /*  $query=Actor::query();
        $query=$query->withCount('peliculas')->orderBy('nombres');  
        if($request->display == "all"){
            $query =$query->withTrashed();
        }else if($request->display == "trash"){
            $query =$query->onlyTrashed();
        }
        $actores = $query->paginate(10);
        return view('panel.actores.index', compact('actores'));
 */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $peliculas=Pelicula::orderBy('titulo')->get(['idPelicula','titulo']);
        return view("panel.actores.create",compact('peliculas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {

        return Actor::create($request->all());
/*          try{
            $actor=Actor::create($request->except(['idPelicula']));
/*            if ($request->hasFile('imagen')&& $request->imagen!=null) {
                $actor->imagen = $request->file('imagen')->store('public/actores');
                $actor->save();
            }
         //   
            $actor->peliculas()->sync($request->idPelicula);

            return redirect('actores')->with('success','Actor registrado');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()])->withInput();
        }  */
      
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $actor=Actor::with(['peliculas' => function ($query) {
                $query->select('titulo');
            }])->findOrFail($id);
        return view("panel.actores.show",compact('actor'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actor=Actor::with(['peliculas' => function ($query) {
            $query->select('peliculas.idPelicula');
        }])->findOrFail($id);
        $peliculas=Pelicula::orderBy('titulo')->get(['idPelicula','titulo']);
        $gens=collect($actor->peliculas)->sortBy('idPelicula')->toArray();
        return view("panel.actores.edit",compact('actor','peliculas','gens'));

        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $actor=Actor::updateOrCreate(['idActor'=>$id],$request->except('idPelicula'));
            $actor->peliculas()->sync($request->idPelicula);
            return redirect('actores')->with('success','actor actualizada');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            
            try{
                Actor::withTrashed()->where('idActor',$id)->forceDelete();
              
                return redirect('actores?display=trash')->with('success','Actor eliminado permanentemente');
            }catch(Exception | QueryException $e){
                return back()->withErrors(['exception'=>$e->getMessage()]);
            }
    }

    public function restore($id)
    {
        try{
          $act=  Actor::withTrashed()->where('idActor',$id)->restore();//devuelve el numero de generos restaurados
            info($act);
      
            return redirect('actores')->with('success','Actor restaurado');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try {
            Actor::destroy($id);

            return redirect('actores')->with('success', 'Actor enviado a papelera');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }       

    }


}
