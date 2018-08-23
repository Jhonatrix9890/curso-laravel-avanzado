<?php

namespace App\Http\Controllers;
use App\Pelicula;
use App\Genero;
use Illuminate\Http\Request;
use App\Http\Requests\PeliculaRequest;
use App\Actor;
use Illuminate\Database\QueryException;
use Auth;
use App\Jobs\ProcessEmail;
use App\Notifications\PeliculaNotification;
use Notification;
use Lang;




class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* $peliculas = Pelicula::withCount('generos','actores')->orderByDesc('anio')->orderBy('titulo')->paginate(10);
        return view('panel.peliculas.index', compact('peliculas'));
 */
         $query=Pelicula::query();
         $query=$query->withCount('actores','generos')->orderByDesc('anio')->orderBy('titulo');
          
         if($request->display == "all"){
             $query =$query->withTrashed();
         }else if($request->display == "trash"){
             $query =$query->onlyTrashed();
         }
         $peliculas = $query->paginate(10);
         return view('panel.peliculas.index', compact('peliculas'));

      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generos=Genero::orderBy('nombre')->get(['idGenero','nombre']);
        $actores=Actor::orderBy('nombres')->get(['idActor','nombres','apellidos']);
        return view("panel.peliculas.create",compact('generos','actores'));

   

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $pelicula=Pelicula::create($request->except(['idGenero','idActor']));
           /*  if ($request->hasFile('imagen')&& $request->imagen!=null) {
                $pelicula->imagen = $request->file('imagen')->store('public/peliculas');
                $pelicula->save();
            } */
            $pelicula->generos()->sync($request->idGenero);
            $pelicula->actores()->sync($request->idActor);
            return redirect('peliculas')->with('success','Película registrada');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()])->withInput();
        }

       

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelicula=Pelicula::with(['generos' => function ($query) {
                $query->select('nombre');
            }])->findOrFail($id);
        return view("panel.peliculas.show",compact('pelicula'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelicula=Pelicula::with(['generos' => function ($query) {
            $query->select('generos.idGenero');
        }])->findOrFail($id);
        $generos=Genero::orderBy('nombre')->get(['idGenero','nombre']);
        $gens=collect($pelicula->generos)->sortBy('idGenero')->toArray();
        $actores=Actor::orderBy('nombres')->get(['idActor','nombres', 'apellidos']);
        $acts=collect($pelicula->actores)->sortBy('idActor')->toArray();
        return view("panel.peliculas.edit",compact('pelicula','generos','gens', 'actores', 'acts'));

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
            $pelicula=Pelicula::updateOrCreate(['idPelicula'=>$id],$request->except('idGenero'));
            $pelicula->generos()->sync($request->idGenero);
            $pelicula->actores()->sync($request->idActor);
            return redirect('peliculas')->with('success','Pelicula actualizada');
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
            Genero::withTrashed()->where('idPelicula',$id)->forceDelete();
          
            return redirect('peliculas?display=trash')->with('success','Película eliminado permanentemente');
        }catch(Exception | QueryException $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }

       
    }

    public function restore($id)
    {
        try{
          $pel=  Pelicula::withTrashed()->where('idPelicula',$id)->restore();//devuelve el numero de generos restaurados
            info($pel);
      
            return redirect('peliculas')->with('success','Película restaurada');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try {
            Pelicula::destroy($id);

            return redirect('peliculas')->with('success', 'Película enviado a papelera');
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }       

    }



}
