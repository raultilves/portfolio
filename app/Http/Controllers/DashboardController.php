<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Proyecto;
use App\Categoria;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $proyectos = DB::table('proyectos')->paginate(5, ['*'], 'proyectosPage');

        $categorias = DB::table('categorias')->paginate(5, ['*'], 'categoriasPage');

        return view('dashboard/index', [
            'proyectos' => $proyectos,
            'categorias' => $categorias
        ]);
    }

    public function getCreateProyecto() {
        $categorias = Categoria::all();
        return view('dashboard/proyecto/create', ['categorias' => $categorias]);
    }

    public function postCreateProyecto(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'descripcion' => 'required',
            'categoria' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/proyectos/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Creamos el objeto cliente
        $new_proyecto = new Proyecto();

        /* Bloque de asignación de datos */
        $new_proyecto->nombre = $request->input('nombre');          //Asignacion de nombre
        $new_proyecto->fecha = $request->input('fecha');            //Asignación de fecha
        $new_proyecto->descripcion = $request->input('descripcion');//Asignación de descripcion
        $new_proyecto->categoria_id = $request->input('categoria');    //Asignación de categoria
        /* FIN Bloque de asignación de datos */

        $new_proyecto->save(); //Guardar en la base de datos

        $new_id = Proyecto::orderBy('id','desc')->first()->id;    //Obtención del ultimo id (objeto creado)

        /* Asignacion de la RUTA de la imagen */
        /* Bloque de subida a disco de archivos */
        if ($request->hasFile('foto')) {    //Se envia la foto
            if ($request->file('foto')->isValid()) {    //Se envia correctamente
                $foto = $request->file('foto');                                                 //Obtener foto del formulario
                $fotoName = $new_id.'_'.str_replace(' ','',$request->input('nombre').'.png');   //Asignacion de nombre de foto
                $fotoPath = 'proyectos/' . $fotoName;                                           //Asignación de la ruta en s3
                Storage::disk('s3')->put($fotoPath, file_get_contents($foto));                                     //Subida a s3
                $thisProyecto = Proyecto::find($new_id);
                $thisProyecto->foto = $fotoName;
                
                DB::table('proyectos')
                ->where('id', $new_id)
                ->update(['foto' => $fotoName]);
            }
        }
        
        /* FIN de bloque de subida de archivos a disco */
        /* FIN Asignacion de la RUTA de la imagen */

        return redirect()->action('DashboardController@index');
    }

    public function deleteProyecto($id) {
        $proyecto = Proyecto::find($id);
        Storage::disk('s3')->delete('proyectos/'.$proyecto->foto);
        $proyecto->delete();
        return redirect()->action('DashboardController@index');
    }

    public function deleteCategoria($id) {
        $categoria = Categoria::find($id);
        /*
        Storage::disk('public')                     //En el disco public de storage...
        ->delete('clientes/'.$cliente->imagen);     //Borrar en la carpeta clientes la siguiente imagen
        */
        $categoria->delete();
        return redirect()->action('DashboardController@index');
    }
}
