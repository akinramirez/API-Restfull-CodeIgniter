<?php

class Cliente_model extends CI_Model {

    public $id;
    public $nombre;
    public $activo;
    public $correo;
    public $zip;
    public $telefono1;
    public $telefono2;
    public $pais;
    public $direccion;

    public function get_cliente($id){
        // $this->db->select('id,nombre');
        $this->db->where(array('id'=>$id, 'status'=>'activo'));
        $query = $this->db->get('clientes');

        $row = $query->custom_row_object(0,'Cliente_model');

        if(isset($row)){
            $row->id = intval($row->id );
             $row->activo = intval($row->activo );
        }
        return $row;
    }

    public function set_datos($data_cruda){

        foreach ($data_cruda as $nombre_campo => $valor_campo) {
            
            if(property_exists('Cliente_model', $nombre_campo)){
                $this->$nombre_campo = $valor_campo;
            }
        }

        if($this->activo == NULL ){
            $this->activo = 1;
        }

        $this->nombre = strtoupper($this->nombre);

        return $this;
        
    }

    public function insert(){
        //$this->response('Todo bien');

        //Verificar el correo
        $query = $this->db->get_where('clientes',array('correo' => $this->correo));
        $cliente_correo = $query->row();
        if(isset($cliente_correo)){
            //EXISTE
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El correo electronico ya esta registrado'
                );
            //$this->response($respuesta,REST_Controller::HTTP_BAD_REQUEST);
            return $respuesta;
        }
        
        //SE PROCEDE A LA INSERCION DE DATOS
        //$this es el objeto del modelo
        $hecho = $this->db->insert('clientes', $this);

        if($hecho){
            //insertado
                $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro insertado correctamente',
                'cliente_id' => $this->db->insert_id()
                );
            // $this->response($respuesta);
        }else{
            //Si No sucedio
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Error al insertar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->_error_number()
                );
            // $this->response($respuesta,REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $respuesta;
    }

    public function update(){
        //Verificar el correo
        $this->db->where('correo',$this->correo);
        $this->db->where('id !=',$this->id);
        $query = $this->db->get('clientes');

        $cliente_correo = $query->row();
        if(isset($cliente_correo)){
            //EXISTE
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El correo electronico ya esta registrado por otro usuario.'
                );
            return $respuesta;
        }
        
        //SE PROCEDE CON LA ACTUALIZACION DE LOS DATOS
        //$this es el objeto del modelo
        $this->db->reset_query();
        $this->db->where('id',$this->id);

        $hecho = $this->db->update('clientes', $this);

        if($hecho){
            //Actualizado
                $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro actualizado correctamente',
                'cliente_id' => $this->id
                );
            // $this->response($respuesta);
        }else{
            //Si No sucedio
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Error al actualizar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->_error_number()
                );
            // $this->response($respuesta,REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $respuesta;
    }

    public function delete($cliente_id){
        $this->db->set('status','borrado');
        $this->db->where('id',$cliente_id);
        $hecho = $this->db->update('clientes');
        
        if($hecho){
            //Borrado
                $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro eliminado correctamente'
                );
        }else{
            //Si No sucedio
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Error al borrar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->_error_number()
                );
        }
        return $respuesta;
    }
}
