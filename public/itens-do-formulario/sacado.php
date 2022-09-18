<?php

/**
 * 2º Bloco do Formulário - Parte de Sacado
 * Os campos receberam o ID correspondente aos campos do body da API de gerar boleto
*/

?>

<div class="card css-customizado" style="width: 43%;">

    <div class="card-body">

        <p>Dados do Sacado (pagador)</p>

        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoNome" id="SacadoNome" placeholder="Nome">
                    <label for="SacadoNome">Nome</label>
                </div>
            </div>
        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="SacadoCPFCNPJ" id="SacadoCPFCNPJ" placeholder="CPF/CNPJ">
                    <label for="SacadoCPFCNPJ">CPF/CNPJ</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEmail" id="SacadoEmail" placeholder="E-mail">
                    <label for="SacadoEmail">E-mail</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="SacadoTelefone" id="SacadoTelefone" placeholder="Telefone">
                    <label for="SacadoTelefone">Nº Telefone</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="SacadoCelular" id="SacadoCelular" placeholder="Celular">
                    <label for="SacadoCelular">Nº Celular</label>
                </div>
            </div>

        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" onkeyup="AutoCompletar()" name="SacadoEnderecoCEP" id="SacadoEnderecoCEP" placeholder="CEP">
                    <label for="SacadoEnderecoCEP">CEP</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="SacadoEnderecoNumero" id="SacadoEnderecoNumero" placeholder="Nº Residência">
                    <label for="SacadoEnderecoNumero">Nº Residência</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEnderecoComplemento" id="SacadoEnderecoComplemento" placeholder="Complemento">
                    <label for="SacadoEnderecoComplemento">Complemento</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEnderecoCidade" id="SacadoEnderecoCidade" placeholder="Cidade">
                    <label for="SacadoEnderecoCidade">Cidade</label>
                </div>
            </div>

        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEnderecoBairro" id="SacadoEnderecoBairro" placeholder="Bairro">
                    <label for="SacadoEnderecoBairro">Bairro</label>
                </div>
            </div>
            
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEnderecoLogradouro" id="SacadoEnderecoLogradouro" placeholder="Logradouro">
                    <label for="SacadoEnderecoLogradouro">Logradouro</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEnderecoPais" id="SacadoEnderecoPais" placeholder="País">
                    <label for="SacadoEnderecoPais">País</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="SacadoEnderecoUF" id="SacadoEnderecoUF" placeholder="UF">
                    <label for="SacadoEnderecoUF">UF</label>
                </div>
            </div>

        </div>

    </div>

</div>