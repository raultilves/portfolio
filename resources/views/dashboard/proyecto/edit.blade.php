@extends ('layouts.app')

@section('content')

<div class="row mt-4">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Editar Proyecto {{$proyecto->nombre}}
         </div>
         <div class="card-body" style="padding:30px">

        @if ($errors->any())

        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="alert alert-danger">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div> 

        @endif

            <form method="POST" enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" value="{{$proyecto->nombre}}">
                </div>

                <div class="form-group">
                    <input type="file" name="foto">
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha de creación</label><br>
                    <input type="date" name="fecha" value="{{$proyecto->fecha}}">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción de proyecto</label><br>
                    <textarea name="descripcion" id="descripcion" rows="8" class="form-control">
                    {{$proyecto->descripcion}}
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label><br>
                    <select class="form-control" id="categoria" name="categoria">
                    @foreach($categorias as $key => $categoria)
                        @if ($proyecto->categoria->id == $proyecto)
                        <option value="{{$categoria->id}}">{{$categoria->id}} | {{$categoria->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            
                <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" style="padding:8px;margin-top:25px;">
                    Añadir cliente
                </button>
                </div>

            </form>

         </div>
      </div>
   </div>
</div>
@stop