<?php

// Incluindo arquivo JS - responsável por gerar e imprimir o boleto
// Incluindo arquivo JS - responsável por buscar os endereços no ViaCEP
// Incluindo arquivo JS - responsável por formatar campos com JavaScript

wp_enqueue_script('formulario-boleto-script', plugin_dir_url(__DIR__) . 'includes/js/tecnoSpeed.js', array( 'jquery' ), '', false);
wp_enqueue_script('formulario-cep-script', plugin_dir_url(__DIR__) . 'includes/js/viaCep.js', array( 'jquery' ), '', false);
wp_enqueue_script('formulario-format-script', plugin_dir_url(__DIR__) . 'includes/js/formatandoCampos.js', array( 'jquery' ), '', false);

// Verifica se a classe existe e, caso não exista, cria-a

if( !class_exists('gerador_de_boletos_pdf_admin') ) 
{
    // Iniciando a classe
    class gerador_de_boletos_pdf_admin {   

        private $options; // Opções
        private $plugin_basename; // Nome do Plugin
        private $version; // Versão
        private $plugin_slug; // Pasta/Diretório do plugin

        public function __construct($plugin_basename, $plugin_slug, $version) {

            $this->options          = get_option('gdb_pdf_dados'); // Retornando dados do banco
            $this->plugin_basename  = $plugin_basename;
            $this->plugin_slug      = $plugin_slug;
            $this->version          = $version;

            // Actions para ativar as funções desenvolvidas abaixo
            // Filter para criar URL de Configurações no plugin

            add_action( 'admin_menu', array ( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array ( $this, 'page_init' ) ); 
            add_filter( "plugin_action_links_" . $this->plugin_basename, array( $this, 'add_settings_link' ) );

        }

        public function add_plugin_page () {
            
            /* Definindo que o plugin terá uma opção "Configurações" em settings
            e um link anexado na própria barra do Wordpress. */

            add_options_page(
                'Settings',
                'GERADOR DE BOLETOS PDF',
                'manage_options',
                $this->plugin_slug,
                array( $this, 'create_admin_page' )
            );

        }

        /*
            Nesta seguinte função, informamos que o formulário será composto por 
            seções e que deve inserir os dados na tabela especificada.
        */

        public function create_admin_page() {
            ?>
            <!-- Formulário -->
            <div class="wrap">
                <h1>Configurações - Dados do Boleto</h1>
                <form action="options.php" method="post">
                    <?php
                        settings_fields('gdb_pdf_dados_options');
                        do_settings_sections('gdb_pdf_dados_admin');
                        submit_button();
                    ?>
                </form>
            </div>
            <?php
        }

        public function page_init () 
        {
            // Tabela no banco de dados
            register_setting (
                'gdb_pdf_dados_options',
                'gdb_pdf_dados',
                array ( $this, 'sanitize' )
            );

            // Criando a primeira seção - Headers
            add_settings_section (
                'setting_section_id_1',
                'Headers',
                null,
                'gdb_pdf_dados_admin'
            );

            // Campo - content-type
            add_settings_field (
                'content_type',
                'Content-Type',
                array ( $this, 'content_type_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_1',
            );

            // Campo - cnpj-sh
            add_settings_field (
                'cnpj_sh',
                'CNPJ da Software House',
                array( $this, 'cnpj_sh_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_1',
            );

            // Campo - token-sh
            add_settings_field (
                'token_sh',
                'Token da Software House',
                array( $this, 'token_sh_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_1',
            );

            // Campo - cnpj-cedente
            add_settings_field (
                'cnpj_cedente',
                'CNPJ do Cedente',
                array( $this, 'cnpj_cedente_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_1',
            );

            // Criando a segunda seção - Cedente
            add_settings_section (
                'setting_section_id_2',
                'Cedente',
                null,
                'gdb_pdf_dados_admin'
            );

            // Campo - CedenteContaNumero
            add_settings_field (
                'CedenteContaNumero',
                'Nº da Conta',
                array( $this, 'CedenteContaNumero_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_2',
            );

            // Campo - CedenteContaNumeroDV
            add_settings_field (
                'CedenteContaNumeroDV',
                'DV da Conta',
                array( $this, 'CedenteContaNumeroDV_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_2',
            );

            // Campo - CedenteConvenioNumero
            add_settings_field (
                'CedenteConvenioNumero',
                'Nº do Convênio',
                array( $this, 'CedenteConvenioNumero_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_2',
            );

            // Campo - CedenteContaCodigoBanco
            add_settings_field (
                'CedenteContaCodigoBanco',
                'Código da Conta Bancária',
                array( $this, 'CedenteContaCodigoBanco_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_2',
            );

            // Criando a terceira seção - Sacado
            add_settings_section (
                'setting_section_id_3',
                'Sacado',
                null,
                'gdb_pdf_dados_admin'
            );

            // Campo - SacadoNome
            add_settings_field (
                'SacadoNome',
                'Nome',
                array( $this, 'SacadoNome_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );

            // Campo - SacadoTelefone
            add_settings_field (
                'SacadoTelefone',
                'Telefone',
                array( $this, 'SacadoTelefone_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );

            // Campo - SacadoCelular
            add_settings_field (
                'SacadoCelular',
                'Celular',
                array( $this, 'SacadoCelular_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );

            // Campo - SacadoEmail
            add_settings_field (
                'SacadoEmail',
                'E-mail',
                array( $this, 'SacadoEmail_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );
            
            // Campo - SacadoCPFCNPJ
            add_settings_field (
                'SacadoCPFCNPJ',
                'CPF ou CNPJ',
                array( $this, 'SacadoCPFCNPJ_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );

            // Campo - SacadoEnderecoCEP
            add_settings_field (
                'SacadoEnderecoCEP',
                'CEP',
                array( $this, 'SacadoEnderecoCEP_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );

            // Campo - SacadoEnderecoNumero
            add_settings_field (
                'SacadoEnderecoNumero',
                'Nº Residencial',
                array( $this, 'SacadoEnderecoNumero_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );

            // Campo - SacadoEnderecoComplemento
            add_settings_field (
                'SacadoEnderecoComplemento',
                'Complemento',
                array( $this, 'SacadoEnderecoComplemento_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );  

            // Campo - SacadoEnderecoCidade
            add_settings_field (
                'SacadoEnderecoCidade',
                'Cidade',
                array( $this, 'SacadoEnderecoCidade_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );           
            
            // Campo - SacadoEnderecoBairro
            add_settings_field (
                'SacadoEnderecoBairro',
                'Bairro',
                array( $this, 'SacadoEnderecoBairro_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );  

            // Campo - SacadoEnderecoLogradouro
            add_settings_field (
                'SacadoEnderecoLogradouro',
                'Logradouro',
                array( $this, 'SacadoEnderecoLogradouro_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );  

            // Campo - SacadoEnderecoPais
            add_settings_field (
                'SacadoEnderecoPais',
                'País',
                array( $this, 'SacadoEnderecoPais_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );  

            // Campo - SacadoEnderecoUF
            add_settings_field (
                'SacadoEnderecoUF',
                'UF',
                array( $this, 'SacadoEnderecoUF_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_3',
            );  

            // Criando a quarta seção - Dados da Documentação
            add_settings_section (
                'setting_section_id_4',
                'Documentação',
                null,
                'gdb_pdf_dados_admin'
            );

            // Campo - TituloDataEmissao
            add_settings_field (
                'TituloDataEmissao',
                'Data de Emissão',
                array( $this, 'TituloDataEmissao_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloDataVencimento
            add_settings_field (
                'TituloDataVencimento',
                'Data de Vencimento',
                array( $this, 'TituloDataVencimento_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloMensagem01
            add_settings_field (
                'TituloMensagem01',
                '1ª Mensagem',
                array( $this, 'TituloMensagem01_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloMensagem02
            add_settings_field (
                'TituloMensagem02',
                '2ª Mensagem',
                array( $this, 'TituloMensagem02_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloMensagem03
            add_settings_field (
                'TituloMensagem03',
                '3ª Mensagem',
                array( $this, 'TituloMensagem03_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloNossoNumero
            add_settings_field (
                'TituloNossoNumero',
                'Nosso Nº',
                array( $this, 'TituloNossoNumero_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloNumeroDocumento
            add_settings_field (
                'TituloNumeroDocumento',
                'Nº Documento',
                array( $this, 'TituloNumeroDocumento_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloValor
            add_settings_field (
                'TituloValor',
                'Valor (R$)',
                array( $this, 'TituloValor_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - TituloLocalPagamento
            add_settings_field (
                'TituloLocalPagamento',
                'Local de pagamento',
                array( $this, 'TituloLocalPagamento_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Campo - Botão Gerar Boleto
            add_settings_field (
                'GERAR BOLETO PDF',
                'GERAR BOLETO PDF',
                array( $this, 'gdb_pdf_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_4',
            );

            // Criando a quinta seção - Retorno da API
            add_settings_section (
                'setting_section_id_5',
                'Tecnospeed',
                null,
                'gdb_pdf_dados_admin'
            );

            // Campo - ID Integração
            add_settings_field (
                'idintegração',
                'ID Integração',
                array( $this, 'idintegracao_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_5',
            );

            // Campo - ID Integração
            add_settings_field (
                'protocolo',
                'Protocolo',
                array( $this, 'protocolo_callback' ),
                'gdb_pdf_dados_admin',
                'setting_section_id_5',
            );
        }

        /* Campos html para que o usuário preencha */

        // Input Text - Content-Type
        public function content_type_callback() {
            $value = isset( $this->options['content_type'] ) ? esc_attr( $this->options['content_type']  ) : 'application/json';
            ?>
            <input type="text" id="content_type" name="gdb_pdf_dados[content_type]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - cnpj-sh
        public function cnpj_sh_callback() {
            $value = isset( $this->options['cnpj_sh'] ) ? esc_attr( $this->options['cnpj_sh']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" maxlength="14" id="cnpj_sh" name="gdb_pdf_dados[cnpj_sh]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - token-sh
        public function token_sh_callback() {
            $value = isset( $this->options['token_sh'] ) ? esc_attr( $this->options['token_sh']  ) : '';
            ?>
            <input type="text" id="token_sh" name="gdb_pdf_dados[token_sh]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - cnpj-cedente
        public function cnpj_cedente_callback() {
            $value = isset( $this->options['cnpj_cedente'] ) ? esc_attr( $this->options['cnpj_cedente']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" maxlength="14" id="cnpj_cedente" name="gdb_pdf_dados[cnpj_cedente]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - CedenteContaNumero
        public function CedenteContaNumero_callback() {
            $value = isset( $this->options['CedenteContaNumero'] ) ? esc_attr( $this->options['CedenteContaNumero']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="CedenteContaNumero" name="gdb_pdf_dados[CedenteContaNumero]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - CedenteConvenioNumero
        public function CedenteConvenioNumero_callback() {
            $value = isset( $this->options['CedenteConvenioNumero'] ) ? esc_attr( $this->options['CedenteConvenioNumero']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="CedenteConvenioNumero" name="gdb_pdf_dados[CedenteConvenioNumero]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - CedenteContaNumeroDV
        public function CedenteContaNumeroDV_callback() {
            $value = isset( $this->options['CedenteContaNumeroDV'] ) ? esc_attr( $this->options['CedenteContaNumeroDV']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="CedenteContaNumeroDV" name="gdb_pdf_dados[CedenteContaNumeroDV]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - CedenteContaCodigoBanco
        public function CedenteContaCodigoBanco_callback() {
            $value = isset( $this->options['CedenteContaCodigoBanco'] ) ? esc_attr( $this->options['CedenteContaCodigoBanco']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="CedenteContaCodigoBanco" name="gdb_pdf_dados[CedenteContaCodigoBanco]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoNome
        public function SacadoNome_callback() {
            $value = isset( $this->options['SacadoNome'] ) ? esc_attr( $this->options['SacadoNome']  ) : '';
            ?>
            <input type="text" id="SacadoNome" name="gdb_pdf_dados[SacadoNome]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoTelefone
        public function SacadoTelefone_callback() {
            $value = isset( $this->options['SacadoTelefone'] ) ? esc_attr( $this->options['SacadoTelefone']  ) : '';
            ?>
            <input type="text" maxlength="10" onkeypress="return apenasNumeros();" id="SacadoTelefone" name="gdb_pdf_dados[SacadoTelefone]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoCelular
        public function SacadoCelular_callback() {
            $value = isset( $this->options['SacadoCelular'] ) ? esc_attr( $this->options['SacadoCelular']  ) : '';
            ?>
            <input type="text" maxlength="11" onkeypress="return apenasNumeros();" id="SacadoCelular" name="gdb_pdf_dados[SacadoCelular]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEmail
        public function SacadoEmail_callback() {
            $value = isset( $this->options['SacadoEmail'] ) ? esc_attr( $this->options['SacadoEmail']  ) : '';
            ?>
            <input type="text" id="SacadoEmail" name="gdb_pdf_dados[SacadoEmail]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoCPFCNPJ
        public function SacadoCPFCNPJ_callback() {
            $value = isset( $this->options['SacadoCPFCNPJ'] ) ? esc_attr( $this->options['SacadoCPFCNPJ']  ) : '';
            ?>
            <input type="text" maxlength="14" onkeypress="return apenasNumeros();" id="SacadoCPFCNPJ" name="gdb_pdf_dados[SacadoCPFCNPJ]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoCEP
        public function SacadoEnderecoCEP_callback() {
            $value = isset( $this->options['SacadoEnderecoCEP'] ) ? esc_attr( $this->options['SacadoEnderecoCEP']  ) : '';
            ?>
            <input type="text" onkeyup="AutoCompletar()" id="SacadoEnderecoCEP" name="gdb_pdf_dados[SacadoEnderecoCEP]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoNumero
        public function SacadoEnderecoNumero_callback() {
            $value = isset( $this->options['SacadoEnderecoNumero'] ) ? esc_attr( $this->options['SacadoEnderecoNumero']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="SacadoEnderecoNumero" name="gdb_pdf_dados[SacadoEnderecoNumero]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoComplemento
        public function SacadoEnderecoComplemento_callback() {
            $value = isset( $this->options['SacadoEnderecoComplemento'] ) ? esc_attr( $this->options['SacadoEnderecoComplemento']  ) : '';
            ?>
            <input type="text" id="SacadoEnderecoComplemento" name="gdb_pdf_dados[SacadoEnderecoComplemento]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoCidade
        public function SacadoEnderecoCidade_callback() {
            $value = isset( $this->options['SacadoEnderecoCidade'] ) ? esc_attr( $this->options['SacadoEnderecoCidade']  ) : '';
            ?>
            <input type="text" id="SacadoEnderecoCidade" name="gdb_pdf_dados[SacadoEnderecoCidade]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoBairro
        public function SacadoEnderecoBairro_callback() {
            $value = isset( $this->options['SacadoEnderecoBairro'] ) ? esc_attr( $this->options['SacadoEnderecoBairro']  ) : '';
            ?>
            <input type="text" id="SacadoEnderecoBairro" name="gdb_pdf_dados[SacadoEnderecoBairro]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoLogradouro
        public function SacadoEnderecoLogradouro_callback() {
            $value = isset( $this->options['SacadoEnderecoLogradouro'] ) ? esc_attr( $this->options['SacadoEnderecoLogradouro']  ) : '';
            ?>
            <input type="text" id="SacadoEnderecoLogradouro" name="gdb_pdf_dados[SacadoEnderecoLogradouro]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoPais
        public function SacadoEnderecoPais_callback() {
            $value = isset( $this->options['SacadoEnderecoPais'] ) ? esc_attr( $this->options['SacadoEnderecoPais']  ) : '';
            ?>
            <input type="text" id="SacadoEnderecoPais" name="gdb_pdf_dados[SacadoEnderecoPais]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - SacadoEnderecoUF
        public function SacadoEnderecoUF_callback() {
            $value = isset( $this->options['SacadoEnderecoUF'] ) ? esc_attr( $this->options['SacadoEnderecoUF']  ) : '';
            ?>
            <input type="text" id="SacadoEnderecoUF" name="gdb_pdf_dados[SacadoEnderecoUF]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloDataEmissao
        public function TituloDataEmissao_callback() {
            $value = isset( $this->options['TituloDataEmissao'] ) ? esc_attr( $this->options['TituloDataEmissao']  ) : '';
            ?>
            <input type="date" id="TituloDataEmissao" name="gdb_pdf_dados[TituloDataEmissao]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloDataVencimento
        public function TituloDataVencimento_callback() {
            $value = isset( $this->options['TituloDataVencimento'] ) ? esc_attr( $this->options['TituloDataVencimento']  ) : '';
            ?>
            <input type="date" id="TituloDataVencimento" name="gdb_pdf_dados[TituloDataVencimento]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloMensagem01
        public function TituloMensagem01_callback() {
            $value = isset( $this->options['TituloMensagem01'] ) ? esc_attr( $this->options['TituloMensagem01']  ) : '';
            ?>
            <input type="text" id="TituloMensagem01" name="gdb_pdf_dados[TituloMensagem01]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloMensagem02
        public function TituloMensagem02_callback() {
            $value = isset( $this->options['TituloMensagem02'] ) ? esc_attr( $this->options['TituloMensagem02']  ) : '//';
            ?>
            <input type="text" id="TituloMensagem02" name="gdb_pdf_dados[TituloMensagem02]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloMensagem03
        public function TituloMensagem03_callback() {
            $value = isset( $this->options['TituloMensagem03'] ) ? esc_attr( $this->options['TituloMensagem03']  ) : '//';
            ?>
            <input type="text" id="TituloMensagem03" name="gdb_pdf_dados[TituloMensagem03]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloNumeroDocumento
        public function TituloNumeroDocumento_callback() {
            $value = isset( $this->options['TituloNumeroDocumento'] ) ? esc_attr( $this->options['TituloNumeroDocumento']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="TituloNumeroDocumento" name="gdb_pdf_dados[TituloNumeroDocumento]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloNossoNumero
        public function TituloNossoNumero_callback() {
            $value = isset( $this->options['TituloNossoNumero'] ) ? esc_attr( $this->options['TituloNossoNumero']  ) : '';
            ?>
            <input type="text" onkeypress="return apenasNumeros();" id="TituloNossoNumero" name="gdb_pdf_dados[TituloNossoNumero]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloValor
        public function TituloValor_callback() {
            $value = isset( $this->options['TituloValor'] ) ? esc_attr( $this->options['TituloValor']  ) : '';
            ?>
            <input type="text" onkeyup="formatarMoeda()" id="TituloValor" name="gdb_pdf_dados[TituloValor]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - TituloLocalPagamento
        public function TituloLocalPagamento_callback() {
            $value = isset( $this->options['TituloLocalPagamento'] ) ? esc_attr( $this->options['TituloLocalPagamento']  ) : 'Pagável em qualquer banco até o vencimento';
            ?>
            <input type="text" id="TituloLocalPagamento" name="gdb_pdf_dados[TituloLocalPagamento]" value="<?php echo $value; ?>" />
            <?php
        }

        public function gdb_pdf_callback() {
            ?>
            <button type="button" 
            style="background-color: darkred; color: #fff; border-radius: 5px; cursor: pointer; border: 1px solid #fff" 
            id="gerar-boleto-pdf" onclick="verificarProtocolo()">GERAR BOLETO PDF</button>
            <?php
        }

        // Input Text - idintegracao
        public function idintegracao_callback() {
            $value = isset( $this->options['idintegracao'] ) ? esc_attr( $this->options['idintegracao']  ) : '';
            ?>
            <input type="text" id="idintegracao" name="gdb_pdf_dados[idintegracao]" value="<?php echo $value; ?>" />
            <?php
        }

        // Input Text - protocolo
        public function protocolo_callback() {
            $value = isset( $this->options['protocolo'] ) ? esc_attr( $this->options['protocolo']  ) : '';
            ?>
            <input type="text" id="protocolo" name="gdb_pdf_dados[protocolo]" value="<?php echo $value; ?>" />
            <?php
        }

        
        // Função para filtrar campos do html
        public function sanitize ( $input ) {

            $new_input = array();

            /* Headers */
    
            if( isset ( $input['content_type'] ) )
            $new_input['content_type'] = sanitize_text_field( $input['content_type'] );
    
            if( isset ( $input['cnpj_sh'] ) )
                $new_input['cnpj_sh'] = sanitize_text_field( $input['cnpj_sh'] );
    
            if( isset ( $input['token_sh'] ) )
            $new_input['token_sh'] = sanitize_text_field( $input['token_sh'] );
    
            if( isset ( $input['cnpj_cedente'] ) )
            $new_input['cnpj_cedente'] = sanitize_text_field( $input['cnpj_cedente'] );

            /* Body */
            if( isset ( $input['CedenteContaNumero'] ) )
            $new_input['CedenteContaNumero'] = sanitize_text_field( $input['CedenteContaNumero'] );

            if( isset ( $input['CedenteContaNumeroDV'] ) )
            $new_input['CedenteContaNumeroDV'] = sanitize_text_field( $input['CedenteContaNumeroDV'] );

            if( isset ( $input['CedenteConvenioNumero'] ) )
            $new_input['CedenteConvenioNumero'] = sanitize_text_field( $input['CedenteConvenioNumero'] );

            if( isset ( $input['CedenteContaCodigoBanco'] ) )
            $new_input['CedenteContaCodigoBanco'] = sanitize_text_field( $input['CedenteContaCodigoBanco'] );

            if( isset ( $input['SacadoCPFCNPJ'] ) )
            $new_input['SacadoCPFCNPJ'] = sanitize_text_field( $input['SacadoCPFCNPJ'] );

            if( isset ( $input['SacadoEmail'] ) )
            $new_input['SacadoEmail'] = sanitize_text_field( $input['SacadoEmail'] );

            if( isset ( $input['SacadoEnderecoNumero'] ) )
            $new_input['SacadoEnderecoNumero'] = sanitize_text_field( $input['SacadoEnderecoNumero'] );

            if( isset ( $input['SacadoEnderecoBairro'] ) )
            $new_input['SacadoEnderecoBairro'] = sanitize_text_field( $input['SacadoEnderecoBairro'] );

            if( isset ( $input['SacadoEnderecoCEP'] ) )
            $new_input['SacadoEnderecoCEP'] = sanitize_text_field( $input['SacadoEnderecoCEP'] );

            if( isset ( $input['SacadoEnderecoCidade'] ) )
            $new_input['SacadoEnderecoCidade'] = sanitize_text_field( $input['SacadoEnderecoCidade'] );

            if( isset ( $input['SacadoEnderecoComplemento'] ) )
            $new_input['SacadoEnderecoComplemento'] = sanitize_text_field( $input['SacadoEnderecoComplemento'] );

            if( isset ( $input['SacadoEnderecoLogradouro'] ) )
            $new_input['SacadoEnderecoLogradouro'] = sanitize_text_field( $input['SacadoEnderecoLogradouro'] );

            if( isset ( $input['SacadoEnderecoPais'] ) )
            $new_input['SacadoEnderecoPais'] = sanitize_text_field( $input['SacadoEnderecoPais'] );

            if( isset ( $input['SacadoEnderecoUF'] ) )
            $new_input['SacadoEnderecoUF'] = sanitize_text_field( $input['SacadoEnderecoUF'] );

            if( isset ( $input['SacadoNome'] ) )
            $new_input['SacadoNome'] = sanitize_text_field( $input['SacadoNome'] );

            if( isset ( $input['SacadoTelefone'] ) )
            $new_input['SacadoTelefone'] = sanitize_text_field( $input['SacadoTelefone'] );

            if( isset ( $input['SacadoCelular'] ) )
            $new_input['SacadoCelular'] = sanitize_text_field( $input['SacadoCelular'] );

            if( isset ( $input['TituloDataEmissao'] ) )
            $new_input['TituloDataEmissao'] = sanitize_text_field( $input['TituloDataEmissao'] );

            if( isset ( $input['TituloDataVencimento'] ) )
            $new_input['TituloDataVencimento'] = sanitize_text_field( $input['TituloDataVencimento'] );

            if( isset ( $input['TituloMensagem01'] ) )
            $new_input['TituloMensagem01'] = sanitize_text_field( $input['TituloMensagem01'] );

            if( isset ( $input['TituloMensagem02'] ) )
            $new_input['TituloMensagem02'] = sanitize_text_field( $input['TituloMensagem02'] );

            if( isset ( $input['TituloMensagem03'] ) )
            $new_input['TituloMensagem03'] = sanitize_text_field( $input['TituloMensagem03'] );

            if( isset ( $input['TituloNossoNumero'] ) )
            $new_input['TituloNossoNumero'] = sanitize_text_field( $input['TituloNossoNumero'] );

            if( isset ( $input['TituloNumeroDocumento'] ) )
            $new_input['TituloNumeroDocumento'] = sanitize_text_field( $input['TituloNumeroDocumento'] );

            if( isset ( $input['TituloValor'] ) )
            $new_input['TituloValor'] = sanitize_text_field( $input['TituloValor'] );

            if( isset ( $input['TituloLocalPagamento'] ) )
            $new_input['TituloLocalPagamento'] = sanitize_text_field( $input['TituloLocalPagamento'] );

            if( isset ( $input['idintegracao'] ) )
            $new_input['idintegracao'] = sanitize_text_field( $input['idintegracao'] );

            if( isset ( $input['protocolo'] ) )
            $new_input['protocolo'] = sanitize_text_field( $input['protocolo'] );

            return $new_input;
        }

        // Adicionando links
        public function add_settings_link ( $links ) {
            $settings_links = '<a href="options-general.php?page=' . $this->plugin_slug . '">' . 'Configurações' . '</a>';
            array_unshift ( $links, $settings_links );
            return $links;
        }
    }
}
?>