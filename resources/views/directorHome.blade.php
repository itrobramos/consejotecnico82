@extends('layouts.business')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>3</h3>
                                <p>Formatos Abiertos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>12</h3>

                                <p>Contestados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>
                <!-- /.row -->


            </div><!-- /.container-fluid -->
        </section>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-bordered">

                    @foreach ($formats as $format)
                        <tr class='bg-success'>
                            <td style="width:80%">{{ $format->name }}</td>
                            <td style="width:10%"><a href="{{ route('formats.answer', ['id'=>$format->id]) }}"><button class="btn btn-primary">Responder</button></a></td>
                            <td style="width:10%"><a href="{{ route('formats.send', ['id'=>$format->id]) }}"><button class="btn btn-sm btn-warning">Enviar a Consejo Técnico</button></a></td>

                        </tr>
                    @endforeach

                </table>

            </div>
        </div>


        <br>
        
        <div class="row justify-content-center">
            <div class="col-md-12">
              <h1>Histórico</h1>
                <table class="table table-bordered">

                    @foreach ($oldformats as $format)
                        <tr class="bg-gradient-gray-dark">
                            <td style="width:80%">{{ $format->format->name }}</td>
                            <td style="width:10%"><button class="btn btn-primary">Detalles</button></td>
                        </tr>
                    @endforeach

                </table>

            </div>
        </div>



        <!-- /.content -->
    </div>




@endsection
