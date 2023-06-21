<?php
/*
Plugin Name: Calculadora Watts Rayssa
Plugin URI: https://empdigital.cl
Description: Permite mostrar una calculadora de Off Grd y una On Grid
Version: 1.0
Author: Jorge Garrido / Emp Digital
Author URI: https://empdigital.cl
License: GPL2
*/

define('JGB_RAYSSA_APIREST_BASE_ROUTE','rayssa/');
define('JGB_RAYSSA_URI_ID_SEND_EMAIL_COFG','snd-excr');
define('RAYSSA_TPL_SLG_CALC_OFFGRID','off-grid');
define('RAYSSA_TPL_SLG_CALC_OFG_ARTF_ITMS','artifact-item');
define('RAYSSA_TPL_SLG_CALC_ONGRID','ongrid');
define('RAYSSA_TPL_SLG_CALC_PRCD_RES_OK','procd-result-ok');
define('RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL','procd-result-fail');
define('RAYSSA_TPL_SLG_PROCESSING_MSG','procsng-msg');
define('RAYSSA_TPL_SLG_CALC_TABULATOR','calculator-tab');

require_once __DIR__.'/rayssa-ssn-mngr.php';

require_once __DIR__ . '/include/function_helpers.php';

add_filter('script_loader_tag', 'rayssa_add_type_attribute' , 10, 3);
add_action('init','RayssaExcerciseSsnMangr::prepare_session');

add_action('rayssa_load_template_processing_template',function(){
    rayssa_load_template(RAYSSA_TPL_SLG_PROCESSING_MSG);
});

add_action('rayssa_load_template_calc_tab',function(){
    $args = ['calc_type' => rayssa_get_calc_type() ];
    rayssa_load_template(RAYSSA_TPL_SLG_CALC_TABULATOR,$args);
});

function rayssa_add_type_attribute($tag, $hnd, $src) {
    
    if ( 'rayssa-calc-off-grid' !== $hnd ) {
        return $tag;
    }

    $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    return $tag;
}



function rayssa_enqueue_scripts($ecsid){
   
    // Encola jQuery UI y su dependencia jQuery
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');

    wp_enqueue_style('rayssa-select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
	wp_enqueue_script('rayssa-select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery') );

    wp_enqueue_script(
        'rayssa-js-cookie',
        plugin_dir_url(__FILE__) . 'assets/js/node_modules/js-cookie/dist/js.cookie.min.js',
        '3.0.5',
        true
    );

    wp_enqueue_style(
        'rayssa-calc-css', 
        plugin_dir_url(__FILE__) . 'assets/css/rayssa-calc.css',
    );

    wp_enqueue_style(
        'rayssa-calc-result-procd-css', 
        plugin_dir_url(__FILE__) . 'assets/css/rayssa-calc-result-procd.css',
     );

    $ct = rayssa_get_calc_type();
    wp_enqueue_style(
        'rayssa-calc-'.$ct.'-css', 
        plugin_dir_url(__FILE__) . 'assets/css/rayssa-calc-'.$ct.'.css',
     );

    wp_enqueue_script(
        'ui-parser-'.$ct.'-js',
        plugin_dir_url(__FILE__) . 'assets/js/ui-parser-'.$ct.'.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'rayssa-jq-blockui-js',
        plugin_dir_url(__FILE__) . 'assets/js/jquery-blockui-2.70.0.js',
        array('jquery'),
        '2.70.0',
        true
    );

    wp_enqueue_script(
        'rayssa-calc-'.$ct.'-js',
        plugin_dir_url(__FILE__) . 'assets/js/rayssa-calc-'.$ct.'.js',
        array('jquery', 'jquery-ui-sortable','rayssa-select2-js','ui-parser-'.$ct.'-js','rayssa-jq-blockui-js'),
        '1.0.0',
        true
    );

    
    rayssa_localize_scripts( $ecsid, $ct );
    
}

function rayssa_localize_scripts( $ecsid, $calc_type ){
    $ct = $calc_type;

    if( $ct == 'offgrid'){
        $artfcts_demo = rayssa_get_demo_artifacts();
        $atts = ['artfcts_demo' => $artfcts_demo];
        
        ob_start();
        rayssa_load_template('artifact-item',$atts);
        $artfct_item_tpl = ob_get_clean();

        $calc_config = [
            'autonomia'  => apply_filters('rayssa_calc_cfg_autonomia',2),
            'dod'        => apply_filters('rayssa_calc_cfg_dod',60/100),
            'eficiencia' => apply_filters('rayssa_calc_cfg_eficiancia',0.86)
        ];
        
        $prms = array(
            'rootSelector'      => $ct == 'ongrid' ? '.rayssa-calc-ongrid' : '.rayssa-calc-offgrid',
            'artifactItemTpl'   => $artfct_item_tpl,
            'artfctsDemo'       => $artfcts_demo,
            'sndExcrsURL'       => rest_url('/'.JGB_RAYSSA_APIREST_BASE_ROUTE . JGB_RAYSSA_URI_ID_SEND_EMAIL_COFG . '/'),
            'calcConfig'        => $calc_config,
            'rayssaExcrcsSsnId' => $ecsid,
            'cokNm_ExcrSsnId'   => RAYSSA_COK_NM_EXCR_SSN_ID,
            'sysSsnId'          => session_id()
        );

    } else {

        $calc_config = [
            'valorkw'  => apply_filters('rayssa_calc_cfg_valor_kw',200)
        ];

        $prms = array(
            'rootSelector'      => $ct == 'ongrid' ? '.rayssa-calc-ongrid' : '.rayssa-calc-offgrid',
            'sndExcrsURL'       => rest_url('/'.JGB_RAYSSA_APIREST_BASE_ROUTE . JGB_RAYSSA_URI_ID_SEND_EMAIL_COFG . '/'),
            'calcConfig'        => $calc_config,
            'rayssaExcrcsSsnId' => $ecsid,
            'cokNm_ExcrSsnId'   => RAYSSA_COK_NM_EXCR_SSN_ID,
            'sysSsnId'          => session_id()
        );

    }

    $jsn_array_nm = 'RAYSSA_CALC_' . strtoupper( $ct );

    wp_localize_script('rayssa-calc-'.$ct.'-js',$jsn_array_nm,$prms);
}

function rayssa_load_template($tpl,$attrs=null){
    switch ($tpl) {
        case RAYSSA_TPL_SLG_CALC_TABULATOR:
            $template = locate_template( RAYSSA_TPL_SLG_CALC_TABULATOR.'.php' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/'.RAYSSA_TPL_SLG_CALC_TABULATOR.'.php';
            }
            break;

        case RAYSSA_TPL_SLG_PROCESSING_MSG:
            $template = locate_template( 'calc-'.RAYSSA_TPL_SLG_PROCESSING_MSG.'.php' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/calc-'.RAYSSA_TPL_SLG_PROCESSING_MSG.'.php';
            }
            break;

        case RAYSSA_TPL_SLG_CALC_OFG_ARTF_ITMS:
            $template = locate_template( 'calc-offgrid-'.RAYSSA_TPL_SLG_CALC_OFG_ARTF_ITMS.'.php' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/calc-offgrid-'.RAYSSA_TPL_SLG_CALC_OFG_ARTF_ITMS.'.php';
            }
            break;
        case RAYSSA_TPL_SLG_CALC_ONGRID:
            # on-grid
            $template = locate_template( 'calc-'.RAYSSA_TPL_SLG_CALC_ONGRID.'-base' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/calc-'.RAYSSA_TPL_SLG_CALC_ONGRID.'-base.php';
            }
            break;

        case RAYSSA_TPL_SLG_CALC_PRCD_RES_OK:
            # cálculo procesado ok
            $template = locate_template( RAYSSA_TPL_SLG_CALC_PRCD_RES_OK );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/'. RAYSSA_TPL_SLG_CALC_PRCD_RES_OK . '.php';
            }
            break;

        case RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL:
            # cálculo procesado fallido
            $template = locate_template( RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/'.RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL.'.php';
            }
            break;
        
        default:
            # off-grid
            $template = locate_template( 'calc-offgrid-base' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/calc-offgrid-base.php';
            }
            break;
    }

    if( file_exists( $template ) ){
        load_template( $template, true, $attrs );
    }
}

// Registra el shortcode para mostrar el listado
function rayssa_calc_offgrid_shortcode($atts) {
    $sm = new RayssaExcerciseSsnMangr;
    $ecsid = $sm->get_session_id();

    rayssa_enqueue_scripts($ecsid);

    $hsp_region   = rayssa_get_hsp_data();

    // Obtén los atributos del shortcode (si los hay)
    $atts = shortcode_atts(array(
        'title' => 'Mi Listado',
        'category' => 'todos',
        'id' => 'rayssa-calc-orffgrid-root',
        'hsp_region' => $hsp_region,
    ), $atts);

    $atts['calc_type'] = rayssa_get_calc_type();

    switch( $sm->get_status() ){
        case RAYSSA_EXCRCS_STTTS_PROCD_OK:
            $tpl_nm = RAYSSA_TPL_SLG_CALC_PRCD_RES_OK;
            $atts['download-url'] = $sm->get_pdf_download_url($ecsid);
            $sm->set_status_finalized( $ecsid );
            break;

        case RAYSSA_EXCRCS_STTTS_PROCD_FAIL:
            $tpl_nm = RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL;
            $atts['download-url'] = $sm->get_pdf_download_url($ecsid);
            $sm->set_status_finalized( $ecsid );
            break;

        default:
            $tpl_nm = $atts['calc_type'];
    }

    ob_start();

    rayssa_load_template($tpl_nm,$atts);

    return ob_get_clean();
}
add_shortcode('rayssa_calculator_offgrid', 'rayssa_calc_offgrid_shortcode');

add_action('rest_api_init',function(){
    register_rest_route(
        JGB_RAYSSA_APIREST_BASE_ROUTE,
        JGB_RAYSSA_URI_ID_SEND_EMAIL_COFG . '/',
        array(
            'methods'  => 'POST',
            'callback' => 'receive_send_exercise_request',
            'permission_callback' => '__return_true',
        )
    );
});

function receive_send_exercise_request(WP_REST_Request $r){
    try{
        // Log any exceptions to a WC logger
        $log = new WC_Logger();

        $dt = $r->get_json_params();
    
        $log_entry = print_r( 'Datos Json recibidos para procesar:', true );
        $log_entry.= print_r( $dt, true );
        $log->log( 'Rayssa', $log_entry );

        require_once __DIR__ . '/rayssa-mp-mangr.php';

        $log_entry = print_r( 'Cargado rayssa-mp-mangr.php', true );
        $log->log( 'Rayssa', $log_entry );

        session_id( $dt['sysSsnId'] );
        session_start();
        
        $rmm = new RayssaMailPdf( $_SESSION['rayssa']['session'] );

        $log_entry = print_r( 'Creado $rmm.', true );
        $log->log( 'Rayssa', $log_entry );


        $esr = $rmm->process_request($dt);
        $log_entry = print_r( 'Procesado $dt.', true );
        $log->log( 'Rayssa', $log_entry );

        $esr['status'] = 'ok';
    } catch( Exception $e ){
        $esr['status'] = 'error';

        $log_entry = print_r( $e, true );
        $log_entry .= 'Exception Trace: ' . print_r( $e->getTraceAsString(), true );
        $log->log( 'Rayssa', $log_entry );

        $err = [
            'msg' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ];

        $esr['error'] = $err;
    }
    $response = new WP_REST_Response( $esr );
    $response->set_status( 200 );

    return $response;
    
}

function rayssa_get_calc_type(){
    $ct = 'offgrid';
    if(isset($_GET['calc_type']) && $_GET['calc_type'] == 'ongrid'){
        $ct =  'ongrid';
    }

    return $ct;
}