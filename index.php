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
define('RAYSSA_TPL_SLG_CALC_ONGRID','on-grid');
define('RAYSSA_TPL_SLG_CALC_PRCD_RES_OK','procd-result-ok');
define('RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL','procd-result-fail');

require_once __DIR__.'/rayssa-ssn-mngr.php';

add_filter('script_loader_tag', 'rayssa_add_type_attribute' , 10, 3);
add_action('init','RayssaExcerciseSsnMangr::prepare_session');
function rayssa_add_type_attribute($tag, $hnd, $src) {
    
    if ( 'rayssa-calc-offgrid' !== $hnd ) {
        return $tag;
    }

    $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    return $tag;
}

function rayssa_get_demo_artifacts(){
    $demoArtfcs = [
        [
            'id'    => 'tv',
            'name'  => 'TV',
            'qty'   => 1,
            'power' => 80,
            'duh'   => 6
        ],
        [
            'id'    => 'lavadora',
            'name'  => 'Lavadora',
            'qty'   => 1,
            'power' => 400,
            'duh'   => 2
        ],
        [
            'id'    => 'computador',
            'name'  => 'Computador',
            'qty'   => 1,
            'power' => 150,
            'duh'   => 2
        ],
        [
            'id'    => 'refrigerador',
            'name'  => 'Refrigerador',
            'qty'   => 1,
            'power' => 24.67,
            'duh'   => 24
        ],
        [
            'id'    => 'iluminacion',
            'name'  => 'Iluminacion',
            'qty'   => 10,
            'power' => 9,
            'duh'   => 6
        ],
        [
            'id'    => 'bomba-agua',
            'name'  => 'BNomba de agua',
            'qty'   => 1,
            'power' => 700,
            'duh'   => 1
        ],
        [
            'id'    => 'cargador-celular',
            'name'  => 'Cargador de celular',
            'qty'   => 3,
            'power' => 20,
            'duh'   => 5
        ],
        [
            'id'    => 'estufa-a-pellet',
            'name'  => 'Estufa a pellet',
            'qty'   => 1,
            'power' => 40,
            'duh'   => 6
        ],
        [
            'id'    => 'juguera',
            'name'  => 'Juguera',
            'qty'   => 1,
            'power' => 60,
            'duh'   => 1
        ],
        [
            'id'    => 'aspiradora',
            'name'  => 'Aspiradora',
            'qty'   => 1,
            'power' => 100,
            'duh'   => 1
        ]
    ];
    return apply_filters('rayssa_demo_artifacts',$demoArtfcs);
}

function rayssa_get_hsp_data(){
    $hsp = [
        [
            'id' => 1,
            'name' => 'Región de Arica y Parinacota',
            'value'   => 2.40
        ],
        [
            'id' => 2,
            'name' => 'Región de Tarapacá',
            'value'   => 2.67
        ],
        [
            'id' => 3,
            'name' => 'Región de Antofagasta',
            'value'   => 2.84
        ],
        [
            'id' => 4,
            'name' => 'Región de Atacama',
            'value'   => 2.70
        ],
        [
            'id' => 5,
            'name' => 'Región de Coquimbo',
            'value'   => 2.54
        ],
        [
            'id' => 6,
            'name' => 'Región de Valparaiso',
            'value'   => 2.41
        ],
        [
            'id' => 7,
            'name' => 'Región Metropolitana',
            'value'   => 2.42
        ],
        [
            'id' => 8,
            'name' => 'Región de O\'Higgins',
            'value'   => 2.18
        ],
        [
            'id' => 9,
            'name' => 'Región del Maule',
            'value'   => 2.31
        ],
        [
            'id' => 10,
            'name' => 'Región del Ñuble',
            'value'   => 2.23
        ],
        [
            'id' => 11,
            'name' => 'Región de Bío Bío',
            'value'   => 2.04
        ],
        [
            'id' => 12,
            'name' => 'Región de la Araucanía',
            'value'   => 1.88
        ],
        [
            'id' => 13,
            'name' => 'Región de los Ríos',
            'value'   => 1.72
        ],
        [
            'id' => 14,
            'name' => 'Región de los Lagos',
            'value'   => 1.56
        ],
        [
            'id' => 15,
            'name' => 'Región de Aysen',
            'value'   => 0.90
        ],
        [
            'id' => 16,
            'name' => 'Región de Magallanes',
            'value'   => 1.14
        ]
    ];

    return apply_filters('rayssa_hsp_regions',$hsp);
}

function rayssa_enqueue_scripts(){
   
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
        'rayssa-calc-offgrid-css', 
        plugin_dir_url(__FILE__) . 'assets/css/rayssa-calc-offgrid.css',
     );

    wp_enqueue_script(
        'ui-parser-offgrid-js',
        plugin_dir_url(__FILE__) . 'assets/js/ui-parser-offgrid.js',
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
        'rayssa-calc-offgrid-js',
        plugin_dir_url(__FILE__) . 'assets/js/rayssa-calc-offgrid.js',
        array('jquery', 'jquery-ui-sortable','rayssa-select2-js','ui-parser-offgrid-js','rayssa-jq-blockui-js'),
        '1.0.0',
        true
    );

    

    $artfcts_demo = rayssa_get_demo_artifacts();
    $atts = ['artfcts_demo' => $artfcts_demo];
    
    ob_start();
    rayssa_load_template('artifact-item',$atts);
    $artfct_item_tpl = ob_get_clean();

    $calc_config = [
        'autonomia'  => apply_filters('rayssa_calc_cfg_autonomia',2),
        'dod'        => apply_filters('rayssa_calc_cfg_dod',55/100),
        'eficiencia' => apply_filters('rayssa_calc_cfg_eficiancia',0.86)
    ];
    
    $prms = array(
        'rootSelector'      => '.rayssa-calc-offgrid',
        'exersizeURL'       => '',
        'artifactItemTpl'   => $artfct_item_tpl,
        'artfctsDemo'       => $artfcts_demo,
        'sndExcrsURL'       => rest_url('/'.JGB_RAYSSA_APIREST_BASE_ROUTE . JGB_RAYSSA_URI_ID_SEND_EMAIL_COFG . '/'),
        'calcConfig'        => $calc_config,
        'rayssaExcrcsSsnId' => $_SESSION['rayssa']['session']->get_session_id(),
        'cokNm_ExcrSsnId'   => RAYSSA_COK_NM_EXCR_SSN_ID,
        'sysSsnId'          => session_id()
    );

    wp_localize_script('rayssa-calc-offgrid-js','RAYSSA_CALC_OFFGRID',$prms);
}

function rayssa_load_template($tpl,$attrs=null){
    switch ($tpl) {
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
    
    rayssa_enqueue_scripts();

    $hsp_region   = rayssa_get_hsp_data();

    // Obtén los atributos del shortcode (si los hay)
    $atts = shortcode_atts(array(
        'title' => 'Mi Listado',
        'category' => 'todos',
        'id' => 'rayssa-calc-orffgrid-root',
        'hsp_region' => $hsp_region,
        'calc_type' => 'off-grid'
    ), $atts);

    switch( $sm->get_status() ){
        case RAYSSA_EXCRCS_STTTS_PROCD_OK:
            $tpl_nm = RAYSSA_TPL_SLG_CALC_PRCD_RES_OK;
            break;

        case RAYSSA_EXCRCS_STTTS_PROCD_FAIL:
            $tpl_nm = RAYSSA_TPL_SLG_CALC_PRCD_RES_FAIL;
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

    $dt = $r->get_json_params();
   
    require_once __DIR__ . '/rayssa-mp-mangr.php';
    session_id( $dt['sysSsnId'] );
    session_start();
    $rmm = new RayssaMailPdf( $_SESSION['rayssa']['session'] );

    $esr = $rmm->process_request($dt);

    $response = new WP_REST_Response( $esr );
    $response->set_status( 200 );

    return $response;
    
}