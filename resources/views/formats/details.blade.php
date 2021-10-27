@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Detalles Formato</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Detalles Formato</li>
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

                    <form action="{{url('formats/details/' .$format->id)}}" method="POST">
                        {{ csrf_field() }}

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

                                @if($answers->count() == 0 && $selected == 0)
                                    <h4 class="text-center bg-danger">Ninguna persona responsable ha enviado el formato al consejo técnico.</h4>
                                @elseif($answers->count() > 0)

                                    <table class="table table-bordered table-responsive text-nowrap">

                                        <tr>
                                            <td class="bg-primary"></td>
                                            @foreach ($format->categories as $category)
                                                <td style="text-align: center;" colspan="{{ $category->questions->count() }}" class="bg-primary">
                                                    {{ $category->name }}</td>
                                            @endforeach
                                        </tr>
    
                                        <tr>
                                            <td class="bg-primary" style="width:25px;"></td>
                                            @foreach ($format->categories as $category)
                                                @foreach ($category->questions as $question)
                                                    @if($question->type == "number")
                                                    <td class="bg-gradient-white"
                                                        style="text-align:center; writing-mode: vertical-rl; text-orientation: use-glyph-orientation;">
                                                        {{ $question->name }}</td>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </tr>
    
                                        @if(Auth::user()->userTypeId == 1)
                                            {{-- Admin --}}
                                            @foreach ($grades as $grade)
                                                <tr>
                                                    <td class="bg-primary">{{ $grade->grade }} </td>
                                                    @foreach ($format->categories as $category)
                                                        @foreach ($category->questions as $question)
                                                            @php 
                                                                if($answers->where('grade', $grade->grade)
                                                                                ->where('questionId', $question->id)
                                                                                ->first() != null)
                                                                {
                                                            
                                                                    $answer = $answers->where('grade', $grade->grade)->where('questionId',$question->id)->first()->answer;
                                                                }
                                                                else{
                                                                    $answer = "";
                                                                }
                                                            @endphp
    
                                                            @if($question->type == "number")
                                                                <td><input readonly  type="text" class="form-control" style="width:100%;" value={{$answer}}></td>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                    
    
                                        @else 
                                            {{-- Directora --}}
                                            @foreach ($grades as $grade)
                                                <tr>
                                                    <td class="bg-primary">{{ $grade->grade }} {{ @$grade->hall }} </td>
                                                    @foreach ($format->categories as $category)
                                                        @foreach ($category->questions as $question)
                                                            @php 
                                                                if($answers->where('gradeId', $grade->id)->where('questionId',$question->id)->first() != null){
                                                                    $answer = $answers->where('gradeId', $grade->id)->where('questionId',$question->id)->first()->answer;
                                                                }
                                                                else{
                                                                    $answer = '';
                                                                }
                                                            @endphp
                                                            @if($question->type=="number")
                                                                <td><input readonly     type="number" class="form-control" name="answer[{{$grade->id}}][{{$question->id}}]" style="width:100%;" value={{$answer}}></td>
                                                            @else
                                                                <td><input readonly  type="text" class="form-control" name="answer[{{$grade->id}}][{{$question->id}}]" style="width:100%;" value={{$answer}}></td>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
    
                                                </tr>
                                            @endforeach
                                    
                                        @endif
    
                                       
                                    </table>
                                    
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



   

@endsection
