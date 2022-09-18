<?php

/**
 * Desinstalando o plugin :( 
 * (...)
*/ 

if ( ! defined('ABSPATH') && ! defined ( 'WP_UNINSTALL_PLUGIN')) {
    exit;
}

register_uninstall_hook(__FILE__, 'gerador_de_boletos_pdf___uninstall');

?>