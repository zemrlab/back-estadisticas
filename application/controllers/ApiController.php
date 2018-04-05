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
        $array_out = $this->pago->listarTodosCantidad();
        $this->response($array_out);
    }

    public function importe_get(){
        $array_out = $this->pago->listarTodosImporte();
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
