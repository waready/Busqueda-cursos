<?php

namespace App\Http\Controllers;

use App\Models\Inscritos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InscritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Inscritos = Inscritos::paginate(10);
       // $Inscritos
        return view('inscritos.index', compact('Inscritos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'nombre' => 'required',
        // ]);
       // return $request;
        DB::beginTransaction();
        try{
            $Inscritos = new Inscritos;

            $Inscritos->nombres = $request->nombres;
            $Inscritos->apellidos = $request->apellidos;
            $Inscritos->dni = $request->dni;
            $Inscritos->email = $request->email;
            $Inscritos->celular = $request->celular;
            $Inscritos->id_curso = 1;
            $Inscritos->save();
            DB::commit();
            $message = "Se registro el Formulario Correctamente";
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = "Error al registrar el formulario, intentelo de nuevo si el problema persiste comuniquese con el administrador.";
            $status = false;
            $error =$e;
        }
        $response = array(
            "message"=>$message,
            "status"=>$status,
            "error"=>isset($error) ? $error:''
        );

        return response()->json($response);
        //return redirect()->route('cursos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function show(Inscritos $inscritos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscritos $inscritos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscritos $inscritos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscritos $inscritos)
    {
        //
    }
}
