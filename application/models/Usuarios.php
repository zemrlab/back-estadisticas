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
    		$query = $this->db->query("
                SELECT COUNT(*) as CANTIDAD ,nom_alumno as nombre FROM public.alumno_programa 
                WHERE  cod_alumno = '".$pass."' AND correo = '".$user."'
                GROUP BY nom_alumno
                ");

            $data = $query->result_array();

            
            if($data[0]['cantidad'] == 1){
                $array_out = array("return"=>"success","user"=>$data[0]['nombre']);
            }
            else{
                $array_out = array("return"=>"failure");
            }
    	}
    	else if( $tipo == 'docente'){
    		$query = $this->db->query("
    			SELECT nombres as nombre,COUNT(*) as CANTIDAD FROM public.docente 
    			WHERE  codigo = '".$pass."' AND email = '".$user."'
                GROUP BY nombres
    			");

    		$data = $query->result_array();

    		
    		if($data[0]['cantidad'] == 1){
    			$array_out = array("return"=>"success","user"=>$data[0]['nombre']);
    		}
    		else{
    			$array_out = array("return"=>"failure");
    		}
    	}
    	
    	else if( $tipo == 'admin'){
            if($user == 'admin' && $pass == 'admin'){
                $array_out = array("return"=>"success","user"=>"administrador");
            }
            else{
                $array_out = array("return"=>"failure");
            }
    	}
    	return $array_out;
    }
}