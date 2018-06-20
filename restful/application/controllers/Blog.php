<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function index()
    {
            echo 'Hello World!';
           
    }

    public function Comentarios($id)
    {
        if(!is_numeric($id)){
            $respuesta = array('error' => true, 'mensaje'=>'El id tiene que ser numerico');
            echo json_encode($respuesta);
            return;
        }

        $comentarios = array(
            array('id' => 1, 'mensaje' => 'lorem ipsum dolor sit amert1'),
            array('id' => 2, 'mensaje' => 'lorem ipsum dolor sit amert2'),
            array('id' => 3, 'mensaje' => 'lorem ipsum dolor sit amert3')
        );
        
        if($id>=count($comentarios) OR $id < 0){
            $respuesta = array('error' => true, 'mensaje'=>'El id no existe');
            echo json_encode($respuesta);
            return;
        }

        echo json_encode($comentarios[$id]);
    }



}