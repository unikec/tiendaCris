<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ejemplo extends CI_Controller {
    

  public function index()
	{
		$this->load->library('email','','correo');


    $this->correo->from('tiendacrist@gmail.com', 'tiendaCris');
  $this->correo->to('garcasriz@gmail.com');
  $this->correo->subject('This is an email test');
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
