<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class Tareas extends REST_Controller {

    public function __construct(){

        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");
    
    
        parent::__construct();
        $this->load->database();
    
      }

      public function realizar_tarea_post($token="0",$id_usuario="0"){

        $data = $this->post();

        if( $token == "0" || $id_usuario == "0" ){
          $respuesta = array(
                        'error' => TRUE,
                        'mensaje'=> "Token invalido y/o usuario invalido."
                      );
          $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
          return;
        }
    

        $condiciones = array('id' => $id_usuario, 'token'=> $token );
        $this->db->where( $condiciones );
        $query = $this->db->get('login');

        $existe = $query->row();

        if( !$existe ){
          $respuesta = array(
                        'error' => TRUE,
                        'mensaje'=> "Usuario y Token incorrectos"
                      );
          $this->response( $respuesta );
          return;
        }
        $this->db->reset_query();

        $insertar = array('tra_des' => $data['des'] ,'tra_lugar' => $data['lugar'],'tra_obs' =>  $data['obs'], 'tra_estado'=>'AC','tra_usuario'=>$id_usuario);
        $this->db->insert( 'tareas', $insertar );
        $orden_id = $this->db->insert_id();

        $respuesta = array(
          'error' => FALSE,
          'mensaje' => 'Tarea Agregada Correctamente'
        );
        
        $this->response( $respuesta );
    }

    public function obtener_tareas_get($token = "0", $id_usuario ="0" ){

      if( $token == "0" || $id_usuario == "0" ){
        $respuesta = array(
                      'error' => TRUE,
                      'mensaje'=> "Token invalido y/o usuario invalido."
                    );
        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
        return;
      }
  
      $condiciones = array('id' => $id_usuario, 'token'=> $token );
      $this->db->where( $condiciones );
      $query = $this->db->get('login');
  
      $existe = $query->row();
  
      if( !$existe ){
        $respuesta = array(
                      'error' => TRUE,
                      'mensaje'=> "Usuario y Token incorrectos"
                    );
        $this->response( $respuesta );
        return;
      }
  
      // Retornar todas las tareas del usuario    
        $query = $this->db->query('SELECT * FROM `tareas` ');
    
        $respuesta = array(
                'error' => FALSE,
                'productos' => $query->result_array()
              );
    
        $this->response( $respuesta );
  
  
    }
}

