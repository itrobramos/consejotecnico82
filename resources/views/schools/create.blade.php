@extends('layouts.app')
@section('title', 'Crear cliente')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">Clientes</a></li>
</ol>
@endsection


@section('extra-css')
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
        
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        

        <div class="card-tools">
           
        </div>
    </div>

    
    <div class="card-body">
        <form action="{{ route('schools.store') }}" method="post">
          <h3>Datos del usuario</h3>
          <div class="row">
            <div class="form-group col-lg-6 col-md-12 col-sm-12">
              <label for="exampleInputEmail1">Nombre</label>
              <input name="name" class="form-control" value="{{ old('name')}}">
            </div>
  
            <div class="form-group col-lg-6 col-md-12 col-sm-12">
              <label for="exampleInputEmail1">Email</label>
              <input name="email" class="form-control" value="{{ old('email')}}">
            </div>
  
            <div class="form-group col-lg-6 col-md-12 col-sm-12">
              <label for="exampleInputEmail1">Teléfono</label>
              <input name="phone" type="phone" class="form-control" value="{{ old('phone')}}">
            </div>

           
          </div>


          <hr>
          <h3>Datos del negocio</h3>

            <div class="row">
              <div class="form-group col-lg-6 col-md-12 col-sm-12">
                <label for="exampleInputEmail1">Empresa</label>
                <input name="company" class="form-control" value="{{ old('company')}}">
              </div>
              
              <div class="form-group col-lg-6 col-md-12 col-sm-12">
                <label for="exampleInputEmail1">Razón social</label>
                <input name="business_name" class="form-control" value="{{ old('business_name')}}">
              </div>

              <div class="form-group col-lg-6 col-md-12 col-sm-12">
                <label for="exampleInputEmail1">Dirección</label>
                <input name="address" class="form-control" value="{{ old('address')}}">
              </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('schools.index') }}" class="btn btn-danger">Cancelar</a>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </div>
        </form>
    </div>
    

    <div class="card-footer">
        
    </div>
</div>
@endsection
