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
            $array_out = $this->pago->listarTodosCantidad();
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
            $array_out = $this->pago->listarTodosImporte();
        }
        else{
            $array_out = $this->pago->listarPorFechasImporte($fecha_inicio, $fecha_fin);
        }
        $this->response($array_out);
    }



    public function pago_post(){
        $this->response([
            'status'=>'success',
            'method'=>$_SERVER['REQUEST_METHOD']
        ]);
    }
}


 ?>
