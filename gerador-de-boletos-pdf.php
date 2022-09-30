<?php

/**
 
 * Plugin Name: GERADOR DE BOLETOS PDF
 * Plugin URI: https://github.com/r4mpo/gerador-de-boletos-pdf
 * Description: Este plugin foi desenvolvido com o intuito de gerar arquivos (.pdf) de boletos e, para tal finalidade, utiliza-se a API Plugboleto - com o suporte técnico da Tecnospeed.
 * Version: 1.0.0
 * Author: Erick Agostinho (@r4mpo)
 * Author URI: https://github.com/r4mpo

**/

if( ! defined ( 'WPINC' ) ) {
    wp_die();
}

if( ! defined ( 'GERADOR_DE_BOLETOS_PDF_VERSION' ) ) {
    define( 'GERADOR_DE_BOLETOS_PDF_VERSION', '1.0.0' );
}

if( ! defined ( 'GERADOR_DE_BOLETOS_PDF_NAME' ) ) {
    define( 'GERADOR_DE_BOLETOS_PDF_NAME', 'GERADOR DE BOLETOS PDF' );
}

if( ! defined ( 'GERADOR_DE_BOLETOS_PDF_PLUGIN_SLUG' ) ) {
    define( 'GERADOR_DE_BOLETOS_PDF_PLUGIN_SLUG', 'gerador-de-boletos-pdf' );
}

if( ! defined ( 'GERADOR_DE_BOLETOS_PDF_BASE_NAME' ) ) {
    define( 'GERADOR_DE_BOLETOS_PDF_BASE_NAME', plugin_basename( __FILE__ ) );
}

if( ! defined ( 'GERADOR_DE_BOLETOS_PDF_PLUGIN_DIR' ) ) {
    define( 'GERADOR_DE_BOLETOS_PDF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}


if( is_admin() )

    add_action( 'after_setup_theme', function()
    {
        require_once GERADOR_DE_BOLETOS_PDF_PLUGIN_DIR . 'includes/class-gerador-de-boletos-pdf-admin.php';

        $gerador_de_boletos_pdf_admin = new gerador_de_boletos_pdf_admin(
            GERADOR_DE_BOLETOS_PDF_BASE_NAME, 
            GERADOR_DE_BOLETOS_PDF_PLUGIN_SLUG, 
            GERADOR_DE_BOLETOS_PDF_VERSION
        );

    }, 5 );
?>