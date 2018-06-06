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

        //cambios diego
        public function listaConceptos_get(){
            $array_out = $this->pago->listarConceptos();
            $this->response($array_out);
        }

        public function cantidadPorPeriodoAnio_get(){
            $yearStart = $this->get("year_inicio");
            $yearEnd = $this->get("year_fin");
            $conceptos = $this->get("conceptos");

            if($yearStart == "" or $yearEnd == ""){
                $data = array('result'=>'error');
            }
            else if($yearStart > $yearEnd){
                $data = array('result'=>'error');
            }
            else{
                $data = $this->pago->listarCantidadPeriodoAnual($yearStart,$yearEnd, $conceptos);
            }
            $this->response($data);
        }

        public function montoPorPeriodoAnio_get(){
            $yearStart = $this->get("year_inicio");
            $yearEnd = $this->get("year_fin");
            $conceptos = $this->get("conceptos");

            if($yearStart == "" or $yearEnd == ""){
                $data = array('result'=>'error');
            }
            else if($yearStart > $yearEnd){
                $data = array('result'=>'error');
            }
            else{
                $data = $this->pago->listarTotalPeriodoAnual($yearStart,$yearEnd, $conceptos);
            }
            $this->response($data);
        }

        public function cantidadPorPeriodoMes_get(){
            $year = $this->get("year");
            $startMonth = $this->get("mes_inicio");
            $endMonth = $this->get("mes_fin");
            $conceptos = $this->get("conceptos");

            if($startMonth == "" or $endMonth == "" or $year == ""){
                $data = array('result'=>'error');
            }
            else if($startMonth > $endMonth){
                $data = array('result'=>'error');
            }
            else{
                $data = $this->pago->listarCantidadPeriodoMensual($year,$startMonth,$endMonth , $conceptos);
            }
            $this->response($data);
        }
        public function totalPorPeriodoMes_get(){
            $year = $this->get("year");
            $startMonth = $this->get("mes_inicio");
            $endMonth = $this->get("mes_fin");
            $conceptos = $this->get("conceptos");

            if($startMonth == "" or $endMonth == "" or $year == ""){
                $data = array('result'=>'error');
            }
            else if($startMonth > $endMonth){
                $data = array('result'=>'error');
            }
            else{
                $data = $this->pago->listarTotalPeriodoMensual($year,$startMonth,$endMonth, $conceptos);
            }
            $this->response($data);
        }
}


 ?>
