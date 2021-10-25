@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Formatos</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Formatos</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <div class="card-header">
                <div class="row d-flex flex-row-reverse" style="padding-right:20px;">
                    <a href="{{ url('formats/add') }}">
                        <button type="button" class="btn btn-success">Agregar</button>
                    </a>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped table-bordered" id="formatTable">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formats as $format)
                        <tr>
                            <td>{{$format->name}}</td>
                            <td>{{$format->beginDate}}</td>
                            <td>{{$format->endDate}}</td>

                            <td>
                                <a title="Editar" class="btn btn-info btn-sm" href="{{ route('formats.edit', ['id'=>$format->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>

                                @if($format->active != 1)
                                <a title="Configurar" class="btn btn-dark btn-sm" href="{{ route('formats.configure', ['id'=>$format->id]) }}">
                                    <i class="fas fa-cog">
                                    </i>
                                </a>

                                <a title="Activar" class="btn btn-success btn-sm" href="{{ route('formats.activate', ['id'=>$format->id]) }}">
                                    <i class="fas fa-check">
                                    </i>
                                </a>

                                @endif

                                <a title="Eliminar" class="btn btn-danger btn-sm button-destroy"
                                    href="{{ route('formats.destroy',['id'=>$format->id]) }}" data-original-title="Eliminar"
                                    data-method="delete" data-trans-button-cancel="Cancelar"
                                    data-trans-button-confirm="Eliminar" data-trans-title="¿Está seguro de esta operación?"
                                    data-trans-subtitle="Esta operación eliminará este registro permanentemente">
                                    <i class="fas fa-trash">
                                    </i>
                                </a>
                            </td>

                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#formatTable').DataTable();
        });
    </script>

@endsection
