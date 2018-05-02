<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
/**
 *
 */
class ApiController extends REST_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('pago');
    }

    public function index_get(){
        $fecha_inicio = $this->get('inicio');
        $fecha_fin = $this->get('fin');
        if($fecha_inicio == '' || $fecha_fin == ''){
            $array_out = array("result"=>"error");
        }
        else{
            $array_out = $this->pago->listarPorFechasCantidad($fecha_inicio, $fecha_fin);
        }
        $this->response($array_out);
    }

    public function importe_get(){
        $fecha_inicio = $this->get('inicio');
        $fecha_fin = $this->get('fin');
        if($fecha_inicio == '' || $fecha_fin == ''){
            $array_out = array("result"=>"error");
        }
        else{
            $array_out = $this->pago->listarPorFechasImporte($fecha_inicio, $fecha_fin);
        }
        $this->response($array_out);
    }

    public function devolverAnioImporte_get(){
        $year = $this->get("year");
        if($year == ""){
            $array_out = array("result"=>"error");
        }
        else{
            $array_out = $this->pago->listarAnioImporte($year);
        }
        $this->response($array_out);
    }
    public function devolverAnioCantidad_get(){
        $year = $this->get("year");
        if($year == ""){
            $array_out = array("result"=>"error");
        }
        else{
            $array_out = $this->pago->listarAnioCantidad($year);
        }
        $this->response($array_out);
    }

    public function tablaFechas_get(){
        $fecha_inicio = $this->get('inicio');
        $fecha_fin = $this->get('fin');
        if($fecha_inicio == '' || $fecha_fin == ''){
            $array_out = array("result"=>"error1");
        }
        else{
            $array_out = $this->pago->registrosPorFechas($fecha_inicio, $fecha_fin);
        }
        $this->response($array_out);
    }

    public function tablaYear_get(){
        $year = $this->get("year");
        if($year == ""){
            $array_out = array("result"=>"error");
        }
        else{
            $array_out = $this->pago->registrosPorAnio($year);
        }
        $this->response($array_out);
    }
}


 ?>
