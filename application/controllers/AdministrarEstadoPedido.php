<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdministrarEstadoPedido extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('Grocery_CRUD');
    }    
     public function index(){
        $crud = new Grocery_CRUD();
     
        $crud->set_table('pedido');
        $crud->set_subject('Pedido');
        $crud->unset_clone();//Quita el botón de clonars
        $crud->columns('pedido_id','fecha','estado','usuario_id','nombre_usuario_pedido','apellidos_pedido','dni_pedido');
        $crud->edit_fields('estado');

       // $datos['tabla']=$crud->render();
        $datos = $crud->render();

        $this->load->view( $this->load->view('CrudPedido',$datos,true)
         );
     }
}