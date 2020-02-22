@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-ld-10 col-sm col-md">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-10">
                        @lang('Logged In')
                        </div>

                        <div class="col-md-2">
                        <p>Ocultar:</p>
                            <form>
                                @csrf
                                <div class="form-check">
                                    <input type="checkbox" name="proyectoCheck" id="proyectoCheck" class="form-check-input">
                                    <label class="form-check-label" for="proyectoCheck">Proyectos</label>                           
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="categoriaCheck" id="categoriaCheck" class="form-check-input">
                                    <label class="form-check-label" for="categoriaCheck">Categorias</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    

                    <div class="table-responsive-md" id="proyectosTable">
                    <hr>
                    <p class="h6 text-center">Tabla Proyectos</p>
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="align-middle">Nombre</th>
                                    <th scope="col" class="align-middle">Fecha</th>
                                    <th scope="col" class="align-middle">Acciones</th>
                                    <th scope="col"><a class="btn btn-outline-success btn-sm btn-block" href="dashboard/proyectos/create" role="button"><i class="fas fa-plus"></i></a></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach( $proyectos as $key => $proyecto )
                                <tr>
                                    <th style="width: 10%" scope="row">{{$proyecto->id}}</th>
                                    <td style="width: 35%">{{$proyecto->nombre}}</td>
                                    <td style="width: 35%">{{$proyecto->fecha}}</td>
                                    <td style="width: 10%"><a class="btn btn-outline-info btn-sm btn-block" href="/dashboard/proyectos/edit/{{$proyecto->id}}" role="button">Editar</a></td>
                                    <td style="width: 20%">
                                        <form action="{{action('DashboardController@deleteProyecto', $proyecto->id)}}" method="POST" style="display:inline">
                                        @method('DELETE')
                                        @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-block" style="display:inline">
                                                Borrar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        <div class="mx-auto" style="width: 100px">{{ $proyectos->links() }}</div>
                    </div>

                    

                    <div class="table-responsive-md" id="categoriasTable">
                    <hr>
                    <p class="h6 text-center">Tabla Categorias</p>
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="align-middle">Nombre</th>
                                    <th scope="col" class="align-middle">Acciones</th>
                                    <th scope="col"><a class="btn btn-outline-success btn-sm btn-block" href="dashboard/create" role="button"><i class="fas fa-plus"></i></a></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach( $categorias as $key => $categoria )
                                <tr>
                                    <th style="width: 10%" scope="row">{{$categoria->id}}</th>
                                    <td style="width: 70%">{{$categoria->nombre}}</td>
                                    <td style="width: 10%"><a class="btn btn-outline-info btn-sm btn-block" href="/dashboard/edit/{{$categoria->id}}" role="button">Editar</a></td>
                                    <td style="width: 10%">
                                        <form action="{{action('DashboardController@deleteProyecto', $categoria->id)}}" method="POST" style="display:inline">
                                        @method('DELETE')
                                        @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-block" style="display:inline">
                                                Borrar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        <div class="mx-auto" style="width: 100px">{{ $categorias->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
