@extends('layouts.app')

@section('title', 'Alterar Socios')

@section('content')

@if (count($errors) > 0)
    @include('shared.errors')
@endif

<form action="{{route('socios.update', $socio->id)}}" method="post" class="form-group" enctype="multipart/form-data">
    {{method_field('PUT')}}
    @include('socios.partials.add-edit')
    <div class="form-group">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a type="submit" class="btn btn-default" name="cancel" href="{{route('socios.index')}}">Cancel</a>
    </div>
</form>


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



@endsection
