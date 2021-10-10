@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Configurar Formato</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Configurar Formato</li>
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
                        <h3 class="card-title">Configurar formato:  {{$format->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/formats/configureStore/' .$format->id) }}">
                        {{ csrf_field()}}
                        
                        <div class="row justify-content-center">
                            <div class="col-md-1 justify-content-end">Categoría:</div>
                            <div class="col-md-2"><input type="text" id="newCategory" class="form-control"></div>
                            <div class="col-md-2"><button class="btn btn-sm btn-success" type="button" onclick="addCategory();">Agregar</button></div>
                        </div>

                        <br>
                        

                        <table class="table table-hover text-nowrap">
                            <thead class="bg-success">
                                <tr>
                                    <th>Categorías</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="rowsoptions">
                            </tbody>
                        </table>

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

        function addCategory(){
            var newCategory = $("#newCategory").val();
            var timestamp = Date.now();
            html = getTemplate(timestamp, newCategory);

            $("#rowsoptions").append(html);

            $("#newCategory").val("");
        }

        function addQuestion(i){
            var timestamp = Date.now();
            html = getQuestionTemplate(i, timestamp);
            $("#questions" + i).append(html);            
        }

        function getTemplate(i, newCategory) {
            var html = `
                <tr id="${i}" class="bg-light color-palette">
                    <td>${newCategory}<input type="hidden" name="category[${i}][name]" value="${newCategory}"></td> 
                    <td id="questions${i}"></td>              
                    <td>
                        <button type="button" class="btn-md btn btn-success m-btn m-btn--icon m-btn--pill" onclick="addQuestion(${i})">+</button>
                        <button data-repeater-delete="" onclick="deletetemplate(${i})"
                            class="btn-md btn btn-danger m-btn m-btn--icon m-btn--pill">
                            <span>
                                <i class="fa fa-trash"></i>
                            </span>
                        </button>
                    </td>
                </tr>`;
            return html;
        }

        function getQuestionTemplate(parenti, i){

            var html = `
                <tr id="${i}" class="bg-light color-palette">
                    <td></td> 
                    <td><input type="text" class="form-control" name="category[${parenti}][questions][${i}][question]"></td>              
                    <td>
                        <select class="form-control" name="category[${parenti}][questions][${i}][type]">
                            <option value="number">Número</option>    
                            <option value="text">Texto</option>    
                        </select>
                    </td>              

                    <td>
                        <button data-repeater-delete="" onclick="deletetemplate(${i})"
                            class="btn-md btn btn-danger m-btn m-btn--icon m-btn--pill">
                            <span>
                                <i class="fa fa-trash"></i>
                            </span>
                        </button>
                    </td>
                </tr>`;

            return html;
        }

        function deletetemplate(i) {
            $("#" + i).remove();
        }



    </script>

@endsection
