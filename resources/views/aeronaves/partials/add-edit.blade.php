{{csrf_field()}}
<div class="form-group">
    <label for="inputMatricula">Matricula</label>
    <input type="text" class="form-control" name="matricula" id="inputMatricula"
        value="{{old('matricula', $aeronave->matricula)}}" />
</div>

<div class="form-group">
    <label for="inputMarca">Marca</label>
    <input type="text" class="form-control" name="marca" id="inputMarca" value="{{old('marca', $aeronave->marca)}}" />
</div>

<div class="form-group">
    <label for="inputModelo">Modelo</label>
    <input type="text" class="form-control" name="modelo" id="inputModelo" value="{{old('marca', $aeronave->modelo)}}" />
</div>

<div class="form-group">
    <label for="inputNum_lugares">Numero de Lugares</label>
    <input type="text" class="form-control" name="num_lugares" id="inputNum_lugares"
        value="{{old('num_lugares', $aeronave->num_lugares)}}" />
</div>

<div class="form-group">
    <label for="inputConta_horas">Conta Horas</label>
    <input type="text" class="form-control" name="conta_horas" id="inputConta_horas"
        value="{{old('conta_horas', $aeronave->conta_horas)}}" />
</div>
<div class="form-group">
    <label for="inputPreco_hora">Preço por Hora</label>
    <input type="text" class="form-control" name="preco_hora" id="inputPreco_hora"
        value="{{old('preco_hora', $aeronave->preco_hora)}}" />
</div>
<div id="divCertificado">
    <div class="form-group">
        <label for="inputCertificado">Certificado</label>
        <select class="form-control" name="tipo_certificacao" id="inputCertificado" >
        <option disabled selected value=""> -- Select an option -- </option>
        <option {{strval(old('tipo_certificacao',$aeronave->tipo_certificacao))=='C'?"selected":""}} value="C">Certificado</option>
        <option {{strval(old('tipo_certificacao',$aeronave->tipo_certificacao))=='X'?"selected":""}} value="X">Experimental</option>
        <option {{strval(old('tipo_certificacao',$aeronave->tipo_certificacao))=='UL'?"selected":""}} value="UL">Ultra-Leve</option>
        </select>
    </div>
</div>
