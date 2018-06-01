<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Usuarios extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function loggin ($user,$pass,$tipo){

    	if($tipo == 'alumno'){
    		$array_out = array("return"=>"unsupported");

    	}
    	else if( $tipo == 'docente'){
    		$query = $this->db->query("
    			SELECT COUNT(*) as CANTIDAD FROM public.docente 
    			WHERE  codigo = '".$pass."' AND email = '".$user."'
    			");

    		$data = $query->result_array();

    		
    		if($data[0]['cantidad'] == 1){
    			$array_out = array("return"=>"success","user"=>$user);
    		}
    		else{
    			$array_out = array("return"=>"failure","user"=>$user);
    		}
    		
    		$array_out = array("return"=>"success","user"=>$user);
    	}
    	
    	else if( $tipo == 'admin'){
    		$array_out = array("return"=>"unsupported");
    	}
    	return $array_out;
    }
}