<?php

/**
 * 1º Bloco do Formulário - Parte de Cedente
 * Os campos receberam o ID correspondente aos campos do body da API de gerar boleto
*/

?>

<div class="card css-customizado" style="width: 43%;">

    <div class="card-body">

        <p>Dados do Cedente (beneficiado)</p>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="CedenteContaNumero" id="CedenteContaNumero" placeholder="Nº Conta">
                    <label for="CedenteContaNumero">Nº Conta</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="CedenteContaNumeroDV" id="CedenteContaNumeroDV" placeholder="Nº DV">
                    <label for="CedenteContaNumeroDV">Nº DV</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="CedenteConvenioNumero" id="CedenteConvenioNumero" placeholder="Nº Convênio">
                    <label for="CedenteConvenioNumero">Nº Convênio</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <input type="number" class="form-control" name="CedenteContaCodigoBanco" id="CedenteContaCodigoBanco" placeholder="Nº Conta Bancária">
                    <label for="CedenteContaCodigoBanco">Cód. Conta Banco</label>
                </div>
            </div>

        </div>

    </div>

</div>