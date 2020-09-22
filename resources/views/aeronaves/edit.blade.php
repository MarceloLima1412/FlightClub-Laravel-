@extends('layouts.app')

@section('title', 'Alterar Aeronave')

@section('content')

@if (count($errors) > 0)
    @include('shared.errors')
@endif

<form action="{{route('aeronaves.update', $aeronave)}}" method="post" class="form-group">
    {{method_field('PUT')}}
    @include('aeronaves.partials.add-edit')
    
    <table class="table">
            <tr >
                <th>Unidade</th>
                <th>Minutos</th>
                <th>Preço</th>
            </tr>
    @foreach ($aeronave -> valores as $i=>$valor)
        <tr>
            <td>
                <div class="form-group">
                <input type="text" class="form-control" readonly name="unidades[{{$i+1}}]" value="{{old("unidades.".($i+1), $valor->unidade_conta_horas)}}">
                </div>
            </td>
            <td>
                    <div class="form-group">
                <input type="text"  class="form-control" name="tempos[{{$i+1}}]" value="{{old("tempos.".($i+1), $valor->minutos)}}">
            </div>
        </td>
              
                <td>
                        <div class="form-group">
                <input type="text" class="form-control" name="precos[{{$i+1}}]" value="{{old("preco.".($i+1), $valor->preco)}}">
                </div>
            </td>
        </tr>

    @endforeach
    </table>

    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a type="submit" class="btn btn-default" name="cancel" href="{{route('aeronaves.index')}}">Cancel</a>
    </div>
</form>
@endsection
