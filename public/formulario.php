<?php

    wp_enqueue_style('formulario-boleto-style', plugin_dir_url(__DIR__) . 'public/css/style.css');
    wp_enqueue_script('formulario-boleto-script', plugin_dir_url(__DIR__) . 'public/js/viaCep.js', array( 'jquery' ), '', false);
    wp_enqueue_script('formulario-boleto-script-2', plugin_dir_url(__DIR__) . 'public/js/tecnoSpeed.js', array( 'jquery' ), '', false);

    include('includes/header.php');
    
    include('itens-do-formulario/cedente.php');
    include('itens-do-formulario/sacado.php');
    include('itens-do-formulario/documento.php');
    include('itens-do-formulario/gerarBoleto.php');

    include('includes/footer.php');

?>