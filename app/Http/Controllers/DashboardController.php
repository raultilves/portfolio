<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Proyecto;
use App\Categoria;
use App\Http\Requests\ProyectoEditFormRequest;
use App\Http\Requests\CategoriaFormRequest;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); //Obliga a estar autenticado para acceder
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Muestra un resumen del contenido en la BBDD mediante tablas PAGINADAS mediante QueryBuilder
    public function index()
    {
        $proyectos = DB::table('proyectos')->paginate(5, ['*'], 'proyectosPage');

        $categorias = DB::table('categorias')->paginate(5, ['*'], 'categoriasPage');

        return view('dashboard/index', [
            'proyectos' => $proyectos,
            'categorias' => $categorias
        ]);
    }

    // Carga la vista del formulario de creación de proyectos
    public function getCreateProyecto() {
        $categorias = Categoria::all();
        return view('dashboard/proyecto/create', ['categorias' => $categorias]);
    }

    // VALIDACIÓN MEDIANTE VALIDATOR. VALIDACION REQUEST EN putEditProyecto \/
    // Controla los datos mandados por formulario y crea proyectos en la base de datos
    public function postCreateProyecto(Request $request) {
        $validator = Validator::make($request->all(), [         //Controla los datos mediante la clase Validator
            'nombre' => 'required|max:255',                     //Requerido, máximo 255 chars
            'fecha' => 'required|date|before_or_equal:today',   //Requerido, formato fecha, anterior o igual a hoy
            'descripcion' => 'required',                        //Requerido
            'categoria' => 'required'                           //Requerido
        ]);

        if ($validator->fails()) {                              //Si los datos son inválidos
            return redirect('dashboard/proyectos/create')       //Redirige al formulario de nuevo
                        ->withErrors($validator)                //Con los errores que ha devuelto el validador
                        ->withInput();
        }

        // Creamos el objeto proyecto
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
                $ext = $request->file('foto')->extension();                                     //Obtener extensión de fichero
                $foto = $request->file('foto');                                                 //Obtener foto del formulario
                $fotoName = $new_id.'_'.str_replace(' ','',$request->input('nombre').'.'.$ext); //Asignacion de nombre de foto
                $fotoPath = 'proyectos/' . $fotoName;                                           //Asignación de la ruta en s3
                Storage::disk('s3')->put($fotoPath, file_get_contents($foto));                  //Subida a s3
                $thisProyecto = Proyecto::find($new_id);
                $thisProyecto->foto = $fotoName;
                
                // Actualización del campo fotos de ese objeto (Haciendo uso de QueryBuilder)
                DB::table('proyectos')
                ->where('id', $new_id)
                ->update(['foto' => $fotoName]);
            }
        }
        
        /* FIN de bloque de subida de archivos a disco */
        /* FIN Asignacion de la RUTA de la imagen */

        return redirect()->action('DashboardController@index');
    }

    //Carga la vista del formulario de edición de Proyecto
    public function getEditProyecto($id) {
        return view('dashboard/proyecto/edit', [
            'proyecto' => Proyecto::findOrFail($id),
            'categorias' => Categoria::all()
        ]);
    }

    // VALIDACIÓN MEDIANTE REQUEST
    //Controla los datos mandados por formulario y edita en la BBDD los proyectos
    public function putEditProyecto(ProyectoEditFormRequest $request, $id)
    {
        // Obtenemos el proyecto que queremos modificar
        $old_proyecto = Proyecto::find($id);
        $old_imagen = $old_proyecto->foto; //Y su actual foto

        /* Bloque de actualización de datos */
        $old_proyecto->nombre = $request->input('nombre');    //Modificamos el nombre
        
        /* Bloque de actualización de imagen */
        if ($request->hasFile('foto')) {    //Se actualiza foto? ->
            if ($request->file('foto')->isValid()) {    //Es válida? ->
                $ext = $request->file('foto')->extension(); //Obtener extensión de fichero
                $foto = $request->file('foto');
                $old_proyecto->foto = $id.'_'.str_replace(' ','',$request->input('nombre').'.'.$ext);  //Actualizar campo imagen con su id y el cambio de extensión si lo hubiera
                Storage::disk('s3')                         //En el disco public de storage...
                ->delete('proyectos/'.$old_imagen);         //Borrar en la carpeta clientes la siguiente imagen
                Storage::disk('s3')
                ->put('proyectos/'.$old_proyecto->foto, file_get_contents($foto));
            }
        }
        /* FIN Bloque de actualización de imagen */
        $old_proyecto->fecha = $request->input('fecha');
        $old_proyecto->descripcion = $request->input('descripcion');
        $old_proyecto->categoria_id = $request->input('categoria');
        /* FIN Bloque de actualización de datos */

        $old_proyecto->save(); // Subida a la base de datos
        return redirect()->action('DashboardController@index');
    }

    //Obtiene un proyecto y lo borra
    public function deleteProyecto($id) {
        $proyecto = Proyecto::find($id);
        Storage::disk('s3')->delete('proyectos/'.$proyecto->foto);
        $proyecto->delete();
        return redirect()->action('DashboardController@index');
    }

    //Carga la vista del formulario de creación de categorias
    public function getCreateCategoria() {
        return view('dashboard/categoria/create');
    }

    // VALIDACIÓN MEDIANTE REQUEST
    //Controla los datos mandados por formulario y edita en la BBDD los proyectos
    public function postCreateCategoria(CategoriaFormRequest $request)
    {
        // Obtenemos la categoria que queremos modificar
        $categoria = new Categoria();

        /* Bloque de inserción de datos */
        $categoria->nombre = $request->input('nombre');
        /* FIN Bloque de inserción de datos */

        $categoria->save(); // Subida a la base de datos
        return redirect()->action('DashboardController@index');
    }

    //Carga la vista del formulario de edición de categorias
    public function getEditCategoria($id) {
        return view('dashboard/categoria/edit', [
            'categoria' => Categoria::findOrFail($id)
        ]);
    }

    // VALIDACIÓN MEDIANTE REQUEST
    //Controla los datos mandados por formulario y edita en la BBDD los proyectos
    public function putEditCategoria(CategoriaFormRequest $request, $id)
    {
        // Obtenemos la categoria que queremos modificar
        $old_categoria = Categoria::find($id);

        /* Bloque de actualización de datos */
        $old_categoria->nombre = $request->input('nombre');    //Modificamos el nombre
        /* FIN Bloque de actualización de datos */

        $old_categoria->save(); // Subida a la base de datos
        return redirect()->action('DashboardController@index');
    }

    //Obtiene una categoria y la borra
    public function deleteCategoria($id) {
        $categoria = Categoria::find($id);
        $categoria->delete();
        return redirect()->action('DashboardController@index');
    }
}
