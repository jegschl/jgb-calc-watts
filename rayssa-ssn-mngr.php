<?php

define('RAYSSA_EXCRCS_STTTS_STARTED',0);
define('RAYSSA_EXCRCS_STTTS_PROCD_OK',1);
define('RAYSSA_EXCRCS_STTTS_PROCD_FAIL',2);
define('RAYSSA_EXCRCS_STTTS_FINALIZED',3);
define('RAYSSA_COK_NM_EXCR_SSN_ID','rayssa_esi');

class RayssaExcerciseSsnMangr{

    private $ssn_excercise_id;

    function __construct($id = null)
    {
        if( is_null( $id ) ){
            if( isset( $_COOKIE[RAYSSA_COK_NM_EXCR_SSN_ID] ) ){
                $id = $_COOKIE[RAYSSA_COK_NM_EXCR_SSN_ID];
            }
        }
        $this->excercise_session_init($id);
    }

    public function get_session_id(){
        return $this->ssn_excercise_id;
    }

    public function set_status_finalized( $id ){
        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            $_SESSION['rayssa']['excercises'][ $id ]['status'] = RAYSSA_EXCRCS_STTTS_FINALIZED;
        }
    }

    public function set_status_processed_ok( $id ){
        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            $_SESSION['rayssa']['excercises'][ $id ]['status'] = RAYSSA_EXCRCS_STTTS_PROCD_OK;
        } 
    }

    public function set_status_processed_fail( $id ){
        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            $_SESSION['rayssa']['excercises'][ $id ]['status'] = RAYSSA_EXCRCS_STTTS_PROCD_FAIL;
        } 
    }

    public function set_pdf_download_url( $id, $url ){
        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            $_SESSION['rayssa']['excercises'][ $id ]['pdf_url'] = $url;
        } 
    }

    public function get_pdf_download_url( $id ){
        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            return $_SESSION['rayssa']['excercises'][ $id ]['pdf_url'];
        } 

        return null;
    }

    public function get_status( $id = null ){
        if( is_null( $id ) ){
            $id = $this->ssn_excercise_id;
        }

        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            return $_SESSION['rayssa']['excercises'][ $id ]['status'];
        } 

        return null;
    }

    public function remove_session( $id ){
        if( isset( $_SESSION['rayssa']['excercises'][ $id ] ) ){
            unset( $_SESSION['rayssa']['excercises'][ $id ] );
        } 
    } 

    private function excercise_session_init($id = null){
        $this->excercise_session_check();

        if( is_null($id)){
            $this->ssn_excercise_id = uniqid();
        } else {
            if( isset( $_SESSION['rayssa']['excercises'][$id] ) ){
                $this->ssn_excercise_id = $id;
                return;
            } else {
                $this->ssn_excercise_id = uniqid();
                
            }
        }

        $_SESSION['rayssa']['excercises'][$this->ssn_excercise_id] = [
            'status' => RAYSSA_EXCRCS_STTTS_STARTED,
            'start_time' => (new DateTime)->getTimestamp()
        ];

    }

    public function excercise_session_check(){

        if( !isset( $_SESSION['rayssa'] ) ){
            $_SESSION['rayssa'] = [];
            $_SESSION['rayssa']['session'] = $this;
            $_SESSION['rayssa']['excercises'] = [];
        } else {
            foreach( $_SESSION['rayssa']['excercises'] as $k => $ed ){
                $et = new DateTime();
                $et->setTimestamp( $ed['start_time'] );
                $time_diff = (new DateTime())->diff($et);
                $limit_days = intval( apply_filters( 'rayssa_session_days_time_days',4 ) );
                $is_finalized = $this->get_status( $k ) === RAYSSA_EXCRCS_STTTS_FINALIZED ? true : false;
                if( $is_finalized || ( intval( $time_diff->format('%a') ) > $limit_days ) ){
                    unset( $_SESSION['rayssa']['excercises'][$k] );
                }
            }
        }
    }

    static function prepare_session(){
        if( !session_id() )
        {
            session_start();
        }
    }
}