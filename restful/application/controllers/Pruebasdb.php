<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebasdb extends CI_Controller {

    public function __construct(){
        // Llamado del constructor del padre
        parent::__construct();
        $this->load->database();
        $this->load->helper('utilidades');
    }
        
    // SCRIPT SQL CREACION TABLA TEST
    // ====================================================================================
    // CREATE TABLE `test` (
	// `id` INT(11) NOT NULL AUTO_INCREMENT,
	// `nombre` VARCHAR(100) NOT NULL DEFAULT '0' COLLATE 'utf8_spanish_ci',
	// `apellido` VARCHAR(100) NOT NULL DEFAULT '0' COLLATE 'utf8_spanish_ci',
	// PRIMARY KEY (`id`)
    // )
    // COLLATE='utf8_spanish_ci'
    // ENGINE=InnoDB
    // ====================================================================================


    public function eliminar(){
        $this->db->where('id', 1);
        $this->db->delete('test');

        echo "Registro eliminado";
    }

    public function actualizar(){
        $data = array(
                'nombre' => 'eNoc',
                'apellido'  => 'mArtinEz'
        );

        $data = capitalizar_todo($data);

        $this->db->where('id', 1);
        $this->db->update('test', $data);

        echo "todo ok";
    }

    public function insertar(){

        // INSERCION DE UN REGISTRO A LA VEZ
        // $data = array(
        // 'nombre' => 'akin',
        // 'apellido' => 'ramirez'
        // );

        // $data = capitalizar_todo($data);

        // $this->db->insert('test', $data);
        // $respuesta = array(
        //     'err' => FALSE,
        //     'id_insertado' => $this->db->insert_id()
        // );
        // echo json_encode($respuesta);

        // INSERCION DE MULTIPLES REGISTRO A LA VES
        $data = array(
            array(
                    'nombre' => 'bilsan',
                    'apellido' => 'ramirez'
            ),
            array(
                    'nombre' => 'enoc',
                    'apellido' => 'flores'
            )
            );

            $this->db->insert_batch('test', $data);
            echo $this->db->affected_rows();
    }

    public function tabla(){
        // $query = $this->db->get('clientes');
        // $query = $this->db->get('clientes',10,0);        
        // $this->db->select_max('id','id_maximo');
        // $this->db->select_min('id','id_minimo');
        // $this->db->select_avg('id','id_promedio');
        // $this->db->select_sum('id','id_sumatorio');
        // $query = $this->db->get('clientes');

        // $this->db->select('id,nombre,correo,(SELECT COUNT(*) FROM clientes) as conteo');
        // $query = $this->db->get_where('clientes',array('id'=> 1));

        // foreach($query->result() as $fila){
        //     echo $fila->nombre . '</br>';
        // }

        // echo json_encode($query->result());
        
        // $this->db->select('id, nombre, correo');
        // $this->db->select('pais,count(*) as cant_clientes');
        $this->db->distinct();
        $this->db->select('pais');
        $this->db->from('clientes');      

        // $this->db->where('id',1);
        // $this->db->where('activo',0);
        // $this->db->where('id !=',1);
        // $this->db->where('id < 10');
        // $this->db->where('id',1);
        // $this->db->or_where('id',2);
        // $ids = array(1,2,3,4,5);
        // $this->db->where_in('id',$ids);
        // $this->db->where_not_in('id',$ids);
        // $this->db->like('nombre','COLTON');
        // $this->db->like('nombre','LINDSEY');
        // $this->db->like('nombre','LINDSEY','after');
        // $this->db->like('nombre','LINDSEY','before');
        // $this->db->group_by('pais');
        $this->db->order_by('pais','asc');
        $this->db->limit(10,10);
        echo $this->db->count_all_results();
        echo '</br>';
        echo $this->db->count_all('clientes');
        
        // $query = $this->db->get();

        // foreach ($query->result() as $fila) {
        //    echo $fila->pais .'</br>';
        // }

        // echo json_encode($query->row());
        // echo json_encode($query->result());
    }

    public function clientes_beta(){
        // $this->load->database();
        $query = $this->db->query('SELECT id, nombre, correo, telefono1 FROM clientes LIMIT 10');

        // foreach ($query->result() as $row) {
        //     echo $row->id;
        //     echo $row->nombre;
        //     echo $row->correo;
        // }
        // echo 'Total registro: ' . $query->num_rows();

        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Registros cargados correctamente',
            'total_registros' => $query->num_rows(),
            'clientes' => $query->result()
        );

        echo json_encode($respuesta);

    }

    public function cliente($id){
        // $this->load->database();
        $query = $this->db->query('SELECT * FROM clientes WHERE id='.$id);

        $fila = $query->row();

        if(isset($fila)){
            // FILA EXISTE
            $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Registros cargados correctamente',
            'total_registros' => 1,
            'clientes' => $query->result()
            );
        }else{
            // FILA NO EXISTE
            $respuesta = array(
            'err' => TRUE,
            'mensaje' => 'El registro con el id '. $id .', no existe',
            'total_registros' => 0,
            'clientes' => null
            );
        }

        echo json_encode($respuesta);

    }



}
