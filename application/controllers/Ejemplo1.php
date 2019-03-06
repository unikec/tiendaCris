<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejemplo1 extends CI_Controller {
    

  public function index()
	{
        $this->load->library('email','','correo');
        $this->load->model('Model_fpdf');
        $this->load->model('Model_productos');
        $this->load->model('Model_usuarios');
        $idPedido=81;

        $this->load->library('email', '', 'correo');
        $this->load->model('Model_fpdf');

        $this->load->model('Model_productos');
        $datosPedido= $this->Model_productos->getPedido($idPedido);
        $lineasPedido= $this->Model_productos->getLineasPedido($idPedido);
        $email= $this->Model_usuarios->getEmailUsuario($datosPedido->usuario_id);
       // $lineasPedido= $this->Model_productos->getLineasPedido($idPedido);
       // echo 'hola';
       //  print_r($lineasPedido);
        $pdf = new FactPDF();
        $pdf->AddPage("P");
       
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'¡Hola, Mundo!');

       /* $pdf->datosCliente($datosPedido);
        $header = ["nombre","cantidad", "subtotal"];
        $pdf->tabla($header, $lineasPedido);*/
        $pdf->Output();//lo guardo con le nombre por defecto Doc.pdf*/

       // $pdf->Output("F");//lo guardo con le nombre por defecto Doc.pdf*/
       // $pdf->Output();
        $this->correo->from('tiendacrist@gmail.com', 'tiendaCris');
        $this->correo->to($email);
        $this->correo->subject("Detalle de su pedido en Copi Bily Paper");
        $this->correo->attach('doc.pdf', 'inline');//$this->correo->attach(base_url().'img/prueba.txt');
        $this->correo->message("bb");
   
	}//end index
}