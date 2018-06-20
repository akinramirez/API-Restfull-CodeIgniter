<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareas extends CI_Controller {

    public function alumnos_conteo(){
        $this->load->database();
        $query = $this->db->query('SELECT COUNT(nombre) AS total_alumnos FROM alumnos');

        if(isset($query)){
            $respuesta = array(
                'erro' => FALSE,
                'mensaje' => 'Exitos!!! en la consulta',
                'total_alumnos' => $query->result()
            );
        }else{
             $respuesta = array(
                'erro' => TRUE,
                'mensaje' => 'Problema!!! en la consulta',
                'total_alumnos' => $query->result()
            );
        }
        
        echo json_encode($respuesta);

    }

    public function alumnos_listado(){
        $this->load->database();
        $query = $this->db->query('SELECT id, nombre, parcial1, parcial2, parcial3, 
                                    round((parcial1+parcial2+parcial3)/3,0) AS promedio
                                    FROM alumnos');

        if(isset($query)){
            $respuesta = array(
                'erro' => FALSE,
                'mensaje' => 'Exitos!!! en la consulta',
                'notas_alumnos' => $query->result()
            );
        }else{
            $respuesta = array(
                'erro' => TRUE,
                'mensaje' => 'Problema!!! en la consulta',
                'notas_alumnos' => $query->result()
            );
        }
        echo json_encode($respuesta);

        
    }

}