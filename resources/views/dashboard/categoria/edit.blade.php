@extends ('layouts.app')

@section('content')

<div class="row mt-4">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Editar categoria {{$categoria->nombre}}
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
                @method('PUT')
                @csrf

                <div class="form-group">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" value="{{$categoria->nombre}}">
                </div>

                <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" style="padding:8px;margin-top:25px;">
                    Editar categoria
                </button>
                </div>

            </form>

         </div>
      </div>
   </div>
</div>
@stop