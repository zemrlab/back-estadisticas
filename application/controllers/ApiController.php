<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
/**
 *
 */
class ApiController extends REST_Controller {
    public function pagos_get(){
        $this->response([
            'status'=>'success',
            'method'=>$_SERVER['REQUEST_METHOD']
        ]);
    }

    public function pagos_post(){
        $this->response([
            'status'=>'success',
            'method'=>$_SERVER['REQUEST_METHOD']
        ]);
    }
}


 ?>
