<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ejemplo2 extends CI_Controller {
    

  public function index()
	{
        $this->load->library('email', '', 'correo');
        $this->load->model('Model_productos');
        $this->load->model('Model_fpdf');
        $idPedido=24;
        $datosPedido= $this->Model_productos->getPedido($idPedido);
        $lineasPedido= $this->Model_productos->getLineasPedido($idPedido);
        echo('datos Pedido ');
        print_r($datosPedido);
        echo('USUARIO: '.$datosPedido->usuario_id);
        echo('<br>Lineas pedido: ');
        print_r('lineasPedido');
        $pdf = new FactPDF();
        $pdf->AddPage("P");
       

//$pdf->SetFont('Arial','B',16);
//$pdf->Cell(40,10,'¡Hola, Mundo!');


        $pdf->datosCliente($datosPedido);
        $header = ["nombre","cantidad", "subtotal"];
        $pdf->tabla($header, $lineasPedido);
        $pdf->Output("F");//lo guardo con le nombre por defecto Doc.pdf
       // $pdf->Output('D');//lo guardo con le nombre por defecto Doc.pdf

       // $email = $this->Model_usuarios->getEmailUsuario($this->session->userdata("usuario_id"));
        //$this->correo->from('tiendacrist@gmail.com', 'Copi Billy Papper');
       // $this->correo->to($email);
        $this->correo->subject("Detalle de su pedido en Copi Bily Paper");
        $this->correo->attach('doc.pdf', 'inline');//$this->correo->attach(base_url().'img/prueba.txt');
        $this->correo->message("bb");

        $this->correo->send();


    $this->correo->from('tiendacrist@gmail.com', 'tiendaCris');
    $this->correo->to('garcasriz@gmail.com');
   // $this->correo->subject('This is an email test');
    $this->correo->message('This is the body of the message');
if($this->correo->send())
  {
   echo 'Correo enviado';
  }

  else
  {
   show_error($this->correo->print_debugger());
  }
	}
}