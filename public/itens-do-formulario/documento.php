<?php

/**
 * 3º Bloco do Formulário - Parte de Documento
 * Os campos receberam o ID correspondente aos campos do body da API de gerar boleto
*/

?>

<div class="card css-customizado" style="width: 43%;">

    <div class="card-body">

        <p>Dados do Documento</p>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="date" class="form-control" name="TituloDataEmissao" id="TituloDataEmissao">
                    <label for="TituloDataEmissao">Data Emissão</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="date" class="form-control" name="TituloDataVencimento" id="TituloDataVencimento">
                    <label for="TituloDataVencimento">Data Vencimento</label>
                </div>
            </div>

        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="TituloMensagem01" id="TituloMensagem01" placeholder="Advertência">
                    <label for="TituloMensagem01">Advertência</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="TituloMensagem02" id="TituloMensagem02" placeholder="Advertência">
                    <label for="TituloMensagem02">Advertência</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="TituloMensagem03" id="TituloMensagem03" placeholder="Advertência">
                    <label for="TituloMensagem03">Advertência</label>
                </div>
            </div>

        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="TituloNossoNumero" id="TituloNossoNumero" placeholder="Nosso Nº">
                    <label for="TituloNossoNumero">Nosso Nº</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="TituloNumeroDocumento" id="TituloNumeroDocumento" placeholder="Nº Documento">
                    <label for="TituloNumeroDocumento">Nº Documento</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" step="0.00" class="form-control" name="TituloValor" id="TituloValor" placeholder="Valor (R$)">
                    <label for="TituloValor">Valor (R$)</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" value="Pagável em qualquer banco até o vencimento." name="TituloLocalPagamento" id="TituloLocalPagamento" placeholder="Local Pag.">
                    <label for="TituloLocalPagamento">Local Pag.</label>
                </div>
            </div>

        </div>

    </div>
    
</div>