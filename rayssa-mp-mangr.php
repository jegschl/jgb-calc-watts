<?php

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/rayssa-ssn-mngr.php';

use Spipu\Html2Pdf\Html2Pdf;
class RayssaMailPdf{

    private $html2pdf;
    private $data;
    private $contact;
    private $artifacts;
    private $cong_input;

    private $pdf_generated_file_path;
    private $pdf_generated_down_link;
    private $pdf_html_tpl_src;

    private $calc_type;

    private RayssaExcerciseSsnMangr $ssn_mngr;

    function __construct( RayssaExcerciseSsnMangr $esm )
    {

        $this->html2pdf = new Html2Pdf('P','LETTER','es');

        $this->ssn_mngr = $esm;

        add_action('rayssa_pdf_exercise_item', [$this,'pdf_item_lt_and_fv']);
        
       
    }

    private function pdf_download_path(){
        $pdp = WP_CONTENT_DIR . '/rayssa/downloads/';
        $pdp = apply_filters('rayssa_pdf_download_path',$pdp);
        $this->verify_pdf_download_path( $pdp );
        return $pdp;
    } 

    private function pdf_dowunload_url_prfx(){
        $pdu = WP_CONTENT_URL . '/rayssa/downloads/';
        $pdu = apply_filters('rayssa_pdf_download_url_prefix',$pdu);
        return $pdu;
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
            if( isset( $this->contact[ $dak ] ) ){
                $this->pdf_html_tpl_src = str_replace( $ktr, $this->contact[ $dak ], $this->pdf_html_tpl_src);
            }
        }
    }

    private function pdf_generate(){

        $path_prefix = $this->pdf_download_path();

        $url_prefix = $this->pdf_dowunload_url_prfx();

        $file_base_nm = uniqid( date( 'ymdHis-' ) ) . '.pdf';

        $this->pdf_generated_file_path = $path_prefix . $file_base_nm;

        $this->pdf_generated_down_link = $url_prefix . $file_base_nm;

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
        load_template($template,false,$this->data);
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
        $header = array('Content-Type: text/html; charset=UTF-8');
        $header = apply_filters('rayssa_email_header_cofg',$header);
        return $header;
    }

    private function email_subject(){
        $subject  = "Rayssa.cl :: Solicitud de cálculo ";
        $subject .= $this->calc_type == 'offgrid' ? 'Off Grid' : 'On Grid';
        $subject = apply_filters('rayssa_email_subject_'.$this->calc_type, $subject);
        return $subject;
    }

    private function get_email_content_header_logo_url(){
        $img_logo = 'http://rayssa.local/wp-content/uploads/2023/04/LogoRayssa.png';
        $img_logo = apply_filters('rayssa_email_content_header_logo_url',$img_logo);
        return $img_logo;
    }

    public function email_content_header(){
        $tplp = 'rayssa/emails/html-content-header.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-content-header.php';
        }

        $args = [
            'img-logo'=>$this->get_email_content_header_logo_url()
        ];

        ob_start();
        load_template($template,false,$args);
        echo ob_get_clean();
    }

    public function email_content_body(){
        $tplp = 'rayssa/emails/html-content-body.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-content-body.php';
        }

        $title = 'Cálculo ';
        $title.= $this->calc_type == 'offgrid' ? 'Off Grid' : 'On Grid';

        $args = [
            'content-title' => $title
        ];

        ob_start();
        load_template($template,false,$args);
        echo ob_get_clean();
    }

    public function email_content_footer(){
        $tplp = 'rayssa/emails/html-content-footer.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-content-footer.php';
        }

        ob_start();
        load_template($template,false);
        echo ob_get_clean();
    }

    public function email_content_data_contact(){
        $tplp = 'rayssa/emails/html-contact.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-contact.php';
        }

        ob_start();
        load_template($template,false,$this->contact);
        echo ob_get_clean();
    }

    public function email_content_data_artifacts_items(){
        $tplp = 'rayssa/emails/html-cofg-artifacts-itms.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-cofg-artifacts-itms.php';
        }

        ob_start();
        load_template($template,false,$this->artifacts);
        echo ob_get_clean();
    }

    public function email_content_data_cong_input(){
        $tplp = 'rayssa/emails/html-cong-input-dt.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-cong-input-dt.php';
        }

        ob_start();
        load_template($template,false,$this->cong_input);
        echo ob_get_clean();
    }

    public function email_content_data_calc_results(){
        $ctrbtn = $this->calc_type == 'offgrid' ? 'cofg' : 'cong';
        $tplp = 'rayssa/emails/html-'.$ctrbtn.'-calc-results.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-'.$ctrbtn.'-calc-results.php';
        }

        $cr = $this->data;
        unset( $cr['artifacts'] );
        unset( $cr['contact'] );

        ob_start();
        load_template($template,false,$cr);
        echo ob_get_clean();
    }

    private function get_email_content_for_requester(){
        $tplp = 'rayssa/emails/html-base.php';
        $template = locate_template( $tplp );

        if (empty( $template ) ) {
            $template =  __DIR__ . '/templates/emails/html-base.php';
        }

        $args = [
            'subject'=>$this->email_subject()
        ];

        ob_start();
        load_template($template,false,$args);
        return ob_get_clean();

    }

    private function set_emails_hooks(){
        add_action('rayssa_email_content_header', [$this,'email_content_header']);
        add_action('rayssa_email_content_body', [$this,'email_content_body']);
        add_action('rayssa_email_content_footer', [$this,'email_content_footer']);

        add_action('rayssa_mail_content_body_inner',[$this,'email_content_data_contact']);
        if( $this->calc_type == 'offgrid'){
            add_action('rayssa_mail_content_body_inner',[$this,'email_content_data_artifacts_items']);
        } else {
            add_Action('rayssa_mail_content_body_inner',[$this,'email_content_data_cong_input']);
        }
        add_action('rayssa_mail_content_body_inner',[$this,'email_content_data_calc_results']);
    }

    private function try_send_mails(){
        $header = $this->email_header();
        $subject = $this->email_subject();
        $email   = explode(',',$this->contact['email']);
        $email   = apply_filters('rayssa_email_recipents',$email);
        $pp      = $this->pdf_generated_file_path;

        $this->set_emails_hooks();

        $content = $this->get_email_content_for_requester();
        
        $mail_sent_res = wp_mail($email,$subject,$content,$header,[$pp]);
    
        return $mail_sent_res;
    }


    public function process_request( $data ){
        /* validaciones del lado del 
           server pendientes. */
        $this->data = $data;
        $this->calc_type = rayssa_get_calc_type();

        $this->contact = $data['contact'];
        
        if( $this->calc_type == 'offgrid' ){
            $this->artifacts = $data['artifacts'];
        } else {
            $this->cong_input = [
                'pwr'       => $data['pwr'],
                'qty'       => $data['qty'],
                'hsp'       => $data['hsp'],
                'region'    => $data['region'],
                'whbd'      => $data['whbd'],
                'kwhbd'     => $data['kwhbd'],
                'kwhbm'     => $data['kwhbm'],
                'discbm'    => $data['discbm'],
                'discby'    => $data['discby']
            ];
        }

        $esr = [];

        $this->pdf_generate();
        
        $esr['emailSentOk'] = $this->try_send_mails();
        $sid = $this->data['excerciseSsnId'];
        if($esr['emailSentOk']){
            $this->ssn_mngr->set_status_processed_ok($sid);
        } else {
            $this->ssn_mngr->set_status_processed_fail($sid);
        }
        
        $this->ssn_mngr->set_pdf_download_url( $sid, $this->pdf_generated_down_link );
        
        $esr['pdfDownloadLink'] = $this->pdf_generated_down_link;
        $esr['excerciseSsnId'] = $this->data['excerciseSsnId'];

        return $esr;
    }


}