@extends('layouts.app')

@section('title', 'Lista de aeronaves')

@section('content')
@can('create', App\Aeronave::class)
<div>
    <a class="btn btn-primary" href="{{route('aeronaves.create')}}">Adicionar Aeronaves</a>
</div>
@endcan

@if(count($aeronaves))

<!-- PESQUISA -->
<form method="GET" action="{{route('aeronaves.index')}}">
    @csrf
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Numero de Lugares</th>
                <th>Conta Horas</th>
                <th>Preço Hora</th>
            </tr>
        </thead>
        <tbody>
            <tr> 
                <td><input type="text" name="matricula" class="form-control" id="matricula" placeholder="Matricula" value="{{Request::get('matricula')}}"></td>
                
                <td><input type="text" name="marca" class="form-control" id="marca" placeholder="Marca" value="{{Request::get('marca')}}"></td>
                
                <td><input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo" value="{{Request::get('modelo')}}"></td>
                
                <td><input type="text" name="num_lugares" class="form-control" id="num_lugares" placeholder="Numero de Lugares" value="{{Request::get('num_lugares')}}"></td>

                <td><input type="text" name="conta_horas" class="form-control" id="conta_horas" placeholder="Conta Horas" value="{{Request::get('conta_horas')}}"></td>

                <td><input type="text" name="preco_hora" class="form-control" id="preco_hora" placeholder="Preço Hora" value="{{Request::get('preco_hora')}}"></td>
    
                <td><button type="submit" class="btn btn-primary">Pesquisar</button></td>
            </tr>
        </tbody>
    </table>
    </form>
    
    <!-- END PESQUISA -->
    


    <table class="table table-striped">
    <thead>
        <tr>
            <th>Matricula</th>
            <th>marca</th>
            <th>modelo</th>
            <th>num_lugares</th>
            <th>conta_horas</th>
            <th>preco_hora</th>
            <th>certificado</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($aeronaves as $aeronave)
        <tr>
            <td>{{$aeronave->matricula}}</td>
            <td>{{$aeronave->marca}}</td>
            <td>{{$aeronave->modelo}}</td>
            <td>{{$aeronave->num_lugares}}</td>
            <td>{{$aeronave->conta_horas}}</td>
            <td>{{$aeronave->preco_hora}}</td>
            <td>{{$aeronave->tipo_certificacao}}</td>

            <td>
                @can('update', $aeronave)
                <a class="btn btn-xs btn-primary" href="{{route('aeronaves.edit', $aeronave)}}">Edit</a>
                <a class="btn btn-xs btn-primary" href="{{route('aeronaves.pilotosAut', $aeronave)}}">Pilotos Autorizados</a>
                <a class="btn btn-xs btn-primary" href="{{route('aeronaves.pilotosNAut', $aeronave)}}">Pilotos Não Autorizados</a>
                @else
                <span class="btn btn-xs btn-secondary disabled" >Edit</span>
                @endcan
                @can('delete', $aeronave)
                <form action="{{route('aeronaves.destroy', $aeronave)}}" method="POST" role="form" class="inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
                @else
                <span class="btn btn-xs btn-secondary disabled" >Delete</span>
                @endcan
            </td>
        </tr>
    @endforeach
    </table>
@else
    <h2>Não foram encontradas aeronaves</h2>
@endif
@endsection
