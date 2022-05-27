<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-cursos | crear-cursos | editar-cursos | borrar-cursos', ['only' => ['index']]);
        $this->middleware('permission:crear-cursos', ['only' =>['create','store']]);
        $this->middleware('permission:editar-cursos', ['only' =>['edit','update']]);
        $this->middleware('permission:borrar-cursos', ['only' =>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::paginate(10);
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cursos.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required',
        ]);
        Curso::create($request->all());
        return redirect()->route('cursos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $cursos, $id)
    {   
        $cursos = Curso::find($id);
        //return $cursos;
        return view('cursos.editar',compact('cursos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $cursos)
    {
        $this->validate($request,[
            'nombre' => 'required',
        ]);
        $cursos->update($request->all());
        return redirect()->route('cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $cursos)
    {
        $cursos->delete();
        return redirect()->route('cursos.index');

    }
}
