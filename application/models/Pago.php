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
        $query = $this->db->query("SELECT c.concepto AS concepto, COUNT(r.id_concepto) AS cantidad 
        FROM public.recaudaciones r 
        INNER JOIN public.concepto c ON (r.id_concepto = c.id_concepto) 
        INNER JOIN public.clase_pagos p ON (p.id_clase_pagos = c.id_clase_pagos)
        WHERE ( 
            extract(epoch FROM r.fecha) >= ".$fecha_inicio." 
            AND extract(epoch FROM r.fecha) <= ".$fecha_fin."
            AND p.id_clase_pagos in (SELECT distinct (id_clase_pagos) FROM configuracion where estado = 'S')
        ) 
        GROUP BY r.id_concepto,c.concepto 
        ORDER BY c.concepto");
        $data = $query->result_array();
        $array_out = $this->formatoGrafico($data,'Importes');
        return $array_out;
    }

    public function listarPorFechasImporte($fecha_inicio, $fecha_fin){
        $query = $this->db->query("SELECT c.concepto AS concepto, SUM(r.importe) AS cantidad 
        FROM public.recaudaciones r 
        INNER JOIN public.concepto c ON (r.id_concepto = c.id_concepto) 
        INNER JOIN public.clase_pagos p ON (p.id_clase_pagos = c.id_clase_pagos)
        WHERE ( 
            extract(epoch FROM r.fecha) >= ".$fecha_inicio." 
            AND extract(epoch FROM r.fecha) <= ".$fecha_fin."
            AND p.id_clase_pagos in (SELECT distinct (id_clase_pagos) FROM configuracion where estado = 'S')
        ) 
        GROUP BY r.id_concepto,c.concepto 
        ORDER BY c.concepto");
        $data = $query->result_array();
        $array_out = $this->formatoGrafico($data,'Monto');
        return $array_out;
    }

    public function listarAnioCantidad($year){
        $query = $this->db->query(
            "SELECT to_char(to_timestamp(date_part('month',r.fecha)::text,'MM'),'Month') AS concepto,
                    COUNT(r.importe) AS cantidad
            FROM public.recaudaciones r
            INNER JOIN public.concepto c ON (r.id_concepto = c.id_concepto) 
            INNER JOIN public.clase_pagos p ON (p.id_clase_pagos = c.id_clase_pagos)
            WHERE (
                date_part('year',fecha) = ".$year."
                AND p.id_clase_pagos in (SELECT distinct (id_clase_pagos) FROM configuracion where estado = 'S')
            )
            GROUP BY to_char(to_timestamp(date_part('month',r.fecha)::text,'MM'),'Month')"
        );
        $data = $query->result_array();
        $array_out = $this->formatoGrafico($data,'Importes');
        return $array_out;
    }
    public function test(){
        return "hola";
    }

    public function listarAnioImporte($year){
        $query = $this->db->query(
            "SELECT to_char(to_timestamp(date_part('month',fecha)::text,'MM'),'Month') AS concepto,
                    SUM(importe) AS cantidad
            FROM public.recaudaciones r
            INNER JOIN public.concepto c ON (r.id_concepto = c.id_concepto) 
            INNER JOIN public.clase_pagos p ON (p.id_clase_pagos = c.id_clase_pagos)
            WHERE (
                date_part('year',fecha) = ".$year."
                AND p.id_clase_pagos in (SELECT distinct (id_clase_pagos) FROM configuracion where estado = 'S')
            )
            GROUP BY to_char(to_timestamp(date_part('month',fecha)::text,'MM'),'Month')"
        );
        $data = $query->result_array();
        $array_out = $this->formatoGrafico($data,'Monto');
        return $array_out;
    }

    public function registrosPorFechas($fecha_inicio, $fecha_fin){
        $query = $this->db->query("SELECT c.concepto AS concepto, r.importe AS importe, trim(a.codigo) AS codigoAlumno, a.ape_nom AS nombreAlumno, r.fecha 
            FROM public.recaudaciones r 
                INNER JOIN public.concepto c 
                    ON (r.id_concepto = c.id_concepto)
                INNER JOIN public.alumno a 
                    ON (r.id_alum = a.id_alum)
                INNER JOIN public.clase_pagos p 
                    ON (p.id_clase_pagos = c.id_clase_pagos)
            WHERE ( 
                extract(epoch FROM r.fecha) >= ".$fecha_inicio." 
                AND extract(epoch FROM r.fecha) <= ".$fecha_fin."
                AND p.id_clase_pagos in (SELECT distinct (id_clase_pagos) FROM configuracion where estado = 'S')
            )
            ORDER BY r.fecha");
        $data = $query->result_array();
        $array_out = $this->formatoTabla($data);
        return $array_out;
    }

    public function registrosPorAnio($year){
        $query=$this->db->query("SELECT c.concepto AS concepto, r.importe AS importe, trim(a.codigo) AS codigoAlumno, a.ape_nom AS nombreAlumno, r.fecha 
            FROM public.recaudaciones r 
                INNER JOIN public.concepto c 
                    ON (r.id_concepto = c.id_concepto)
                INNER JOIN public.alumno a 
                    ON (r.id_alum = a.id_alum) 
                INNER JOIN public.clase_pagos p 
                    ON (p.id_clase_pagos = c.id_clase_pagos)
            WHERE (
                date_part('year',fecha) = ".$year."
                AND p.id_clase_pagos in (SELECT distinct (id_clase_pagos) FROM configuracion where estado = 'S')
            )
            ORDER BY r.fecha");
        $data = $query->result_array();
        $array_out = $this->formatoTabla($data);
        return $array_out;
    }

    private function formatoGrafico($data,$etiqueta){
        $array_out = array('labels'=>array(),'datasets'=>array());
        $dataset = array('label'=>$etiqueta,'data'=>array());
        if(count($data)>0){
            foreach ($data as $concepto) {

                $array_out['labels'][] = $concepto['concepto'];
                $dataset['data'][] = $concepto['cantidad'];
            }

        }
        $array_out['datasets'][] = $dataset;
        return $array_out;
    }

    private function formatoTabla($data){
        $array_out = array();
        if(count($data)>0){
            foreach ($data as $registro) {
                $array_out[] = $registro;
            }
        }
        return $array_out;
    }
}



 ?>
