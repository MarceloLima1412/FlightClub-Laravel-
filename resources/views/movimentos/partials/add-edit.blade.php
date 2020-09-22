{{csrf_field()}}

<div class="form-group">
    <label for="inputData">Data do Voo</label>
    <input type="date" class="form-control" name="data" id="inputData" value="{{old('data', $movimento->data??date("Y-m-d"))}}" />
</div>

<div class="form-group">
    <label for="inputHoraDescolagem">Hora da Descolagem</label>
    <input type="time" class="form-control" name="hora_descolagem" id="inputHoraDescolagem" value="{{date("H:i",strtotime(old('hora_descolagem', $movimento->hora_descolagem??date("H:i"))))}}"/>
</div>

<div class="form-group">
    <label for="inputHoraAterragem">Hora da Aterragem</label>
    <input type="time" class="form-control" name="hora_aterragem" id="inputHoraAterragem" value="{{date("H:i",strtotime(old('hora_aterragem', $movimento->hora_aterragem??date("H:i"))))}}"/>
</div>

<div class="form-group">
    <label for="inputAeronave">Aeronave</label>
    <select class="form-control" name="aeronave" id="inputAeronave" >
    @foreach ($aeronaves as $aeronave)
        <option {{strval(old('aeronave',$movimento->aeronave))==$aeronave->matricula?"selected":""}} value="{{$aeronave->matricula}}">{{$aeronave->matricula}} </option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputNumDiario">Número Diário</label>
    <input type="text" class="form-control" name="num_diario" id="inputNumDiario" value="{{old('num_diario', $movimento->num_diario)}}" />
</div>

<div class="form-group">
    <label for="inputNumServico">Número do Serviço</label>
    <input type="text" class="form-control" name="num_servico" id="inputNumServico" value="{{old('num_servico', $movimento->num_servico)}}" />
</div>

<div class="form-group">
    <label for="inputPiloto">Piloto</label>
    <select class="form-control" name="piloto_id" id="inputPiloto" >
    <option disabled selected> -- Select an option -- </option>
    @foreach ($users as $user)
        <option {{strval(old('piloto_id',$movimento->piloto_id??auth()->user()->id))==$user->id?"selected":""}} value="{{$user->id}}">{{$user->nome_informal}} </option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputNaturezaVoo">Natureza do Voo</label>
    <select class="form-control" name="natureza" id="inputNaturezaVoo" onchange="myFunction()" >
    <option disabled selected> -- Select an option -- </option>
    <option value="T" {{strval(old('natureza',$movimento->natureza))=='T'?"selected":""}}> Treino </option>
    <option value="I" {{strval(old('natureza',$movimento->natureza))=='I'?"selected":""}}> Instrução </option>
    <option value="E" {{strval(old('natureza',$movimento->natureza))=='E'?"selected":""}}> Especial </option>
    </select>
</div>

<div class="form-group">
    <label for="inputAerodromoPartida">Aeródromo de Partida</label>
    <select class="form-control" name="aerodromo_partida" id="inputAerodromoPartida" >
    <option disabled selected> -- Select an option -- </option>
    @foreach ($aerodromos as $aerodromo)
        <option {{strval(old('aerodromo_partida',$movimento->aerodromo_partida))==$aerodromo->code?"selected":""}} value="{{$aerodromo->code}}">{{$aerodromo->nome}} </option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputAerodromoChegada">Aeródromo de Chegada</label>
    <select class="form-control" name="aerodromo_chegada" id="inputAerodromoChegada" >
    <option disabled selected> -- Select an option -- </option>
    @foreach ($aerodromos as $aerodromo)
        <option {{strval(old('aerodromo_chegada',$movimento->aerodromo_chegada))==$aerodromo->code?"selected":""}} value="{{$aerodromo->code}}">{{$aerodromo->nome}} </option>
    @endforeach
    </select>
</div>

<div class="form-group">
    <label for="inputNumAterragens">Número de Aterragens</label>
    <input type="text" class="form-control" name="num_aterragens" id="inputNumAterragens" value="{{old('num_aterragens', $movimento->num_aterragens)}}" />
</div>

<div class="form-group">
    <label for="inputNumDescolagens">Número de Descolagens</label>
    <input type="text" class="form-control" name="num_descolagens" id="inputNumDescolagens" value="{{old('num_descolagens', $movimento->num_descolagens)}}" />
</div>

<div class="form-group">
    <label for="inputNumPessoasBordo">Número de Pessoas a Bordo</label>
    <input type="text" class="form-control" name="num_pessoas" id="inputNumPessoasBordo" value="{{old('num_pessoas', $movimento->num_pessoas)}}" />
</div>

<div class="form-group">
    <label for="inputContaHorasInicial">Conta Horas Inicial</label>
    <input type="text" class="form-control" name="conta_horas_inicio" id="inputContaHorasInicial" value="{{old('conta_horas_inicio', $movimento->conta_horas_inicio)}}" />
</div>

<div class="form-group">
    <label for="inputContaHorasFinal">Conta Horas Final</label>
    <input type="text" class="form-control" name="conta_horas_fim" id="inputContaHorasFinal" value="{{old('conta_horas_fim', $movimento->conta_horas_fim)}}" />
</div>

<div class="form-group">
    <label for="inputTempoVoo">Tempo do Voo</label>
    <input type="text" disabled class="form-control" name="tempo_voo" id="inputTempoVoo" value="{{old('tempo_voo', $movimento->tempo_voo)}}" />
</div>

<div class="form-group">
    <label for="inputPrecoVoo">Preço do Voo</label>
    <input type="text" disabled class="form-control" name="preco_voo" id="inputPrecoVoo" value="{{old('preco_voo', $movimento->preco_voo)}}" />
</div>

<div class="form-group">
    <label for="inputModoPagamento">Modo de Pagamento</label>
    <select class="form-control" name="modo_pagamento" id="inputModoPagamento" >

    <option disabled selected> -- Select an option -- </option>
    <option value="N" {{strval(old('modo_pagamento',$movimento->modo_pagamento))=='N'?"selected":""}}> Numerário </option>
    <option value="M" {{strval(old('modo_pagamento',$movimento->modo_pagamento))=='M'?"selected":""}}> Multibanco </option>
    <option value="T" {{strval(old('modo_pagamento',$movimento->modo_pagamento))=='T'?"selected":""}}> Tranferência </option>
    <option value="P" {{strval(old('modo_pagamento',$movimento->modo_pagamento))=='P'?"selected":""}}> Pacote de horas </option>
    </select>
</div>

<div class="form-group">
    <label for="inputNumRecibo">Número do Recibo</label>
    <input type="text" class="form-control" name="num_recibo" id="inputNumRecibo" value="{{old('num_recibo', $movimento->num_recibo)}}" />
</div>

<div class="form-group">
    <label for="inputObservacoes">Observações</label>
    <textarea class="form-control" name="observacoes" 
    id="inputObservacoes">{{old('observacoes', $movimento->observacoes)}}</textarea>
</div>

<div id="divTInstrutor">
    <div class="form-group">
        <label for="inputTipoInstrucao" >Tipo de Instrução</label>
        <select class="form-control" name="tipo_instrucao" id="inputTipoInstrucao" >
        <option disabled selected value=""> -- Select an option -- </option>
        <option {{strval(old('tipo_instrucao',$movimento->tipo_instrucao))=='D'?"selected":""}} value="D">Duplo Comando</option>
        <option {{strval(old('tipo_instrucao',$movimento->tipo_instrucao))=='S'?"selected":""}} value="S">Solo</option>
        </select>
    </div>
</div>

<div id="divInstrutor">
    <div class="form-group">
        <label for="inputInstrutor" >Instrutor</label>
        <select class="form-control" name="instrutor_id" id="inputInstrutor" >
        <option disabled selected> -- Select an option -- </option>
        @foreach ($instrutors as $instrutor)
            <option {{strval(old('instrutor_id',$movimento->instrutor_id))==$instrutor->id?"selected":""}} value="{{$instrutor->id}}">{{$instrutor->nome_informal}} </option>
        @endforeach
        </select>
    </div>
</div>

<script> 
    myFunction();
    function myFunction() 
    {
        var x = document.getElementById("inputNaturezaVoo").value;
        
        if(x  === 'I')
        {
            document.getElementById("divTInstrutor").style.display = 'inline';
            //document.getElementById("inputTipoInstrucao").style.display = 'inline';
            document.getElementById("divInstrutor").style.display = 'inline';
            //document.getElementById("inputInstrutor").style.display = 'inline';
        }
        else 
        {
            document.getElementById("divTInstrutor").style.display = 'none';
            //document.getElementById("inputTipoInstrucao").style.display = 'none';
            document.getElementById("divInstrutor").style.display = 'none';
            //document.getElementById("inputInstrutor").style.display = 'none';
        }
    }
</script>

