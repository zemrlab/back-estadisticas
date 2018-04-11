<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Pago extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function listarTodosCantidad (){
        /*$this->db->select('concepto');
        $this->db->from('pago');
        $this->db->group_by('concepto');*/
        $query = $this->db->query('SELECT concepto, COUNT(concepto) AS cantidad FROM pago GROUP BY pago.concepto');
        $data = $query->result_array();
        $array_out = array('labels'=>array(),'datasets'=>array());
        $dataset = array('label'=>'transacciones','data'=>array());
        foreach ($data as $concepto) {
            $array_out['labels'][] = $concepto['concepto'];
            $dataset['data'][] = $concepto['cantidad'];
        }
        $array_out['datasets'][] = $dataset;
        return $array_out;
    }

    public function listarTodosImporte (){
        $query = $this->db->query('SELECT concepto, SUM(importe) AS cantidad FROM pago GROUP BY pago.concepto');
        $data = $query->result_array();
        $array_out = array('labels'=>array(),'datasets'=>array());
        $dataset = array('label'=>'Importe','data'=>array());
        foreach ($data as $concepto) {
            $array_out['labels'][] = $concepto['concepto'];
            $dataset['data'][] = $concepto['cantidad'];
        }
        $array_out['datasets'][] = $dataset;
        return $array_out;
    }

    public function listarPorFechasCantidad($fecha_inicio, $fecha_fin){
        $query = $this->db->query('SELECT concepto, COUNT(concepto) AS cantidad FROM pago WHERE (UNIX_TIMESTAMP(fecha) >= '.$fecha_inicio.' AND UNIX_TIMESTAMP(fecha) <= '.$fecha_fin.') GROUP BY pago.concepto');
        $data = $query->result_array();
        $array_out = array('labels'=>array(),'datasets'=>array());
        $dataset = array('label'=>'transacciones','data'=>array());
        if(count($data)>0){
            foreach ($data as $concepto) {

                $array_out['labels'][] = $concepto['concepto'];
                $dataset['data'][] = $concepto['cantidad'];
            }
            $array_out['datasets'][] = $dataset;
        }
        return $array_out;
    }

    public function listarPorFechasImporte(){
        $query = $this->db->query('SELECT concepto, SUM(importe) AS cantidad FROM pago WHERE (UNIX_TIMESTAMP(fecha) >= '.$fecha_inicio.' AND UNIX_TIMESTAMP(fecha) <= '.$fecha_fin.') GROUP BY pago.concepto');
        $data = $query->result_array();
        $array_out = array('labels'=>array(),'datasets'=>array());
        $dataset = array('label'=>'transacciones','data'=>array());
        if(count($data)>0){
            foreach ($data as $concepto) {

                $array_out['labels'][] = $concepto['concepto'];
                $dataset['data'][] = $concepto['cantidad'];
            }
            $array_out['datasets'][] = $dataset;
        }
        return $array_out;
    }

    public function test(){
        return "hola";
    }
}



 ?>
