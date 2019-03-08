<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdministrarCategorias extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('Grocery_CRUD');
    }    
     public function index(){
        $crud = new Grocery_CRUD();
        $crud->set_table('categorias');
        $crud->set_subject('Categorias');
        $crud->unset_clone();//Quita el botón de clonars
        $crud->columns('nombre','descripcion','visible');

       // $datos['tabla']=$crud->render();
        $datos = $crud->render();

        $this->load->view( $this->load->view('CrudCategorias',$datos,true)
         );
     }
}