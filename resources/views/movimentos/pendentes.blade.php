@extends('layouts.app')

@section('title', 'Lista de Movimentos Pendentes')

@section('content')

@if(count($movimentos))
<br>

<form method="get" action="{{route('movimentos.pendentes')}}">
@csrf
<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Aeronave</th>
            <th>Data Inf</th>
            <th>Data Sup</th>
            <th>Natureza do Voo</th>
            <th>Confirmado</th>
            <th>Piloto</th>
            <th>Instrutor</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr> 
            <td><input type="text" name="id" class="form-control" id="id" placeholder="ID" value="{{Request::get('id')}}"></td>
            
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
            <td>
                <select name="natureza" class="form-control" id="natureza"> 
                    <option value="" > Todos </option>
                    <option value="T" {{Request::get('natureza')=="T"?"selected":""}}>(T)reino</option>
                    <option value="I" {{Request::get('natureza')=="I"?"selected":""}}>(I)nstrução</option>
                    <option value="E" {{Request::get('natureza')=="E"?"selected":""}}>(E)special</option>
                </select> </td>
            <td>
                <select name="confirmado" class="form-control" id="confirmado" value="{{Request::get('confirmado')}}"> 
                    <option value=""> Todos </option>
                    <option {{Request::get('confirmado')=="0"?"selected":""}}>0</option>
                    <option {{Request::get('confirmado')=="0"?"selected":""}}>1</option>
                </select> </td>
            <td><input type="text" name="piloto" class="form-control" id="piloto" placeholder="Piloto" value="{{Request::get('piloto')}}"></td>
            <td><input type="text" name="instrutor" class="form-control" id="instrutor" placeholder="Instrutor" value="{{Request::get('instrutor')}}"></td>
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
            </td>    


        </tr>
        @endforeach
</table>
{{$movimentos->links()}}
@else
<br>
<h2>Não foram encontrados movimentos</h2>
@endif
@endsection


