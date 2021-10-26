@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Gráficas Formato</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Gráficas Formato</li>
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
                        <h3 class="card-title">{{ $format->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <br><br>
                    <form action="{{url('formats/graphs/' .$format->id)}}" method="POST">
                        <div class="row  justify-content-center">
        
                            <div class="col-md-3">

                                <select name="schoolId" class="form-control">
                                    <option value="0">Todos</option>

                                    @foreach($schools as $school)
                                        @if($selected == $school->id)
                                            <option value="{{$school->id}}" selected>{{$school->name}}</option>
                                        @else
                                            <option value="{{$school->id}}">{{$school->name}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success bt   n-md" type="submit">Filtrar</button>
                            </div>
        
                        </div>
                    </form>

                    <br>

                    <div class="row justify-content-center">
                        <div class="col-12">


                            @if(count($graphs) == 0 && $selected == 0)
                                <h4 class="text-center bg-danger">Ninguna persona responsable ha enviado el formato al consejo técnico.</h4>
                            @elseif(count($graphs) > 0)

                            <div class="row">
                                @foreach ($graphs as $graph)

                                    <div class="col-md-6">
                                         <h2>{{$graph['question']}}</h2> 
                                        <div class="col-md-12">
                                            <canvas id="{{ $graph['questionId'] }}" width="400" height="400"></canvas>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <h4 class="text-center bg-warning">La persona responsable aún no envía el formato al consejo técnico.</h4>
                            @endif


                            <div class="card-footer d-flex">
                                <a href="{{ url('home') }}"><button type="button"
                                        class="btn btn-danger p-2">Regresar</button></a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


            <!-- /.card-body -->
        </div>



    </div>


    <script>
        $(function() {

            @foreach ($graphs as $grade)
            
                var areaChartData = {
                labels : [
                @foreach ($grade['grades'] as $g)
                    "{{ $g['grade'] }}-{{ @$g['hall'] }}",
                @endforeach
                ],
                datasets: [
                {
                label : "{{ $grade['question'] }}",
                backgroundColor : 'rgba(60,141,188,0.9)',
                borderColor : 'rgba(60,141,188,0.8)',
                pointRadius : false,
                pointColor : '#3b8bba',
                pointStrokeColor : 'rgba(60,141,188,1)',
                pointHighlightFill : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data : [
                @foreach ($grade['grades'] as $g)
                    "{{ $g['answer'] }}",
                @endforeach
                ],
                backgroundColor : [
                @foreach ($grade['grades'] as $g)
                    getRandomColor(),
                @endforeach
                ],
                }
                ]
                }
            
                var barChartCanvas = $('#'+{{ $grade['questionId'] }}).get(0).getContext('2d')
                var barChartData = jQuery.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]
                barChartData.datasets[0] = temp0
                var barChartOptions = {
                responsive : true,
                maintainAspectRatio : false,
                datasetFill : false,
                scales: {
                yAxes: [{
                display: true,
                ticks: {
                beginAtZero: true,
                }
                }]
                },
                }
            
                var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
                })
            
            
            @endforeach



        })


        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>


@endsection
