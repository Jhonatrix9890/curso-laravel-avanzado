<?php

namespace App\Http\Controllers;


use App\Genero;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Notifications\GeneroNotification;
use Notification;
use Auth;
use App\Jobs\ProcessEmail;
use App\Pelicula;
use App\Http\Requests\GeneroRequest;
use Lang;



class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=Genero::query();
        $query=$query->withCount('peliculas')->orderBy('nombre');  
        if($request->display == "all"){
            $query =$query->withTrashed();
        }else if($request->display == "trash"){
            $query =$query->onlyTrashed();
        }
        $generos = $query->paginate(10);
        return view('panel.generos.index', compact('generos'));
        
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $peliculas=Pelicula::orderBy('titulo')->get(['idPelicula','titulo']);
        return view("panel.generos.create",compact('peliculas'));
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
            $genero=Genero::create($request->except('idPelicula'));
            $genero->peliculas()->sync($request->idPelicula);
            return redirect('generos')->with('success','Genero registrado');
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
     //   return Genero::withTrashed()->where('idGenero', $id)
       // ->firstOrFail()->toJson();
         $genero=Genero::with(['peliculas' => function ($query) {
            $query->select('titulo');
        }])->findOrFail($id);
        return view("panel.generos.show",compact('genero'));
 
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
          $genero=Genero::with(['peliculas' => function ($query) {
            $query->select('peliculas.idPelicula');
        }])->findOrFail($id);
        $peliculas=Pelicula::orderBy('titulo')->get(['idPelicula','titulo']);
        $pels=collect($genero->peliculas)->sortBy('idPelicula')->toArray();
        return view("panel.generos.edit",compact('genero','peliculas','pels'));  
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
            $genero=Genero::updateOrCreate(['idGenero'=>$id],$request->except('idPelicula'));
            $genero->peliculas()->sync($request->idPelicula);
            return redirect('generos')->with('success','Genero actualizado');
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
            Genero::withTrashed()->where('idGenero',$id)->forceDelete();
          
            return redirect('generos?display=trash')->with('success','Género eliminado permanentemente');
        }catch(Exception | QueryException $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }

    public function restore($id)
    {
        try{
          $gen=  Genero::withTrashed()->where('idGenero',$id)->restore();//devuelve el numero de generos restaurados
            info($gen);
      
            return redirect('generos')->with('success','Género restaurado');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try {
            Genero::destroy($id);
            // $gen = Genero::withTrashed()->where('idGenero', $id)->first();
            // $user = Auth::user();
          //  ProcessEmail::dispatch();

            //Mail::to($user)->send(new GeneroTrash());
            // Notification::route('mail', $email)
            // ->notify(new GeneroNotification());
            $gen = Genero::withTrashed()->where('idGenero', $id)->first();
            return redirect('generos')->with('success', Lang::get("messages.gender_trash",['name' => $gen->nombre]));
        } catch (Exception $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }

        

    }
}
