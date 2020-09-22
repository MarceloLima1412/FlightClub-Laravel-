@extends('layouts.app')

@section('title', 'Lista de Socios')

@section('content')

@can('create', App\User::class)
<div>
    <a class="btn btn-primary" href="{{route('socios.create')}}">Adicionar Socios</a>
</div>
@endcan

@can('reset', App\User::class)  
    <form  method="POST" action="{{route('socios.reset_quotas')}}" role="form" class="inline">
        @csrf
        @method('patch')                
        <button type="submit" class="btn btn-primary">Reset Todas Quotas</button>
    </form>
@endcan

@can('ativar', App\User::class)  
    <form method="POST"  action="{{route('socios.desativa_sem_quotas')}}"role="form" class="inline">
        @csrf
        @method('patch')                
        <button type="submit" class="btn btn-primary">Ativa/Desativa Sem Quotas</button>
    </form>
@endcan  


@if(count($socios))
<!-- PESQUISA -->
<form method="GET" action="{{route('socios.index')}}">
@csrf
<table class="table table-striped">
    <thead>
        <tr>
            <th>Número de Sócio</th>
            <th>Nome Informal</th>
            <th>Email</th>
            <th>Tipo de Sócio</th>
            <th>Pertence à direção</th>
            <th>Quotas em dia</th>
            <th>Ativo</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr> 
            <td><input type="text" name="num_socio" class="form-control" id="num_socio" placeholder="Número de Sócio" value="{{Request::get('num_socio')}}"></td>
            
            <td>
            <select class="form-control" name="nome_informal" id="inputNome_informal" >
            <option value="" selected>Todos</option>
            @foreach ($socios as $socio)
                <option {{Request::get('socio')==$socio->nome_informal?"selected":""}} value="{{$socio->nome_informal}}">{{$socio->nome_informal}} </option>
            @endforeach
            </select>
            </td>
     
            <td><input type="text" name="email" id="email" class="form-control" value="{{Request::get('email')}}"></td>

            <td>
                <select name="tipo" class="form-control" id="tipo_socio" value="{{Request::get('tipo')}}"> 
                    <option value="" selected> Todos </option>
                    <option value="P">Piloto</option>
                    <option value="NP">Não Piloto</option>
                    <option value="A">Aeromodelista</option>
                </select> </td>

            <td>
                <select name="direcao" class="form-control" id="direcao" value="{{Request::get('direcao')}}"> 
                    <option value="" selected> Todos </option>
                    <option >0</option>
                    <option >1</option>
                </select> </td>
            
            @can('ativar', App\User::class)
            <td>
                <select name="quotas_pagas" class="form-control" id="quota_paga" value="{{Request::get('quotas_pagas')}}"> 
                    <option value="" selected> Todos </option>
                    <option >0</option>
                    <option >1</option>
                </select> </td>
            @else
            <td><input type="text" disabled class="form-control" id="quota_paga"></td>
            @endcan    

            @can('ativar', App\User::class)
            <td>
                <select name="ativo" class="form-control" id="ativo" value="{{Request::get('ativo')}}"> 
                    <option value="" selected> Todos </option>
                    <option >0</option>
                    <option >1</option>
                </select> </td>
            @else
            <td><input type="text" disabled class="form-control" id="ativo"></td>
            @endcan    

            <td><button type="submit" class="btn btn-primary">Pesquisar</button></td>
        </tr>
    </tbody>
</table>
</form>

<!-- END PESQUISA -->


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
            <th>Quotas em dia</th>
            <th>Pertence á direção</th>
            <th>Ativo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($socios as $socio)
        <tr>
            <td><img src="{{ $socio->foto_url == null ? asset('storage/fotos/noimage.jpg') : asset('storage/fotos/' . $socio->foto_url)}}"></td>
            <td>{{$socio->num_socio}}</td>
            <td>{{$socio->nome_informal}}</td>
            <td>{{$socio->name}}</td>
            <td>{{$socio->sexo}}</td>
            <td>{{$socio->data_nascimento}}</td>
            <td>{{$socio->email}}</td>
            <td>{{$socio->nif}}</td>
            <td>{{$socio->telefone}}</td>
            <td>{{$socio->endereco}}</td>
            <td>{{$socio->tipo_socio}}
                 @if ($socio->tipo_socio=='P')   
                 <br><strong>Tipo Licença: </strong>{{$socio->tipo_licenca}}
                 <br><strong>Nº Certificado: </strong>{{$socio->num_certificado}}
                 <br><strong>Classe Certificado: </strong>{{$socio->classe_certificado}}
                 <br><strong>Validade Licença: </strong>{{$socio->validade_licenca}}
                 <br><strong>Validade Certificado: </strong>{{$socio->validade_certificado}}
                 @endif
            </td>
            <td>{{$socio->quota_paga}}</td>
            <td>{{$socio->direcao}}</td>
            <td>{{$socio->ativo}}</td>
            


            <td>
                @can('update', $socio)
                <a class="btn btn-xs btn-primary" href="{{route('socios.edit', $socio)}}">Edit</a>
                @else
                <span class="btn btn-xs btn-secondary disabled">Edit</span>
                @endcan
                @can('delete', $socio)

                <!-- FAZER PARA AS QUOTAS IGUAL AO "DELETE" -->
                <!--  -->
                <form method="POST" action="{{route('socios.destroy', $socio)}}" role="form" class="inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>

                @else
                <span class="btn btn-xs btn-secondary disabled">Delete</span>
                @endcan

                <!-- BOTÃO RESET QUOTAS -->
                @can('reset', $socio)
                    <form method="POST" action="{{route('socios.quota', $socio)}}"  role="form" class="inline">
                    @csrf
                    @method('patch')
                    <input type = "hidden" name="quota_paga" value="">
                        <button type="submit" class="btn btn-primary">Reset Quotas</button>
                    </form>
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Reset Quotas</span>
                @endcan

                <!-- BOTÃO ATIVA/DESATIVA SOCIOS -->
                @can('ativar', $socio)
                    <form  method="POST"  action="{{route('socios.ativar', $socio)}}"role="form" class="inline">
                    @csrf
                    @method('patch')
                    <input type = "hidden" name="ativo" value="">
                        <button type="submit" class="btn btn-primary">Ativar/Desativar</button>
                    </form>
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Ativar/Desativar</span>
                @endcan

                <!-- BOTÃO REENVIAR EMAIL DE ATIVAÇÃO DE CONTA -->
                @can('ativar', $socio)
                    <form  method="POST" action="{{route('socios.send', $socio)}}" role="form" class="inline">
                    @csrf
                    @method('patch')
                    <input type = "hidden" name="send" value="">
                        <button type="submit" class="btn btn-primary">Reenviar Email Confirm.</button>
                    </form>
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Reenviar Email Confirm.</span>
                @endcan                
                

                <!-- BOTÃO PARA MOSTRAR CERTIFICADO  -->
                @can('podeVerDocumentos', $socio)
                @if (Storage::disk('local')->exists('docs_piloto/certificado_'.$socio->id.'.pdf'))
                    <form action="{{route('socios.mostraCertificado', $socio)}}" method="GET" role="form" class="inline">
                        <button type="submit" class="btn btn-primary">Ver Certificado</button>
                    </form>
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Sem fich Certificado</span>
                    @endif
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Ver Certificado</span>
                @endcan
                

                <!-- BOTÃO PARA MOSTRAR LICENCA -->
                @can('podeVerDocumentos', $socio)
                @if (Storage::disk('local')->exists('docs_piloto/certificado_'.$socio->id.'.pdf'))
                    <form action="{{route('socios.mostraLicenca', $socio)}}" method="GET" role="form" class="inline">
                        <button type="submit" class="btn btn-primary">Ver Licença</button>
                    </form>
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Sem fich Licença</span>
                    @endif
                    @else
                    <span class="btn btn-xs btn-secondary disabled">Ver Licença</span>
                @endcan

            </td>
        </tr>
        @endforeach
</table>
{{$socios->links()}}
@else
<h2>Não foram encontrados socios</h2>
@endif
@endsection