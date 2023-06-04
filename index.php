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

add_filter('script_loader_tag', 'rayssa_add_type_attribute' , 10, 3);
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
        'rayssa-calc-offgrid-js',
        plugin_dir_url(__FILE__) . 'assets/js/rayssa-calc-offgrid.js',
        array('jquery', 'jquery-ui-sortable','rayssa-select2-js','ui-parser-offgrid-js'),
        '1.0.0',
        true
    );

    

    $artfcts_demo = rayssa_get_demo_artifacts();
    $atts = ['artfcts_demo' => $artfcts_demo];
    
    ob_start();
    rayssa_load_template('artifact-item',$atts);
    $artfct_item_tpl = ob_get_clean();
    
    $prms = array(
        'rootSelector'      => '.rayssa-calc-offgrid',
        'exersizeURL'       => '',
        'artifactItemTpl'   => $artfct_item_tpl,
        'artfctsDemo'       => $artfcts_demo,
        'sndExcrsURL'       => rest_url('/'.JGB_RAYSSA_APIREST_BASE_ROUTE . JGB_RAYSSA_URI_ID_SEND_EMAIL_COFG . '/')
    );

    wp_localize_script('rayssa-calc-offgrid-js','RAYSSA_CALC_OFFGRID',$prms);
}

function rayssa_load_template($tpl,$attrs=null){
    switch ($tpl) {
        case 'artifact-item':
            $template = locate_template( 'calc-offgrid-artifact-item' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/calc-offgrid-artifact-item.php';
            }
            break;
        case 'on-grid':
            # on-grid
            $template = locate_template( 'calc-ongrid-base' );
            if ( empty( $template ) ) {
                // Template not found in theme's folder, use plugin's template as a fallback
                $template = dirname( __FILE__ ) . '/templates/calc-ongrid-base.php';
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
    rayssa_enqueue_scripts();
    $hsp_region   = rayssa_get_hsp_data();
    ob_start();

    // Obtén los atributos del shortcode (si los hay)
    $atts = shortcode_atts(array(
        'title' => 'Mi Listado',
        'category' => 'todos',
        'id' => 'rayssa-calc-orffgrid-root',
        'hsp_region' => $hsp_region
    ), $atts);

    rayssa_load_template('off-grid',$atts);

    // Devuelve el contenido generado por el componente de ReactJS
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
    $email = $dt['contact']['email'];
    $content = '';
    $subject = 'Ejercicio de calculadora offgrid';
    $header = array('Content-Type: text/html; charset=UTF-8');
    foreach($dt['artifacts'] as $art){
        $content .= 'Artefacto: ' . $art['name'] . '<br>';
        $content .= 'Cantidad: ' . $art['qty'] . '<br>';
        $content .= 'Potencia: ' . $art['pwr'] . '<br>';
        $content .= 'Tiempo de uso diario: ' . $art['duh'] . '<br>';

        $content .= '<br><br>';
    }
    $mail_sent_res = wp_mail($email,$subject,$content,$header);
}