<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $new_proyecto->nombre = $request->input('nombre');          // Asignacion de nombre
        $new_proyecto->fecha = $request->input('fecha');            //Asignación de fecha
        $new_proyecto->descripcion = $request->input('descripcion');//Asignación de descripcion
        $new_proyecto->categoria = $request->input('categoria');    //Asignación de categoria
        /* FIN Bloque de asignación de datos */

        $new_proyecto->save(); // Subida a la base de datos

        $new_id = Proyecto::orderBy('id','desc')->first()->id;    //Obtención del ultimo id (objeto creado)

        /* Asignacion de la RUTA de la imagen */
        /* Bloque de subida a disco de archivos */
        if ($request->hasFile('foto')) {    //Se envia la foto
            if ($request->file('foto')->isValid()) {    //Se envia correctamente
                $ext = $request->file('foto')->extension(); //Obtener extensión de fichero
                $this_cliente = Cliente::find($new_id);     //Obtener el cliente insertado a partir del ultimo id
                $this_cliente->imagen = $new_id.'.'.$ext;   //Acualizar/Añadir en la base de datos el nombre del archivo  
                $request->file('foto')                      //Subida en el servidor (storage/public/clientes/id.ext)
                ->storeAs('clientes', $new_id.'.'.$ext, ['disk' => 'public']);     
                $this_cliente->save();                      // Subida a la base de datos post adición de foto (update + foto)
            }
        }
        
        /* FIN de bloque de subida de archivos a disco */
        /* FIN Asignacion de la RUTA de la imagen */

        return redirect()->action('CatalogController@getIndex');
    }

    public function deleteProyecto($id) {
        $proyecto = Proyecto::find($id);
        /*
        Storage::disk('public')                     //En el disco public de storage...
        ->delete('clientes/'.$cliente->imagen);     //Borrar en la carpeta clientes la siguiente imagen
        */
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
