<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'Libraries/REST_Controller.php';

class Clientes extends REST_Controller {

    // public function index_get(){
    //     $this->load->helper('utilidades');

    //     $data = array(
    //         'nombre'     => 'akin ramirez',
    //         'contacto'   => 'bilsan ramirez',
    //         'direaccion' => 'barrio el centro, avenida color, calle la plazuela'
    //     );

    //     // $data['nombre']   = strtoupper($data['nombre']);
    //     // $data['contacto'] = strtoupper($data['contacto']);
        
    //     $campos_capitalizar = array('nombre','contacto');
    //     $data = capitalizar_arreglo($data,$campos_capitalizar);

    //     echo json_encode($data);

    // }

    // public function cliente_get($id){
    //     $this->load->model('Cliente_model');
    //     $cliente = $this->Cliente_model->get_cliente(s);
    //     echo json_encode($cliente);
    // }

    // RESTFUL
    public function __construct(){
        // Llamado del constructor del padre
        parent::__construct();
        $this->load->database();
        $this->load->helper('utilidades');
        $this->load->model('Cliente_model');
    }
    
    // PAGINACION
    public function paginar_get(){
        $this->load->helper('paginacion');

        $pagina     = $this->uri->segment(3);
        $por_pagina = $this->uri->segment(4);
        // $campos     = array('id','nombre','telefono1');

        $respuesta  = paginar_todo('clientes',$pagina,$por_pagina);//,$campos);

        $this->response($respuesta);

    }

    // PAGINACION 1
    // public function paginar1_get(){
    //     $query = $this->db->get('clientes');
    //     $respuesta  = $query->result();
    //     $this->response($respuesta);
    // }

    // INSERT -> PUT
    public function cliente_put(){
       $data = $this->put();
       $this->load->library('form_validation');
       $this->form_validation->set_data($data);

        //    $this->form_validation->set_rules('correo','correo electronico','required|valid_email');
        //    $this->form_validation->set_rules('nombre','nombre','required|min_length[2]');

       //TRUE:: TODO BIEN  FALSE::FALLA YUNA REGLA
       if($this->form_validation->run('cliente_put')){           
           //TODO BIEN
           $cliente = $this->Cliente_model->set_datos($data);
           $respuesta = $cliente->update();

           if($respuesta['err']){
                $this->response($respuesta,REST_Controller::HTTP_BAD_REQUEST);
           }else{
                $this->response($respuesta);
           }
           
       }else{
            ///TODO MAL -> Error de la validacion
            //$this->response('Todo mal');
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Hay errores en el envio de informacion',
                'errores' => $this->form_validation->get_errores_arreglo()
            );        
            
            $this->response($respuesta);                
       }
        //    $this->response($data);
    }

    // UPDATE -> POST
    public function cliente_post(){
        $this->load->library('form_validation');
        $cliente_id = $this->uri->segment(3);
        $data = $this->post();
        $data['id'] = $cliente_id;       
       
        $this->form_validation->set_data($data);       

        //TRUE:: TODO BIEN  FALSE::FALLA YUNA REGLA
        if($this->form_validation->run('cliente_post')){           
            //TODO BIEN
            $cliente = $this->Cliente_model->set_datos($data);
            $respuesta = $cliente->update();

            if($respuesta['err']){
                    $this->response($respuesta,REST_Controller::HTTP_BAD_REQUEST);
            }else{
                    $this->response($respuesta);
            }
            
        }else{
                ///TODO MAL -> Error de la validacion
                $respuesta = array(
                    'err' => TRUE,
                    'mensaje' => 'Hay errores en el envio de informacion',
                    'errores' => $this->form_validation->get_errores_arreglo()
                );       
                $this->response($respuesta);                 
        }
    }

    // DELETE -> DELETE
    public function cliente_delete(){
        $cliente_id     = $this->uri->segment(3);
        $respuesta = $this->Cliente_model->delete($cliente_id);
        $this->response($respuesta);
    }

    // SELECT
    public function cliente_get(){
        $cliente_id = $this->uri->segment(3);
        // Validar el cliente_id
        if(!isset($cliente_id)){
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Es necesario el ID del cliente'
            );
            $this->response($respuesta,REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        
        $cliente = $this->Cliente_model->get_cliente($cliente_id);

        if(isset($cliente)){

            unset($cliente->telefono1);
            unset($cliente->telefono2);

            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro cargado correctamente',
                'cliente' => $cliente
            );
            $this->response($respuesta);

        }else{
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El registro con el id '. $cliente_id . ' no existe.',
                'cliente' => null
            );
            $this->response($respuesta,REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($cliente);
    }
}