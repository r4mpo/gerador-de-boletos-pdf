// Função acionada pelo formulário
function AutoCompletar() {
            
    // CEP - Passaremos este valor para a API ViaCep
    let SacadoEnderecoCEP = document.getElementById('SacadoEnderecoCEP').value;

    // Chamando a função quando o usuário digitar 8 dígitos
    if(SacadoEnderecoCEP.length == 8){
        ReceberDadosDoEndereco(SacadoEnderecoCEP)
    }

}

// Função que receberá os dados de endereço
const ReceberDadosDoEndereco = async (cep) => {

    // Campos que vamos auto-completar
    let SacadoEnderecoCidade = document.getElementById('SacadoEnderecoCidade');
    let SacadoEnderecoBairro = document.getElementById('SacadoEnderecoBairro');
    let SacadoEnderecoLogradouro = document.getElementById('SacadoEnderecoLogradouro');
    let SacadoEnderecoPais = document.getElementById('SacadoEnderecoPais');
    let SacadoEnderecoUF = document.getElementById('SacadoEnderecoUF');

    // Consulta na API
    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
    const informacoes = await response.json();

    // Auto-Completando o Endereço
    SacadoEnderecoCidade.value = informacoes.localidade;
    SacadoEnderecoBairro.value = informacoes.bairro;
    SacadoEnderecoLogradouro.value = informacoes.logradouro;
    SacadoEnderecoPais.value = 'Brasil';
    SacadoEnderecoUF.value = informacoes.uf;

}