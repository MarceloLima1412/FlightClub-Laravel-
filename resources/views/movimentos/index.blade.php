@extends('layouts.app')

@section('title', 'Lista de Movimentos')

@section('content')


@can('create', App\Movimento::class)
<div>
    <a class="btn btn-primary" href="{{route('movimentos.create')}}">Adicionar Movimentos</a>
</div>
@endcan

@if(count($movimentos))
<form method="GET" action="{{route('movimentos.index')}}">

<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Aeronave</th>
            <th>Data Inf</th>
            <th>Data Sup</th>
            <th>Aerodromo de Partida</th>
            <th>Natureza do Voo</th>
            <th>Confirmado</th>
            <th>Piloto</th>
            <th>Instrutor</th>
            <th>Movimentos</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr> 
            <td><input type="text" name="id" class="form-control" id="idid" placeholder="ID" value="{{Request::get('id')}}"></td>
            
            <td>
                <select class="form-control" name="aeronave" id="inputAeronave" >
                    <option value="" selected>Todos</option>
                    @foreach ($aeronaves as $aeronave)
                        <option {{Request::get('aeronave')==$aeronave->matricula?"selected":""}} value="{{$aeronave->matricula}}">{{$aeronave->matricula}} </option>
                    @endforeach
                </select>
            </td>
     
            <td><input type="date" name="data_inf" id="data_inf" class="form-control" value="{{Request::get('data_inf')}}"></td>
            <td><input type="date" name="data_sup" id="data_sup" class="form-control" value="{{Request::get('data_sup')}}"></td>
            <td><input type="text" name="aerodromo_partida" id="aerodromo_partida" class="form-control" value="{{Request::get('aerodromo_partida')}}"></td>
            <td>
                <select name="natureza" class="form-control" id="natureza"> 
                    <option value="" > Todos </option>
                    <option value="T" {{Request::get('natureza')=="T"?"selected":""}}>Treino</option>
                    <option value="I" {{Request::get('natureza')=="I"?"selected":""}}>Instrução</option>
                    <option value="E" {{Request::get('natureza')=="E"?"selected":""}}>Especial</option>
                </select> </td>
            <td>
                <select name="confirmado" class="form-control" id="confirmado" value="{{Request::get('confirmado')}}"> 
                    <option value="" > Todos </option>
                    <option value="0" {{Request::get('confirmado')=="0"?"selected":""}}>0</option>
                    <option value="1" {{Request::get('confirmado')=="1"?"selected":""}}>1</option>
                </select> </td>

           <!-- <td>
                <select class="form-control" name="piloto" id="piloto" >
                    <option value="" selected>Todos</option>
                    @foreach ($users as $user)
                        <option {{Request::get('piloto')==$user->id?"selected":""}} value="{{'x'}}">{{$user->nome_informal}} </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control" name="instrutor" id="instrutor" >
                    <option value="" selected>Todos</option>
                    @foreach ($instrutors as $instrutor)
                        <option {{Request::get('instrutor')==$instrutor->id?"selected":""}} value="{{'x'}}">{{$instrutor->nome_informal}} </option>
                    @endforeach
                </select>
            </td>-->
            <td><input type="text" name="piloto" class="form-control" id="piloto" placeholder="Piloto" value="{{Request::get('piloto')}}"></td>
            <td><input type="text" name="instrutor" class="form-control" id="instrutor" placeholder="Instrutor" value="{{Request::get('instrutor')}}"></td>


            @can('pesquisar', App\Movimento::class)
            <td><select name="meus_movimentos" class="form-control" id="meus_movimentos" value="{{Request::get('meus_movimentos')}}"> 
                    <option value="" {{Request::get('meus_movimentos')==""?"selected":""}}> Todos </option>
                    <option value="1"> Meus </option>
                </select> </td>
            @else
            <td><input type="text" disabled class="form-control" id="meus_movimentos"></td>
            @endcan
            <td><button type="submit" class="btn btn-primary">Pesquisar</button></td>
        </tr>
    </tbody>
</table>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Número do Movimento</th>
            <th>Data do Voo</th>
            <th>Horários do Voo</th>
            <th>Aeronave</th>
            <th>Número Diário</th>
            <th>Número do Serviço</th>
            <th>Piloto</th>
            <th>Natureza do Voo</th>
            <th>Aeródromos</th>
            <th>Número de Aterragens</th>
            <th>Número de Descolagens</th>
            <th>Número de Pessoas a Bordo</th>
            <th>Conta Horas</th>
            <th>Tempo do Voo</th>
            <th>Preço do Voo</th>
            <th>Modo de Pagamento</th>
            <th>Número do Recibo</th>
            <th>Confirmado</th>
            <th>Observações</th>
            <th>Tipo de Instrução</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movimentos as $movimento)
        <tr>
            <td>{{$movimento->id}}</td>
            <td>{{$movimento->data}}</td>
            <td>
            <strong>Descolagem: </strong>{{$movimento->hora_descolagem}}<br>
            <strong>Aterragem: </strong>{{$movimento->hora_aterragem}}</td>
            <td><strong>Matricula: </strong>{{$movimento->aeronaveMov->matricula}} 
            <strong>Modelo: </strong>{{$movimento->aeronaveMov->modelo}} 
            <strong>Marca: </strong>{{$movimento->aeronaveMov->marca}}    
            </td>
            <td>{{$movimento->num_diario}}</td>
            <td>{{$movimento->num_servico}}</td>
            <td>
            <strong>Nome: </strong>{{$movimento->piloto->nome_informal}}<br>
            <strong>Num Licença: </strong> {{$movimento->num_licenca_piloto}}<br>
            <strong>Tipo Licença: </strong>{{$movimento->tipo_licenca_piloto}}<br>
            <strong>Validade Licença: </strong>{{$movimento->validade_licenca_piloto}}<br>
            <strong>Num Certificado: </strong>{{$movimento->num_certificado_piloto}}<br>
            <strong>Classe: </strong>{{$movimento->classe_certificado_piloto}}<br>
            <strong>Validade Certificado: </strong>{{$movimento->validade_certificado_piloto}}<br></td>
            <td>{{$movimento->natureza}}</td>
            <td>
            <strong>Partida: </strong>{{$movimento->aerodromo_partida}}<br>
            <strong>Chegada: </strong>{{$movimento->aerodromo_chegada}}</td>
            <td>{{$movimento->num_aterragens}}</td>
            <td>{{$movimento->num_descolagens}}</td>
            <td>{{$movimento->num_pessoas}}</td>
            <td>
            <strong>Conta Horas Inicial: </strong>{{$movimento->conta_horas_inicio}}<br>
            <strong>Conta Horas Final: </strong>{{$movimento->conta_horas_fim}}</td>
            <td>{{$movimento->tempo_voo}}</td>
            <td>{{$movimento->preco_voo}}</td>
            <td>{{$movimento->modo_pagamento}}</td>
            <td>{{$movimento->num_recibo}}</td>
            <td>{{$movimento->confirmado}}</td>
            <td>
            @if(!empty($movimento->observacoes))
                {{$movimento->observacoes}}
            
            @else
            -
            @endif
            </td>
            <td>
            @if($movimento->natureza=='I')
                <strong>Tipo: </strong>{{$movimento->tipo_instrucao}}<br>
                @can('viewAll',App\Movimento::class)
                <strong>Nome: </strong>{{!empty($movimento->instrutor)?$movimento->instrutor->nome_informal:""}}<br>
                <strong>Num Licença: </strong>{{$movimento->num_licenca_instrutor}}<br>
                <strong>Tipo Licença: </strong>{{$movimento->tipo_licenca_instrutor}}<br>
                <strong>Validade Licenca: </strong>{{$movimento->validade_licenca_instrutor}}<br>
                <strong>Num Certificado: </strong>{{$movimento->num_certificado_instrutor}}<br>
                <strong>Classe: </strong>{{$movimento->classe_certificado_instrutor}}<br>
                <strong>Validade Certificado: </strong>{{$movimento->validade_certificado_instrutor}}<br>
                @endcan
            @else
            -
            @endif
            </td>
 

            
            <td>
                @can('update', $movimento)
                <a class="btn btn-xs btn-primary" href="{{route('movimentos.edit', $movimento)}}">Edit</a>
                @else
                <span class="btn btn-xs btn-secondary disabled">Edit</span>
                @endcan
                @can('delete', $movimento)
                <form action="{{route('movimentos.destroy', $movimento)}}" method="POST" role="form" class="inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
                @else
                <span class="btn btn-xs btn-secondary disabled">Delete</span>
                @endcan
                @can('confirmar', $movimento)
                <form method="POST" action="{{route('movimentos.confirmar', $movimento)}}">
                @csrf 
                @method('PATCH')
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </form>
                @else
                <span class="btn btn-xs btn-secondary disabled">Confirmar</span>
                @endcan
            </td>
        </tr>
        @endforeach
</table>
{{$movimentos->links()}}
@else
<h2>Não foram encontrados movimentos</h2>
@endif
@endsection

