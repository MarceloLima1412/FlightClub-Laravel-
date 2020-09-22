@csrf
@extends('layouts.app')

@section('title', 'Adicionar Aeronave')

@section('content')

@if (count($errors) > 0)
    @include('shared.errors')
@endif

<form action="{{route('tiposlicencas.store')}}" method="post" class="form-group">
<table class="table">
    <tr >
        <th>Code</th>
        <th>Nome</th>
    </tr>
        <tr>
            <td>
                    {{csrf_field()}}
                <div class="form-group">
                <input type="text" class="form-control" name="code" value="{{old('code', $tipos_licenca->code)}}">
                </div>
            </td>
            <td>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nome" value="{{old('nome', $tipos_licenca->nome)}}">
            </div>
        </td>
        </tr>
    </table>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a type="submit" class="btn btn-default" href="{{route('tiposlicencas.index')}}">Cancel</a>
    </div>
</form>
@endsection
