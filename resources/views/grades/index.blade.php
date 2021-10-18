@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Grados</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Grados</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <div class="card-header">
                <div class="row d-flex flex-row-reverse" style="padding-right:20px;">
                    <a href="{{ url('grades/add') }}">
                        <button type="button" class="btn btn-success">Agregar</button>
                    </a>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped table-bordered" id="gradesTable">
                    <thead>
                        <tr>
                            <th>Grado</th>
                            <th>Aula</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                        <tr>
                            <td>{{$grade->grade}}</td>
                            <td>{{$grade->hall}}</td>

                            <td>

                                <a class="btn btn-info btn-sm" href="{{ route('grades.edit', ['id'=>$grade->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Editar
                                </a>

                                <a class="btn btn-danger btn-sm button-destroy"
                                    href="{{ route('grades.destroy',['id'=>$grade->id]) }}" data-original-title="Eliminar"
                                    data-method="delete" data-trans-button-cancel="Cancelar"
                                    data-trans-button-confirm="Eliminar" data-trans-title="¿Está seguro de esta operación?"
                                    data-trans-subtitle="Esta operación eliminará este registro permanentemente">
                                    <i class="fas fa-trash">
                                    </i>
                                    Eliminar
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
            $('#gradesTable').DataTable();
        });
    </script>

@endsection
