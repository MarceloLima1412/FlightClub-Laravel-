@extends('layouts.app')

@section('title', 'Adicionar Socios')

@section('content')

@if (count($errors) > 0)
    @include('shared.errors')
@endif

<form action="{{route('socios.store')}}" method="post" class="form-group"  enctype="multipart/form-data">
    @include('socios.partials.add-edit')

    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Add</button>
        <a type="submit" class="btn btn-default" href="{{route('socios.index')}}">Cancel</a>
    </div>
</form>
@endsection
