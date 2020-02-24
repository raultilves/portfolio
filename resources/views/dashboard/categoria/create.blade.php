@extends('layouts.app')

@section('content')

<div class="row mt-4">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir categoria
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
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" value="{{old('nombre')}}">
                </div>
            
                <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" style="padding:8px;margin-top:25px;">
                    Añadir categoria
                </button>
                </div>

            </form>

         </div>
      </div>
   </div>
</div>
@stop