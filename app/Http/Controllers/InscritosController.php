<?php

namespace App\Http\Controllers;

use App\Models\Inscritos;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InscritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Inscritos = 
        DB::table('inscritos as A')
        ->select('A.*','B.nombre as curso')
        ->join('cursos as B','B.id','A.id_curso')
        ->paginate(10);
        //Inscritos::paginate(10);
       // $Inscritos
        return view('inscritos.index', compact('Inscritos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function busqueda(Request $request)
    {
        $Inscritos = 
        DB::table('inscritos as A')
        ->select('A.*','B.nombre as curso')
        ->join('cursos as B','B.id','A.id_curso')
        ->where('A.dni',$request->input('dni'))
        ->first(); 
        return $Inscritos;
        //return \DataTables::of($Inscritos)->make('true');
    }
    public function tabla($id)
    {
        $Inscritos = 
        DB::table('inscritos as A')
        ->select('A.*','B.nombre as curso',DB::raw('"" as Opciones'))
        ->join('cursos as B','B.id','A.id_curso')
        ->where('A.dni',$id)
        ->get(); 

        return \DataTables::of($Inscritos)->make('true');
    }

    public function create()
    {
        $roles = Curso::pluck('nombre','nombre')->all();
        return view('inscritos.crear', compact('roles'));
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
       //return $request;
        DB::beginTransaction();
        try{
            $Inscritos = new Inscritos;

            $Inscritos->nombres = $request->nombres;
            $Inscritos->apellidos = $request->apellidos;
            $Inscritos->dni = $request->dni;
            $Inscritos->email = $request->email;
            $Inscritos->celular = $request->celular;
            $Inscritos->id_curso = 1;

            //$Inscritos->url_certificado = $request->files;
            $file = $request->file('files');
            if ($file) {
            $name = 'I-' . time() . '_' . $file->getClientOriginalName();
            $titulo = explode(".", $file->getClientOriginalName())[0];
            $carpeta = "certificados";
            Storage::disk('public')->putFileAs($carpeta, $file, $name);
            $page = true;
            // return 'certificados/' . $name;
            $Inscritos->url_certificado = 'certificados/'.$name;
            }

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

       // return response()->json($response);
        return redirect()->route('inscritos.index');
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
    public function edit($id)
    {
        $inscritos = Inscritos::find($id);
        $roles = Curso::pluck('nombre','nombre')->all();
        return view('inscritos.editar', compact('inscritos','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $Inscritos = Inscritos::find($id);

            $Inscritos->nombres = $request->nombres;
            $Inscritos->apellidos = $request->apellidos;
            $Inscritos->dni = $request->dni;
            $Inscritos->email = $request->email;
            $Inscritos->celular = $request->celular;
            $Inscritos->id_curso = 1;

            //$Inscritos->url_certificado = $request->files;
            $file = $request->file('files');
            if ($file) {
            $name = 'I-' . time() . '_' . $file->getClientOriginalName();
            $titulo = explode(".", $file->getClientOriginalName())[0];
            $carpeta = "certificados";
            Storage::disk('public')->putFileAs($carpeta, $file, $name);
            $page = true;
            // return 'certificados/' . $name;
            $Inscritos->url_certificado = 'certificados/'.$name;
            }

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

       // return response()->json($response);
        return redirect()->route('inscritos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Inscritos::find($id)->delete();
        return redirect()->route('inscritos.index');
    }
}
