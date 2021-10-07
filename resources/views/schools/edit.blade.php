@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Editar Jardín de niños</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Editar Jardín de niños</li>
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
                        <h3 class="card-title">Editar {{$school->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/schools/edit/' .$school->id) }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        {{ method_field('PATCH')}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="name" class="form-control" value="{{$school->name}}">
                            </div>

                            <div class="form-group">
                                <label for="Direccion">Direccion</label>
                                <input type="text" name="address" class="form-control" value="{{$school->address}}">
                            </div>

                            <div class="form-group">
                                <label for="Telefono">Teléfono</label>
                                <input type="text" name="phone" class="form-control" value="{{$school->phone}}">
                            </div>


                            <div class="form-group">
                                <label for="Responsable">Responsable</label>
                                <input type="text" name="responsible" class="form-control" value="{{$school->responsible}}">
                            </div>


                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{$school->email}}">
                            </div>




                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('schools')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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

    </script>

@endsection
