<?php

if ( ! defined ( 'ABSPATH' ) && ! defined ( 'WP_UNINSTALL_PLUGIN' )) {
    exit;
}

if ( ! function_exists ( 'gerador_de_boletos_pdf_uninstall' ) ) {

    function gerador_de_boletos_pdf_uninstall () {

        delete_option( 'gdb_pdf_dados' );
    }

}

register_uninstall_hook( __FILE__ , 'gerador_de_boletos_pdf_uninstall' );