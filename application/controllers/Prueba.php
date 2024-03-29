<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH. '/libraries/REST_Controller.php');
use Restserver\libraries\REST_Controller;

class Prueba extends REST_Controller {
   

    public function __construct(){
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->database();
    }
    public function index(){
        echo "Hola Mundo";
    }

    public function obtener_arreglo_get($index){
        if($index > 2){
            $respuesta = array('error'=> TRUE, 'mensaje'=>'No existe elemenos con esa posc.');
            $this->response($respuesta,REST_Controller::HTTP_BAD_REQUEST);

        }else{
            $arreglo =  array("Manzana","Pera","Piña");
            
            $respuesta = array('error'=> FALSE, 'fruta'=>$arreglo[$index]);
            $this->response($respuesta);
        }
        
        //echo json_encode ($arreglo[$index]);
    }

    public function obtener_producto_get($codigo){
       
        $query = $this->db->query("SELECT * FROM productos where codigo ='". $codigo ."'");

        //$query->result();
        $this->response($query->result());
    }
}