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
                SELECT nom_alumno as nombre , cod_alumno as id FROM public.alumno_programa
                WHERE  cod_alumno = '".$pass."' AND correo = '".$user."'
                "
            );

            $data = $query->result_array();

            if(count($data) == 1){
                $array_out = array("return"=>"success","id"=>$data[0]['id'],"user"=>$data[0]['nombre']);
                $query = $this->db->query("
                    SELECT id_mod as modulos FROM public.perfil_modulo
                    WHERE id_perfil = 4
                ");
                $array_out['modulos'] = $query->result_array();
            }
            else{
                $array_out = array("return"=>"failure");
            }


    	}
    	else if( $tipo == 'docente'){
    		$query = $this->db->query("
    			SELECT nombres as nombre, id FROM public.docente
    			WHERE  codigo = '".$pass."' AND email = '".$user."'"
            );

    		$data = $query->result_array();

    		if(count($data) == 1){
    			$array_out = array("return"=>"success","id"=>$data[0]['id'],"user"=>$data[0]['nombre']);
                $query = $this->db->query("
                    SELECT id_mod as modulos FROM public.perfil_modulo
                    WHERE id_perfil = 3
                ");
                $array_out['modulos'] = $query->result_array();
    		}
    		else{
    			$array_out = array("return"=>"failure");
    		}
    	}


        else if ( $tipo == 'administrativo'){
            $query = $this->db->query("
                SELECT nombres as nombre FROM public.administrativo
                WHERE  codigo = '".$pass."' AND email = '".$user."'"
            );

            $data = $query->result_array();

            if(count($data) == 1){
                $array_out = array("return"=>"success","user"=>$data[0]['nombre']);
                $query = $this->db->query("
                    SELECT id_mod as modulos FROM public.perfil_modulo
                    WHERE id_perfil = 2
                ");
                $array_out['modulos'] = $query->result_array();
            }
            else{
                $array_out = array("return"=>"failure");
            }
        }

    	else if( $tipo == 'admin'){
            if($user == 'admin@unmsm.edu.pe' && $pass == 'admin'){
                $array_out = array("return"=>"success","user"=>"administrador");
                $query = $this->db->query("
                    SELECT id_mod as modulos FROM public.perfil_modulo
                    WHERE id_perfil = 1
                ");
                $array_out['modulos'] = $query->result_array();
            }
            else{
                $array_out = array("return"=>"failure");
            }
    	}

    	return $array_out;
    }
}
