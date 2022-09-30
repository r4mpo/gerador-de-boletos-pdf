/* Definindo principais variáveis globais e recarregando-as após
o load completo da página HTML - de forma a prevenir erros do JS. */

/* A função a seguir, verifica se há algum preenchimento no campo do código
de protocolo - no formulário do painel administrativo do plugin. Caso haja algum
código já existente, a função o envia para a impressão e, caso o contrário, efetua
a geração de um novo boleto */

function verificarProtocolo() {

    content_type = document.getElementById('content_type').value;
    cnpj_sh = document.getElementById('cnpj_sh').value;
    token_sh = document.getElementById('token_sh').value;
    cnpj_cedente = document.getElementById('cnpj_cedente').value;
    Campo_do_Protocolo = document.getElementById('protocolo').value; 
    
    if(Campo_do_Protocolo == '' || !Campo_do_Protocolo || Campo_do_Protocolo == null || Campo_do_Protocolo == 'undefined') {

        // DADOS DO CEDENTE
        let CedenteContaNumero = document.getElementById('CedenteContaNumero').value;
        let CedenteContaNumeroDV = document.getElementById('CedenteContaNumeroDV').value;
        let CedenteConvenioNumero = document.getElementById('CedenteConvenioNumero').value;
        let CedenteContaCodigoBanco = document.getElementById('CedenteContaCodigoBanco').value;

        // DADOS DO SACADO
        let SacadoNome = document.getElementById('SacadoNome').value;
        let SacadoCPFCNPJ = document.getElementById('SacadoCPFCNPJ').value;
        let SacadoEmail = document.getElementById('SacadoEmail').value;
        let SacadoTelefone = document.getElementById('SacadoTelefone').value;
        let SacadoCelular = document.getElementById('SacadoCelular').value;
        let SacadoEnderecoNumero = document.getElementById('SacadoEnderecoNumero').value;
        let SacadoEnderecoComplemento = document.getElementById('SacadoEnderecoComplemento').value;
        let SacadoEnderecoCEP = document.getElementById('SacadoEnderecoCEP').value;
        let SacadoEnderecoCidade = document.getElementById('SacadoEnderecoCidade').value;
        let SacadoEnderecoBairro = document.getElementById('SacadoEnderecoBairro').value;
        let SacadoEnderecoLogradouro = document.getElementById('SacadoEnderecoLogradouro').value;
        let SacadoEnderecoPais = document.getElementById('SacadoEnderecoPais').value;
        let SacadoEnderecoUF = document.getElementById('SacadoEnderecoUF').value;

        // DADOS DO DOCUMENTO
        let TituloDataEmissao = new Date(document.getElementById('TituloDataEmissao').value);
        let TituloDataVencimento = new Date(document.getElementById('TituloDataVencimento').value);
        let TituloMensagem01 = document.getElementById('TituloMensagem01').value;
        let TituloMensagem02 = document.getElementById('TituloMensagem02').value;
        let TituloMensagem03 = document.getElementById('TituloMensagem03').value;
        let TituloNossoNumero = document.getElementById('TituloNossoNumero').value;
        let TituloNumeroDocumento = document.getElementById('TituloNumeroDocumento').value;
        let TituloValor = document.getElementById('TituloValor').value;
        let TituloLocalPagamento = document.getElementById('TituloLocalPagamento').value;

        // FORMATANDO DATAS
        let DiaEmissao = TituloDataEmissao.getDate() + 1;
        let MesEmissao = TituloDataEmissao.getMonth() + 1;
        let AnoEmissao = TituloDataEmissao.getFullYear();
        let TituloDataEmissaoFormatado = DiaEmissao + '/' + MesEmissao + '/' + AnoEmissao;

        // FORMATANDO DATAS
        let DiaVencimento = TituloDataVencimento.getDate() + 1;
        let MesVencimento = TituloDataVencimento.getMonth() + 1;
        let AnoVencimento = TituloDataVencimento.getFullYear();
        let TituloDataVencimentoFormatado = DiaVencimento + '/' + MesVencimento + '/' + AnoVencimento;

        fetch(`https://homologacao.plugboleto.com.br/api/v1/boletos/lote`, {
            method: 'POST',

            headers: {
                'Content-Type': content_type,
                'cnpj-sh': cnpj_sh,
                'token-sh': token_sh,
                'cnpj-cedente': cnpj_cedente
            },

            body: JSON.stringify([{
                'CedenteContaNumero': `${CedenteContaNumero}`,
                'CedenteContaNumeroDV': `${CedenteContaNumeroDV}`,
                'CedenteConvenioNumero': `${CedenteConvenioNumero}`,
                'CedenteContaCodigoBanco': `${CedenteContaCodigoBanco}`,
                'SacadoNome': `${SacadoNome}`,
                'SacadoCPFCNPJ': `${SacadoCPFCNPJ}`,
                'SacadoEmail': `${SacadoEmail}`,
                'SacadoTelefone': `${SacadoTelefone}`,
                'SacadoCelular': `${SacadoCelular}`,
                'SacadoEnderecoNumero': `${SacadoEnderecoNumero}`,
                'SacadoEnderecoComplemento': `${SacadoEnderecoComplemento}`,
                'SacadoEnderecoCEP': `${SacadoEnderecoCEP}`,
                'SacadoEnderecoCidade': `${SacadoEnderecoCidade}`,
                'SacadoEnderecoBairro': `${SacadoEnderecoBairro}`,
                'SacadoEnderecoLogradouro': `${SacadoEnderecoLogradouro}`,
                'SacadoEnderecoPais': `${SacadoEnderecoPais}`,
                'SacadoEnderecoUF': `${SacadoEnderecoUF}`,
                'TituloDataEmissao': `${TituloDataEmissaoFormatado}`,
                'TituloDataVencimento': `${TituloDataVencimentoFormatado}`,
                'TituloMensagem01': `${TituloMensagem01}`,
                'TituloMensagem02': `${TituloMensagem02}`,
                'TituloMensagem03': `${TituloMensagem03}`,
                'TituloNossoNumero': `${TituloNossoNumero}`,
                'TituloNumeroDocumento': `${TituloNumeroDocumento}`,
                'TituloValor': `${TituloValor}`,
                'TituloLocalPagamento': `${TituloLocalPagamento}`
            }])
        })

        .then(response => response.json())

        .then(data => {
            setTimeout(() => {

                // Definindo variável global e chamando uma nova função
                idintegracao_Boleto = data._dados._sucesso[0].idintegracao;
                SolicitarImpressao(idintegracao_Boleto);

            }, 1000);
        })

        .catch(error => console.log(error))

    } else {

        Imprimir(Campo_do_Protocolo)
    
    }
}

function SolicitarImpressao(idintegracao) {

    fetch(`https://homologacao.plugboleto.com.br/api/v1/boletos/impressao/lote`, {

        method: 'POST',

        headers: {
            'Content-Type': content_type,
            'cnpj-sh': cnpj_sh,
            'token-sh': token_sh,
            'cnpj-cedente': cnpj_cedente
        },

        body: JSON.stringify({
            "TipoImpressao" : "1",
            "Boletos" : [
                `${idintegracao}`  
            ]
        })

    })
    
    .then(response => response.json())
    
    .then(data => {

        // Definindo variável global e chamando uma nova função
        protocolo_Boleto = data._dados.protocolo;
        Imprimir(protocolo_Boleto);

    })

    .catch(error => console.log(error))
}

const Imprimir = async (protocolo) => {

    window.open(`https://homologacao.plugboleto.com.br/api/v1/boletos/impressao/lote/${protocolo}`,"_blank");

    if(Campo_do_Protocolo == '' || !Campo_do_Protocolo || Campo_do_Protocolo == null || Campo_do_Protocolo == 'undefined') {
        let PreencherCampoDoProtocolo = document.getElementById('protocolo').value = protocolo_Boleto;
        let PreencherCampoDoIdIntegracao = document.getElementById('idintegracao').value = idintegracao_Boleto;
    }
    
}