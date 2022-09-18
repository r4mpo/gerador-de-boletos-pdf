<?php

/**
 * Plugin Name: Gerador de Boletos .pdf
 * Plugin URI: https://github.com/r4mpo/gerador-de-boletos-pdf
 * Description: Plugin desenvolvido para WordPress com a finalidade de fornecer um shortcode que, ao ser utilizado, habilita um formulário que gera boletos dinâmicos através dos dados informados.
 * Version: 1.0
 * Author: Erick (@r4mpo)
 * Author URI: https://github.com/r4mpo
**/

// Criando função que exibe o shortcode
function exibirFormulario() {
    include_once('public/formulario.php');
}

// Exibindo o shortcode
add_shortcode('exibirFormulario', 'exibirFormulario');

?>