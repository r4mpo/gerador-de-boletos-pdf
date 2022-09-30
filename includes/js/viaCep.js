/* Para uma melhor experiência do usuário, utilizamos o ViaCep.
Dessa forma, quando o usuário completa o preenchimento do cep, os outros
campos relacionados ao endereço são preenchidos automaticamente. */

function AutoCompletar() {
    let SacadoEnderecoCEP = document.getElementById('SacadoEnderecoCEP').value;
    if(SacadoEnderecoCEP.length == 8){
        ReceberDadosDoEndereco(SacadoEnderecoCEP)
    }
}

const ReceberDadosDoEndereco = async (cep) => {
    let SacadoEnderecoCidade = document.getElementById('SacadoEnderecoCidade');
    let SacadoEnderecoBairro = document.getElementById('SacadoEnderecoBairro');
    let SacadoEnderecoLogradouro = document.getElementById('SacadoEnderecoLogradouro');
    let SacadoEnderecoPais = document.getElementById('SacadoEnderecoPais');
    let SacadoEnderecoUF = document.getElementById('SacadoEnderecoUF');
    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
    const informacoes = await response.json();
    SacadoEnderecoCidade.value = informacoes.localidade;
    SacadoEnderecoBairro.value = informacoes.bairro;
    SacadoEnderecoLogradouro.value = informacoes.logradouro;
    SacadoEnderecoPais.value = 'Brasil';
    SacadoEnderecoUF.value = informacoes.uf;
}