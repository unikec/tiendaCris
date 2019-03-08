<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdministrarProductos extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('Grocery_CRUD');
    }    
     public function index(){
        $crud = new Grocery_CRUD();
  
        $crud->set_table('producto');
        $crud->set_subject('Productos');
        $crud->unset_clone();//Quita el botón de clonars
        $crud->columns('nombre','precio','descuento','imagen','iva','descripcion','anuncio','stock','categoria_id','visible','destacado','finicio_dest','ffin_dest');

       // $datos['tabla']=$crud->render();
        $datos = $crud->render();

        $this->load->view( $this->load->view('CrudProductos',$datos,true)
         );
     }
}