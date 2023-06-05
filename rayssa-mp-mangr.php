<?php

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class RayssaMailPdf{

    private $html2pdf;
    private $data;
    private $contact;
    private $artifacts;

    private $pdf_generated_file_path;
    private $pdf_html_tpl_src;

    function __construct()
    {

        $this->html2pdf = new Html2Pdf('P','LETTER','es');

        add_action('rayssa_pdf_exercise_item', [$this,'pdf_item_lt_and_fv']);
    
    }

    private function pdf_download_path(){
        $pdp = WP_CONTENT_DIR . '/rayssa/downloads/';
        $pdp = apply_filters('rayssa_pdf_download_path',$pdp);
        $this->verify_pdf_download_path( $pdp );
        return $pdp;
    } 

    private function verify_pdf_download_path( $path, $create = true ){
        if( is_writable( $path ) ){
            return true;
        } else {
            if( $create ){
                if( is_dir($path) || (mkdir($path, 0774, true) && is_dir($path)) ){
                    return true;
                }
            } else {
                if( is_dir($path) ){
                    return true;
                }
            }
        }

        return false;
    }

    private function get_fields_map_for_header(){
        $f2r = [
            '{nombresApellidos}' => 'names',
            '{email}'            => 'email',
            '{telefono}'         => 'phone',
            '{financiamiento}'   => 'finantial'
        ];

        $f2r = apply_filters('rayssa_fields_maps_for_header',$f2r);
    
        return $f2r;
    }

    private function get_fields_map_for_items(){
        $f2r = [
            '{nombreArtefacto}' => 'name',
            '{cantidad}'        => 'qty',
            '{potencia}'        => 'duh'
        ];

        $f2r = apply_filters('rayssa_fields_maps_for_items',$f2r);
    
        return $f2r;
    }

    private function get_fields_map_for_results(){
        $f2r = [
            '{nombreArtefacto}' => 'name',
            '{cantidad}'        => 'qty',
            '{potencia}'        => 'duh'
        ];

        $f2r = apply_filters('rayssa_fields_maps_for_results',$f2r);
    
        return $f2r;
    }

    private function pdf_fetch_values(){
        $flds_map = $this->get_fields_map_for_header();

        foreach( $flds_map as $ktr => $dak ){
            $this->pdf_html_tpl_src = str_replace( $ktr, $this->contact[ $dak ], $this->pdf_html_tpl_src);
        }

        $flds_map = $this->get_fields_map_for_results();

        foreach( $flds_map as $ktr => $dak ){
            $this->pdf_html_tpl_src = str_replace( $ktr, $this->contact[ $dak ], $this->pdf_html_tpl_src);
        }
    }

    private function pdf_generate(){

        $path_prefix = $this->pdf_download_path();

        $this->pdf_generated_file_path = wp_unique_id( $path_prefix . date( 'YmdHis-' ) ) . '.pdf';

        $this->pdf_load_template();

        if( !empty( $this->pdf_html_tpl_src ) ){

            $this->pdf_fetch_values();

            $this->html2pdf->writeHTML( $this->pdf_html_tpl_src );

            $this->html2pdf->output( $this->pdf_generated_file_path, 'F' );
        }
    }

    private function pdf_load_template(){

        $tplp = 'rayssa/pdfs/cofg-exercise.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/pdfs/cofg-exercise.php';
        }

        ob_start();
        load_template($template,false,['artifacts'=>$this->artifacts]);
        $this->pdf_html_tpl_src = ob_get_clean();

    }

    public function pdf_item_lt_and_fv($args){
        $template = locate_template('rayssa/pdfs/cofg-items.php');

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/pdfs/cofg-items.php';
        }
            
        load_template($template,false,$args);
    }

    private function email_header(){

    }

    private function email_body(){

    }

    private function try_send_mails(){
        //$mail_sent_res = wp_mail($email,$subject,$content,$header,[$pp]);
    }

    public function process_request( $data ){
        /* faltan validaciones del lado del 
           server. */
        $this->data = $data;
        $this->contact = $data['contact'];
        $this->artifacts = $data['artifacts'];
        
        $this->pdf_generate();

        $esr = $this->try_send_mails();

        return $esr;
    }


}