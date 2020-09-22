@extends('layouts.app')

@section('title', 'Lista de Pilotos Não Autorizados')

@section('content')


@if(count($pilotosNAut))


<table class="table table-striped">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Numero de Socio</th>
            <th>Nome Informal</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Data de Nascimento</th>
            <th>Email</th>
            <th>NIF</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Tipo de Socio</th>
            <th>Pertence á direção</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pilotosNAut as $pilotoNAut)
        <tr>
            <td><img src="{{ $pilotoNAut->foto_url == null ? asset('storage/fotos/noimage.jpg') : asset('storage/fotos/' . $pilotoNAut->foto_url)}}"></td>
            <td>{{$pilotoNAut->num_socio}}</td>
            <td>{{$pilotoNAut->nome_informal}}</td>
            <td>{{$pilotoNAut->name}}</td>
            <td>{{$pilotoNAut->sexo}}</td>
            <td>{{$pilotoNAut->data_nascimento}}</td>
            <td>{{$pilotoNAut->email}}</td>
            <td>{{$pilotoNAut->nif}}</td>
            <td>{{$pilotoNAut->telefone}}</td>
            <td>{{$pilotoNAut->endereco}}</td>
            <td>{{$pilotoNAut->tipo_socio}}
                 @if ($pilotoNAut->tipo_socio=='P')   
                 <br><strong>Nº Licença: </strong>{{$pilotoNAut->num_licenca}}
                 @endif
            </td>
            <td>{{$pilotoNAut->direcao}}</td>
            
            <td>
            <form method="POST" action="{{route('aeronaves.addPiloto', [$aeronave -> matricula, $pilotoNAut->id])}}">
                {{ method_field('POST') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-xs btn-success">Adicionar</button>
            </form>
            </td>
        </tr>
        @endforeach
</table>
{{$pilotosNAut->links()}}
@else
<h2>Não foram encontrados socios</h2>
@endif
@endsection