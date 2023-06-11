<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ofg_active = rayssa_get_calc_type() == 'offgrid' ? 'active' : '';
if( empty( $ofg_active ) ){
    
    if( isset( $_GET['calc_type'] ) ){
        $qv = [];
        foreach( $_GET as $k => $v ){
            $qv[$k] = $v;
        }
        $qv['calc_type'] = 'offgrid';
        $new_query_string = http_build_query( $qv );
    } else {
        $prms = array_merge( $_GET, ['calc_type' => 'offgrid']);
        $new_query_string = http_build_query( $prms );
    }
    $url  = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' );
    $url .= ( empty( $_SERVER['HTTP_HOST'] ) ? $defaultHost : $_SERVER['HTTP_HOST'] );
    $url .= '?' . $new_query_string;
    
    $ofg_a_open  = '<a ';
    $ofg_a_open .= "href=\"$url\">";
    $ofg_a_close = '</a>';
}

$ong_active = rayssa_get_calc_type() == 'ongrid' ? 'active' : '';
if( empty( $ong_active ) ){
    if( isset( $_GET['calc_type'] ) ){
        $qv = [];
        foreach( $_GET as $k => $v ){
            $qv[$k] = $v;
        }
        $qv['calc_type'] = 'ongrid';
        $new_query_string = http_build_query( $qv );
    } else {
        $prms = array_merge( $_GET, ['calc_type' => 'ongrid']);
        $new_query_string = http_build_query( $prms );
    }
    $url  = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' );
    $url .= ( empty( $_SERVER['HTTP_HOST'] ) ? $defaultHost : $_SERVER['HTTP_HOST'] );
    $url .= '?'. $new_query_string;
    
    $ong_a_open  = '<a ';
    $ong_a_open .= "href=\"$url\">";
    $ong_a_close = '</a>';
}
?>

<div class="calc-tabulator">
    <div class="selection-wrapper">
        <div class="item offgrid <?= $ofg_active ?>"><?= $ofg_a_open ?>Calculadora Off Grid<?= $ofg_a_close ?></div>
        <div class="item ongrid <?= $ong_active ?>"><?= $ong_a_open ?>Calculadora On Grid<?= $ong_a_close ?></div>
    </div>
</div>