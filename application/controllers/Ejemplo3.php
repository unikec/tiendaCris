<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejemplo3 extends CI_Controller {
    

  public function index()
	{
        $idPedido=81;
        $clienteID=16;
        $this->load->library('email', '', 'correo');
        $this->load->model('Model_fpdf');
        $this->load->model('Model_productos');
        $this->load->model('Model_usuarios');


        $datosPedido= $this->Model_productos->getPedido($idPedido);
      //  $lineasPedido= $this->Model_productos->getLineasPedido($idPedido);
       
       /* $pdf = new FactPDF();
        $pdf->AddPage("P");

        $pdf->datosCliente($datosPedido);
        $header = ["nombre","cantidad", "subtotal"];
        $pdf->tabla($header, $lineasPedido);
        $pdf->Output("F");//lo guardo con le nombre por defecto Doc.pdf*/

        $todosPedido=$this->Model_productos->getPedidos($clienteID);
       // print_r($todosPedido);
    //echo $datosPedido->usuario_id;
       $email = $this->Model_usuarios->getEmailUsuarioPorID($datosPedido->usuario_id);
       echo $email;

       $total=$this->Model_productos->totalPedido(15);
       echo $total;
    }
}