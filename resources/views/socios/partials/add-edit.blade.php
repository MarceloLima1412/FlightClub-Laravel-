{{csrf_field()}}

<div class="form-group" style="margin-bottom: 20px">
    <div class="form-group">
        <img src="{{ $socio->foto_url == null ? asset('storage/fotos/noimage.jpg') : asset('storage/fotos/' . $socio->foto_url)}}" class="img-thumbnail"/>
    </div>


<div class="form-group">
    <label for="inputNome_informal">Nome Informal</label>
    <input type="text" class="form-control" name="nome_informal" id="inputNome_informal" value="{{old('nome_informal', $socio->nome_informal)}}" />
</div>


<div class="form-group">
    <label for="inputName">Nome</label>
    <input type="text" class="form-control" name="name" id="inputName" value="{{old('name', $socio->name)}}" />
</div>


<div class="form-group">
    <label for="inputData_nascimento">Data de Nascimento</label>
    <input type="date" class="form-control" name="data_nascimento" id="inputData_nascimento" value="{{old('data_nascimento', $socio->data_nascimento)}}"/>
</div>


<div class="form-group">
    <label for="inputEmail">E-mail</label>
    <input type="text" class="form-control" name="email" id="inputEmail" value="{{old('email', $socio->email)}}" />
</div>

<div class="form-group">
    <label for="inputFile_foto">Foto de Perfil</label>
        <input type="file" class="form-control" name="file_foto" id="inputFile_foto"/>
</div>

<div class="form-group">
    <label for="inputNif">NIF</label>
    <input type="text" class="form-control" name="nif" id="inputNif" value="{{old('nif', $socio->nif)}}" />
</div>

<div class="form-group">
    <label for="inputTelefone">Telefone</label>
    <input type="text" class="form-control" name="telefone" id="inputTelefone" value="{{old('telefone', $socio->telefone)}}" />
</div>

<div class="form-group">
    <label for="inputEndereco">Endereço</label>
    <textarea class="form-control" name="endereco" id="inputEndereco">
        {{old('endereco', $socio->endereco)}}
    </textarea>
</div>


<!-- CAMPOS PARA OS PILOTOS -->
@can('direcaoOuPiloto', $socio)
<div id="divNumLicenca">
<div class="form-group">
    <label for="inputNum_licenca">Número de Licença</label>
    <input type="text" class="form-control" name="num_licenca" id="inputNum_licenca" value="{{old('num_licenca', $socio->num_licenca)}}" />
</div>
</div>

<!--
<div class="form-group">
    <label for="inputTipo_licenca">Tipo de Licença</label>
    <input type="text" class="form-control" name="tipo_licenca" id="inputTipo_licenca" value="{{old('tipo_licenca', $socio->tipo_licenca)}}" />
</div>
-->
<div id="divTipoLicenca">
<div class="form-group">
    <label for="inputTipo_licenca">Tipo de Licença</label>
    <select class="form-control" name="tipo_licenca" id="inputTipo_licenca" >
    <option disabled selected> -- Select an option -- </option>
    @foreach ($tipos_licencas as $tipo_licenca)
        <option {{strval(old('tipo_licenca',$socio->tipo_licenca))==$tipo_licenca->code?"selected":""}} value="{{$tipo_licenca->code}}">{{$tipo_licenca->nome}} </option>
    @endforeach
    </select>
</div>
</div>

<div id="divNumCertificado">
<div class="form-group">
    <label for="inputNum_certificado">Número do Certificado</label>
    <input type="text" class="form-control" name="num_certificado" id="inputNum_certificado" value="{{old('num_certificado', $socio->num_certificado)}}" />
</div>
</div>
<!--
<div class="form-group">
    <label for="inputClasse_certificado">Classe do Certificado</label>
    <input type="text" class="form-control" name="classe_certificado" id="inputClasse_certificado" value="{{old('classe_certificado', $socio->classe_certificado)}}" />
</div>
-->
<div id="divClasse">
<div class="form-group">
    <label for="inputClasse_certificado">Classe do Certificado</label>
    <select class="form-control" name="classe_certificado" id="inputClasse_certificado" >
    <option disabled selected> -- Select an option -- </option>
    @foreach ($classes_certificados as $classe_certificado)
        <option {{strval(old('classe_certificado',$socio->classe_certificado))==$classe_certificado->code?"selected":""}} value="{{$classe_certificado->code}}">{{$classe_certificado->nome}} </option>
    @endforeach
    </select>
</div>
</div>

<div id="divValidadeL">
<div class="form-group">
    <label for="inputValidade_licenca">Validade da Licença</label>
    <input type="date" class="form-control" name="validade_licenca" id="inputValidade_licenca" value="{{old('validade_licenca', $socio->validade_licenca)}}"/>
</div>
</div>

<div id="divValidadeC">
<div class="form-group">
    <label for="inputValidade_certificado">Validade do Certificado</label>
    <input type="date" class="form-control" name="validade_certificado" id="inputValidade_certificado" value="{{old('validade_certificado', $socio->validade_certificado)}}"/>
</div>
</div>
@endcan

<!-- CAMPOS SÓ PARA A DIREÇÃO -->
@can('ativar', $socio)
<div class="form-group">
    <label for="inputNum_socio">Número de Sócio</label>
    <input type="text" class="form-control" name="num_socio" id="inputNum_socio" value="{{old('num_socio', $socio->num_socio)}}" />
</div>

<div class="form-group">
    <label for="inputSexo">Sexo</label>
    <select class="form-control" name="sexo" id="inputSexo" >
    
    <option disabled selected> -- Select an option -- </option>
    <option value="F" {{strval(old('sexo',$socio->sexo))=='F'?"selected":""}}> Feminino </option>
    <option value="M" {{strval(old('sexo',$socio->sexo))=='M'?"selected":""}}> Masculino </option>
    </select>
</div>

<div class="form-group">
    <label for="inputTipo_socio">Tipo de Sócio</label>
    <select class="form-control" name="tipo_socio" id="inputTipo_socio" onchange="myFunction()" >
    
    <option disabled selected> -- Select an option -- </option>
    <option value="P" {{strval(old('tipo_socio',$socio->tipo_socio))=='P'?"selected":""}}> Piloto </option>
    <option value="NP" {{strval(old('tipo_socio',$socio->tipo_socio))=='NP'?"selected":""}}> Não Piloto </option>
    <option value="A" {{strval(old('tipo_socio',$socio->tipo_socio))=='A'?"selected":""}}> Aeromodelista </option>
    </select>
</div>



<div class="form-group">
    <label for="inputQuota_paga">Quota Paga</label>
    <select class="form-control" name="quota_paga" id="inputQuota_paga" >

    <option disabled selected> -- Select an option -- </option>
    <option value="0" {{strval(old('quota_paga',$socio->quota_paga))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('quota_paga',$socio->quota_paga))=='1'?"selected":""}}> 1 </option>
    </select>
</div>


<div class="form-group">
    <label for="inputAtivo">Ativo</label>
    <select class="form-control" name="ativo" id="inputAtivo" >

    <option disabled selected> -- Select an option -- </option>
    <option value="0" {{strval(old('ativo',$socio->ativo))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('ativo',$socio->ativo))=='1'?"selected":""}}> 1 </option>
    </select>
</div>

<!--    NECESSÁRIO??
<div class="form-group">
    <label for="inputPassword_inicial">Password Unicial</label>
    <select class="form-control" name="password_inicial" id="inputPassword_inicial" >

    <option disabled selected> -- Select an option -- </option>
    <option value='0' {{strval(old('password_inicial',$socio->password_inicial))=='0'?"selected":""}}> 0 </option>
    <option value='1' {{strval(old('password_inicial',$socio->password_inicial))=='1'?"selected":""}}> 1 </option>
    </select>
</div>
-->

<div class="form-group">
    <label for="inputDirecao">Direção</label>
    <select class="form-control" name="direcao" id="inputDirecao" >

    <option disabled selected> -- Select an option -- </option>
    <option value="0" {{strval(old('direcao',$socio->direcao))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('direcao',$socio->direcao))=='1'?"selected":""}}> 1 </option>
    </select>
</div>


<!-- FAZER O RETURN DA PATH DA FOTO PARA ENVIAR PARA A BD -->


<div id="divFicheiroL">
<div class="form-group">
    <label for="inputLicenca">Ficheiro Licença</label>
        <input type="file" class="form-control" name="file_licenca" id="inputFile_licenca"/>
</div>
</div>

<div id="divFicheiroC">
<div class="form-group">
    <label for="inputCertificado">Ficheiro Certificado</label>
        <input type="file" class="form-control" name="file_certificado" id="inputFile_certificado"/>
</div>
</div>

<!--
<div class="form-group">
    <label for="inputNum_licenca">Numero Licenca</label>
    <input type="file" class="form-control" name="num_licenca" id="inputNum_licenca" />
</div>
-->


<div id="divInstrutor">
<div class="form-group">
    <label for="inputInstrutor">Instrutor</label>
    <select class="form-control" name="instrutor" id="inputInstrutor" >

    <option disabled selected value=""> -- Select an option -- </option>

    <option value="0" {{strval(old('instrutor',$socio->instrutor))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('instrutor',$socio->instrutor))=='1'?"selected":""}}> 1 </option>
    <option value="" {{strval(old('instrutor',$socio->instrutor))==''?"selected":""}}> Null </option>
    </select>
</div>
</div>

<div id="divAluno">
<div class="form-group">
    <label for="inputAluno">Aluno</label>
    <select class="form-control" name="aluno" id="inputAluno" >

    <option disabled selected value=""> -- Select an option -- </option>
    <option value="0" {{strval(old('aluno',$socio->aluno))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('aluno',$socio->aluno))=='1'?"selected":""}}> 1 </option>
    <option value="" {{strval(old('aluno',$socio->aluno))==''?"selected":""}}> Null </option>
    </select>
</div>
</div>



<div id="divLicencaC">
<div class="form-group">
    <label for="inputConfirmado">Licença Confirmada</label>
    <select class="form-control" name="licenca_confirmada" id="inputLicenca_confirmada" >

    <option disabled selected> -- Select an option -- </option>
    <option value="0" {{strval(old('licenca_confirmada',$socio->licenca_confirmada))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('licenca_confirmada',$socio->licenca_confirmada))=='1'?"selected":""}}> 1 </option>
    </select>
</div>
</div>





<div id="divCertificadoC">
<div class="form-group">
    <label for="inputCertificado_confirmado">Certificado Confirmado</label>
    <select class="form-control" name="certificado_confirmado" id="inputCertificado_confirmado" >

    <option disabled selected> -- Select an option -- </option>
    <option value="0" {{strval(old('certificado_confirmado',$socio->certificado_confirmado))=='0'?"selected":""}}> 0 </option>
    <option value="1" {{strval(old('certificado_confirmado',$socio->certificado_confirmado))=='1'?"selected":""}}> 1 </option>
    </select>
</div>
</div> 
@endcan

<script> 
    myFunction();
    function myFunction() 
    {
        var x = document.getElementById("inputTipo_socio").value;
        
        if(x  === 'P')
        {
            document.getElementById("divInstrutor").style.display = 'inline';
            document.getElementById("divValidadeC").style.display = 'inline';
            document.getElementById("divAluno").style.display = 'inline';
            document.getElementById("divValidadeL").style.display = 'inline';
            document.getElementById("divNumLicenca").style.display = 'inline';
            document.getElementById("divTipoLicenca").style.display = 'inline';
            document.getElementById("divNumCertificado").style.display = 'inline';
            document.getElementById("divClasse").style.display = 'inline';
            document.getElementById("divCertificadoC").style.display = 'inline';
            document.getElementById("divLicencaC").style.display = 'inline';
            document.getElementById("divFicheiroC").style.display = 'inline';
            document.getElementById("divFicheiroL").style.display = 'inline';
        }
        else 
        {
            document.getElementById("divInstrutor").style.display = 'none';
            document.getElementById("divValidadeC").style.display = 'none';
            document.getElementById("divAluno").style.display = 'none';
            document.getElementById("divValidadeL").style.display = 'none';
            document.getElementById("divNumLicenca").style.display = 'none';
            document.getElementById("divTipoLicenca").style.display = 'none';
            document.getElementById("divNumCertificado").style.display = 'none';
            document.getElementById("divClasse").style.display = 'none';
            document.getElementById("divCertificadoC").style.display = 'none';
            document.getElementById("divLicencaC").style.display = 'none';
            document.getElementById("divFicheiroC").style.display = 'none';
            document.getElementById("divFicheiroL").style.display = 'none';
        }
    }
</script>

