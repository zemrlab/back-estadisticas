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
        $query = $this->db->query('SELECT c.concepto AS concepto, COUNT(r.id_concepto) AS cantidad FROM public.recaudaciones r INNER JOIN public.concepto c ON (r.id_concepto = c.id_concepto) WHERE ( extract(epoch FROM r.fecha) >= '.$fecha_inicio.' AND extract(epoch FROM r.fecha) <= '.$fecha_fin.') GROUP BY r.id_concepto,c.concepto ORDER BY c.concepto');
        $data = $query->result_array();
        $array_out = $this->formato($data);
        return $array_out;
    }

    public function listarPorFechasImporte($fecha_inicio, $fecha_fin){
        $query = $this->db->query('SELECT c.concepto AS concepto, SUM(r.importe) AS cantidad FROM public.recaudaciones r INNER JOIN public.concepto c ON (r.id_concepto = c.id_concepto) WHERE ( extract(epoch FROM r.fecha) >= '.$fecha_inicio.' AND extract(epoch FROM r.fecha) <= '.$fecha_fin.') GROUP BY r.id_concepto,c.concepto ORDER BY c.concepto');
        $data = $query->result_array();
        $array_out = $this->formato($data);
        return $array_out;
    }

    public function listarAnioImporte($year){
        $query = $this->db->query(
            "SELECT to_char(to_timestamp(date_part('month',fecha)::text,'MM'),'Month') AS concepto,
                    SUM(importe) AS cantidad
            FROM public.recaudaciones
            WHERE date_part('year',fecha) = ".$year."
            GROUP BY concepto"
        );
        $data = $query->result_array();
        $array_out = $this->formato($data);
        return $array_out;
    }
    public function listarAnioCantidad($year){
        $query = $this->db->query(
            "SELECT to_char(to_timestamp(date_part('month',fecha)::text,'MM'),'Month') AS concepto,
                    COUNT(importe) AS cantidad
            FROM public.recaudaciones
            WHERE date_part('year',fecha) = ".$year."
            GROUP BY concepto"
        );
        $data = $query->result_array();
        $array_out = $this->formato($data);
        return $array_out;
    }
    public function test(){
        return "hola";
    }

    private function formato($data){
        $array_out = array('labels'=>array(),'datasets'=>array());
        $dataset = array('label'=>'transacciones','data'=>array());
        if(count($data)>0){
            foreach ($data as $concepto) {

                $array_out['labels'][] = $concepto['concepto'];
                $dataset['data'][] = $concepto['cantidad'];
            }

        }
        $array_out['datasets'][] = $dataset;
        return $array_out;
    }
}



 ?>
