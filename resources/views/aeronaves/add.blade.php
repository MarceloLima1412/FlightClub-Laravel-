@extends('layouts.app')

@section('title', 'Adicionar Aeronave')

@section('content')

@if (count($errors) > 0)
    @include('shared.errors')
@endif

<form action="{{route('aeronaves.store')}}" method="post" class="form-group">
    @include('aeronaves.partials.add-edit')
<table class="table">
    <tr >
        <th>Unidade</th>
        <th>Minutos</th>
        <th>Preço</th>
    </tr>
    @for($i=1; $i<=10; $i++)
        <tr>
            <td>
                <div class="form-group">
                <input type="text" readonly class="form-control" name="unidades[{{$i}}]" value="{{old("unidades.".$i, $i)}}">
                </div>
            </td>
            <td>
                    <div class="form-group">
                <input type="text"  class="form-control" name="tempos[{{$i}}]" value="{{old("tempos.".$i, 5*round((($i)*6)/5))}}">
            </div>
        </td>
              
                <td>
                        <div class="form-group">
                <input type="text" class="form-control" name="precos[{{$i}}]" value="{{old("precos.".$i)}}">
                </div>
            </td>
        </tr>

    @endfor
    </table>
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a type="submit" class="btn btn-default" href="{{route('aeronaves.index')}}">Cancel</a>
    </div>
</form>
@endsection
