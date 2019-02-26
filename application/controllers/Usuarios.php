<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuarios extends CI_Controller {

	public function index(){
        $this->load->model('Model_productos');
        $datos['categorias']= $this->Model_productos->getCategorias();
       // $datos['h2Inicial'] = 'Mi c';
		$this->load->view('plantilla', [
			'titulo' => 'Inicio de sesion',
			//'menu'=>  $this->load->view('Menu', $datos, true),
			'cuerpo' => $this->load->view('Login',[],true)
 		]
	);
	}

	public function logIn(){
            /*hacer loginOk($usuario, $clave)
//hay q usar password verify
$rs= $this->bd->where('username', 'user')->get('usuarios');
 //vuelve si no existe---hacer
 $datosUsuarios=$rs->row();
 if(password_verify($password, $datosUsuario->clave))*/ 
		$this->load->model('Model_productos');
		$this->load->model('Model_usuarios');

		$this->form_validation->set_rules('usuario', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
               // $=

		if ($this->model_Login->logOK($this->input->post('usuario'), $this->input->post('password'))& $this->form_validation->run() == TRUE) {			

			$this->session->set_userdata('usuario_id', $this->Model_usuarios->getID($this->input->post('usuario')));
			$this->session->set_userdata('nombre', $this->Model_usuarios->getNombre($this->input->post('usuario')));
			$this->session->set_userdata('administrador', $this->Model_usuarios->getAdmin($this->input->post('usuario')));
			
			$datos_categorias['categorias']= $this->Model_productos->getCategorias();
			$this->load->view('Plantilla', [
				'titulo' => 'Iniciando de sesion',
				'menu'=>  $this->load->view('Menu', $datos_categorias, true),
				'cuerpo' => $this->load->view('Listado_articulos',[],true)
			 ]);

		} else {
			$errormsg= "";
			if ($this->form_validation->run() == TRUE) {
				$errormsg= "Error en usuario o contraseña";
			}
			$datos_categorias['categorias']= $this->Model_productos->getCategorias();
			$this->load->view('Plantilla', [
				'titulo' => 'Loging',
				'menu'=>  $this->load->view('Menu', $datos_categorias, true),
				'cuerpo' => $this->load->view('Login',['error'=> $errormsg],true)
			 ]);
		}
		

	}

	public function logOut(){
		$this->load->model('Model_productos');
		$this->session->unset_userdata('usuario_id');
		$this->session->unset_userdata('nombre');
		$this->session->unset_userdata('administrador');

        $datos_categorias['categorias']= $this->Model_productos->getCategorias();
		$this->load->view('Plantilla', [
			'titulo' => 'Inicio de sesion',
			'menu'=>  $this->load->view('Menu', $datos_categorias, true),
			'cuerpo' => $this->load->view('Listado_articulos',[],true)
		 ]);
	}


/*hacer estaDentro()
return $this->session->userdata('dentro');
*/ 
/**hacer cierraSession() 
 * $this->session->get_userdata('dentro', false);
*/

public function registro(){
	$this->load->model('model_productos');
	
	$datos_categorias['categorias']= $this->Model_productos->getCategorias();
	$datos_provincias['provincias'] = $this->Model_usuarios->getProvincias();

	$this->form_validation->set_rules('nombre_usuario', 'nombre_usuario', 'required');
	$this->form_validation->set_rules('contraseña', 'Contraseña', 'required');
	$this->form_validation->set_rules('email', 'email', 'required');
	$this->form_validation->set_rules('nombre', 'nombre', 'required');
	$this->form_validation->set_rules('apellidos', 'apellidos', 'required');
	$this->form_validation->set_rules('dni', 'dni', 'required');
	$this->form_validation->set_rules('direccion', 'direccion', 'required');
	$this->form_validation->set_rules('provincia', 'provincia', 'required');

	if ($this->form_validation->run() == TRUE) {
		$this->model_usuarios->registroUsuario($this->input->post('nombre_usuario'),$this->input->post('contraseña'),$this->input->post('email'),$this->input->post('nombre'),$this->input->post('apellidos'),$this->input->post('dni'),$this->input->post('direccion'),$this->input->post('provincia'));
	   
		$this->session->set_userdata('usuario_id', $this->Model_usuarios->getID($this->input->post('nombre_usuario')));
		$this->session->set_userdata('nombre', $this->Model_usuarios->getNombre($this->input->post('nombre_usuario')));
		$this->session->set_userdata('administrador', $this->Model_usuarios->getAdmin($this->input->post('nombre_usuario')));

		$this->load->view('plantilla', [
			'titulo' => 'Registro con éxito',
			'menu'=>  $this->load->view('Menu', $datos_categorias, true),
			'cuerpo' => $this->load->view('RegistroCompletado',[],true)
		]);
	} else {   
		$this->load->view('plantilla', [
			'titulo' => 'Registrar usuario',
			'menu'=>  $this->load->view('Menu', $datos_categorias, true),
			'cuerpo' => $this->load->view('RegistroUsuario',$datos_provincias, true)
		]);
	}
}

}