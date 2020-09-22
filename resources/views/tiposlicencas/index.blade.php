
@extends('layouts.app')

@section('title', 'Lista de Tipos de Licencas')

@section('content')
<div>
    <a class="btn btn-primary" href="{{route('tiposlicencas.create')}}">Adicionar Tipo de Licenca</a>
</div>

@if(count($tipos_licenca))
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Code </th>
            <th>Nome</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tipos_licenca as $tipos_licenca)
        <tr>
            <td>{{$tipos_licenca->code}}</td>
            <td>{{$tipos_licenca->nome}}</td>
        </tr>
    @endforeach
    </table>
@else
    <h2>Não foram encontradas Licencas</h2>
@endif
@endsection
