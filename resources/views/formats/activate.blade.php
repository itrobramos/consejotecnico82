@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Activar Formato</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Activar Formato</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="d-flex justify-content-center">
            <!-- /.card-header -->

            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Activar {{$format->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/formats/activatepost/' .$format->id) }}">
                        {{ csrf_field()}}
                        
                        <div class="card-body">
                            
                            <div class="row">
                                <table class="table">
                                    <tr class="bg-gradient-gray-dark">
                                        <td><input type="checkbox" id="chkAll" class="form-control"/></td>
                                        <td>Seleccionar Todos</td>
                                    <tr>

                                    @foreach($schools as $school)
                                        <tr>
                                            <td><input type="checkbox" name="schools[{{$school->id}}]" class="form-control"/></td>
                                            <td>{{$school->name}}</td>
                                        <tr>
                                    @endforeach
                                </table> 
                            </div>

                           

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('formats')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
                            <button type="submit" class="btn btn-success ml-auto p-2">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- /.card-body -->
        </div>



    </div>



    <script>
        $(document).ready(function() {
            $('#schooltable').DataTable();
        });

        $('#chkAll').change(function() {
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

    </script>

@endsection
