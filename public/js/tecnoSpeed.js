/**
 * 
 * Este arquivo JS é responsável
 * pelas requisições relacionadas ao boleto.
 * A API é a TecnoSpeed/PlugBoleto
 * Créditos à API - agradecimentos ao suporte técnico: https://atendimento.tecnospeed.com.br/hc/pt-br
 *  
 * Vale ressaltar que este plugin foi desenvolvido com o uso
 * das informações fornecidas pela API para testes (...)
*/

function incluirBoleto() {


    /* DADOS DO CEDENTE */
    let CedenteContaNumero = document.getElementById('CedenteContaNumero').value;
    let CedenteContaNumeroDV = document.getElementById('CedenteContaNumeroDV').value;
    let CedenteConvenioNumero = document.getElementById('CedenteConvenioNumero').value;
    let CedenteContaCodigoBanco = document.getElementById('CedenteContaCodigoBanco').value;

    /* DADOS DO SACADO */
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

    /* DADOS DO DOCUMENTO */
    let TituloDataEmissao = new Date(document.getElementById('TituloDataEmissao').value);
    let TituloDataVencimento = new Date(document.getElementById('TituloDataVencimento').value);
    let TituloMensagem01 = document.getElementById('TituloMensagem01').value;
    let TituloMensagem02 = document.getElementById('TituloMensagem02').value;
    let TituloMensagem03 = document.getElementById('TituloMensagem03').value;
    let TituloNossoNumero = document.getElementById('TituloNossoNumero').value;
    let TituloNumeroDocumento = document.getElementById('TituloNumeroDocumento').value;
    let TituloValor = document.getElementById('TituloValor').value;
    let TituloLocalPagamento = document.getElementById('TituloLocalPagamento').value;

    /* Formatando as datas - Data de Emissão */
    let DiaEmissao = TituloDataEmissao.getDate() + 1;
    let MesEmissao = TituloDataEmissao.getMonth() + 1;
    let AnoEmissao = TituloDataEmissao.getFullYear();
    let TituloDataEmissaoFormatado = DiaEmissao + '/' + MesEmissao + '/' + AnoEmissao;

    /* Formatando as datas - Data de Vencimento */
    let DiaVencimento = TituloDataVencimento.getDate() + 1;
    let MesVencimento = TituloDataVencimento.getMonth() + 1;
    let AnoVencimento = TituloDataVencimento.getFullYear();
    let TituloDataVencimentoFormatado = DiaVencimento + '/' + MesVencimento + '/' + AnoVencimento;

    // Requisição na API TecnoSpeed (plugboleto) para incluir boleto
    // Requisição feita via fetch
    fetch(`https://homologacao.plugboleto.com.br/api/v1/boletos/lote`, {

        method: 'POST',

        // Header de usuário de testes da tecnoSpeed
        headers: {
            'Content-Type': 'application/json',
            'cnpj-sh': '01001001000113',
            'token-sh': 'f22b97c0c9a3d41ac0a3875aba69e5aa',
            'cnpj-cedente': '01001001000113'
        },

        // Enviando os dados digitados no formulário
        body: JSON.stringify([{

            /* CEDENTE */
            'CedenteContaNumero': `${CedenteContaNumero}`,
            'CedenteContaNumeroDV': `${CedenteContaNumeroDV}`,
            'CedenteConvenioNumero': `${CedenteConvenioNumero}`,
            'CedenteContaCodigoBanco': `${CedenteContaCodigoBanco}`,

            /* SACADO */
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

            /* DOCUMENTO */
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

    // Solicitando impressão
    // Passamos o idintegração como parâmetro
    
    .then(data => {
        SolicitarImpressao(data._dados._sucesso[0].idintegracao);
    })


    .catch(error => console.log(error))
}

function SolicitarImpressao(idintegracao) {
    
    fetch(`https://homologacao.plugboleto.com.br/api/v1/boletos/impressao/lote`, {
    
        method: 'POST',
    
        headers: {
            'Content-Type': 'application/json',
            'cnpj-sh': '01001001000113',
            'token-sh': 'f22b97c0c9a3d41ac0a3875aba69e5aa',
            'cnpj-cedente': '01001001000113'
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

        // Chamamos a função que vai nos redirecionar 
        // Para uma tela com o boleto sendo exibido em pdf 

        Imprimir(data._dados.protocolo);

    })

    .catch(error => console.log(error))
}


// Esta função, através do parâmetro protocolo,
// nos redirecionará para uma nova janela, exibindo o .pdf
// do respectivo boleto.

function Imprimir(protocolo) {
    
    window.open(`https://homologacao.plugboleto.com.br/api/v1/boletos/impressao/lote/${protocolo}`,"_blank")

}