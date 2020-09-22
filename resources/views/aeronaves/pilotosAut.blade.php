@extends('layouts.app')


@section('content')


@if(count($pilotosAut))


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
        @foreach ($pilotosAut as $pilotoAut)
        <tr>
            <td><img src="{{ $pilotoAut->foto_url == null ? asset('storage/fotos/noimage.jpg') : asset('storage/fotos/' . $pilotoAut->foto_url)}}"></td>
            <td>{{$pilotoAut->num_socio}}</td>
            <td>{{$pilotoAut->nome_informal}}</td>
            <td>{{$pilotoAut->name}}</td>
            <td>{{$pilotoAut->sexo}}</td>
            <td>{{$pilotoAut->data_nascimento}}</td>
            <td>{{$pilotoAut->email}}</td>
            <td>{{$pilotoAut->nif}}</td>
            <td>{{$pilotoAut->telefone}}</td>
            <td>{{$pilotoAut->endereco}}</td>
            <td>{{$pilotoAut->tipo_socio}}
                 @if ($pilotoAut->tipo_socio=='P')   
                 <br><strong>Nº Licença: </strong>{{$pilotoAut->num_licenca}}
                 @endif
            </td>
            <td>{{$pilotoAut->direcao}}</td>
            
            <td>
            <form method="POST" action="{{route('aeronaves.removePiloto', [$aeronave -> matricula, $pilotoAut->id])}}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-xs btn-danger">Delete</button>
            </form>
            </td>
        </tr>
        @endforeach
</table>
{{$pilotosAut->links()}}
@else
<h2>Não foram encontrados socios</h2>
@endif
@endsection