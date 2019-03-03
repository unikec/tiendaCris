<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuarios extends CI_Controller {

	public function index(){
        $this->load->model('Model_productos');
       // $datos['categorias']= $this->Model_productos->getCategorias();
       // $datos['h2Inicial'] = 'Mi c';
		$this->load->view('plantilla', [
			'titulo' => 'Inicio de sesion',
			//'menu'=>  $this->load->view('Menu', $datos, true),
			'cuerpo' => $this->load->view('Login',[],true)
 		]
	);
	}

	public function logIn(){

		$this->load->model('Model_productos');
		$this->load->model('Model_usuarios');

		$this->form_validation->set_rules('usuario', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
               

		if ($this->Model_usuarios->logOK(
			$this->input->post('usuario'),
			$this->input->post('password'))&
			$this->form_validation->run() == TRUE) {			

			$this->session->set_userdata('usuario_id', $this->Model_usuarios->getUsuarioId($this->input->post('usuario')));
			$this->session->set_userdata('nombre_usuario', $this->Model_usuarios->getNombreUsuario($this->input->post('usuario')));
			$this->session->set_userdata('administrador', $this->Model_usuarios->getAdmin($this->input->post('usuario')));
			
			 $this->load->view('Plantilla', [
				'titulo' => 'Iniciando sesion',
			//	'menu'=>  $this->load->view('Menu', $datos_categorias, true),
				'cuerpo' => $this->load->view('Bienvenida',[],true)
			 ]);

		} else {
			$errormsg= "";
			if ($this->form_validation->run() == TRUE) {
				$errormsg= "Error en usuario o contraseña";
			}
		//	$datos_categorias['categorias']= $this->Model_productos->getCategorias();
			$this->load->view('Plantilla', [
				'titulo' => 'Loging',
				//'menu'=>  $this->load->view('Menu', $datos_categorias, true),
				'cuerpo' => $this->load->view('Login',['error'=> $errormsg],true)
			 ]);
		}
		

	}

	public function logOut(){
		$this->load->model('Model_productos');
		$this->session->unset_userdata('usuario_id');
		$this->session->unset_userdata('nombre');
		$this->session->unset_userdata('administrador');

       // $datos_categorias['categorias']= $this->Model_productos->getCategorias();
		$this->load->view('Plantilla', [
			'titulo' => 'Inicio de sesion',
			//'menu'=>  $this->load->view('Menu', $datos_categorias, true),
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
	$this->load->model('Model_productos');
	$this->load->model('Model_usuarios');
	
	//$datos_categorias['categorias']= $this->Model_productos->getCategorias();
	$datos_provincias['provincias'] = $this->Model_usuarios->getProvincias();

	$this->form_validation->set_rules('nombre_usuario', 'nombre_usuario', 'required');
	$this->form_validation->set_rules('contrasena', 'Contraseña', 'required');
	$this->form_validation->set_rules('email', 'email', 'required');
	$this->form_validation->set_rules('nombre', 'nombre', 'required');
	$this->form_validation->set_rules('apellidos', 'apellidos', 'required');
	$this->form_validation->set_rules('dni', 'dni', 'required');
	$this->form_validation->set_rules('direccion', 'direccion', 'required');
	$this->form_validation->set_rules('provincia', 'provincia', 'required');

	if ($this->form_validation->run() == TRUE) {
			$this->Model_usuarios->registroUsuario(
				$this->input->post('nombre_usuario'),
				$this->input->post('contrasena'),
				$this->input->post('email'),
				$this->input->post('nombre'),
				$this->input->post('apellidos'),
				$this->input->post('dni'),
				$this->input->post('direccion'),
				$this->input->post('provincia')
		);
	   
		$this->session->set_userdata('usuario_id', $this->Model_usuarios->getUsuarioId($this->input->post('nombre_usuario')));
		$this->session->set_userdata('nombre', $this->Model_usuarios->getNombreUsuario($this->input->post('nombre_usuario')));
		$this->session->set_userdata('administrador', $this->Model_usuarios->getAdmin($this->input->post('nombre_usuario')));
		
		$datos['h2Inicial'] = 'Bienvenid@ '.$this->Model_usuarios->getNombreUsuario($this->input->post('usuario'));
		
		$this->load->view('plantilla', [
			'titulo' => 'Registro con éxito',
		//	'menu'=>  $this->load->view('Menu', $datos_categorias, true),
			//'cuerpo' => $this->load->view('Bienvenida',$datos,true),
			'cuerpo' => $this->load->view('RegistroHecho',$datos,true),
		]);
	} else {   
		$this->load->view('plantilla', [
			'titulo' => 'Registrar usuario',
			'cuerpo' => $this->load->view('RegistroUsuario',$datos_provincias, true)
		//	'cuerpo' => $this->load->view('RegistroUsuario',[], true)

		]);
	}
}
/**
     * Vuelca los datos del usuario en la vista EditaUsuario
     * @param type $usuario id del usuario
     */
    public function editaUsuario($usuario_id) {
		$this->load->model('Model_productos');
		$this->load->model('Model_usuarios');
		 
		$datos['usuario'] = $this->Model_usuarios->getUsuario($usuario_id);
		
		//$datos['usuario']=$this->Model_usuarios->datosUsuario(11);
        $this->load->view('plantilla', [
			'titulo' => 'Edita usuario',
			'cuerpo' => $this->load->view("EditaUsuario", $datos, TRUE)

		]);
	  }
	  
	  public function guardarEdicion(){
		$this->load->model('Model_productos');
		$this->load->model('Model_usuarios');

		//$this->form_validation->set_rules('nombre_usuario', 'nombre_usuario', 'required');
		$this->form_validation->set_rules('nombre_usuario', 'Nick o alias', 'required');
		$this->form_validation->set_rules('clave1', 'Contraseña 1', 'required|trim|min_length[5]');
		$this->form_validation->set_rules('clave2', 'Contraseña 2', 'required|trim|min_length[5]|matches[clave1]');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		$this->form_validation->set_rules('email', 'Correo', 'required|trim');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		
		$this->form_validation->set_message('required', 'Debe introducir el campo %s');
		$this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
		$this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
		$this->form_validation->set_message('matches', 'Los campos %s y %s no coinciden');
		  
		  
		  if ($this->form_validation->run() === true)
			{
			  $id = $this->session->userdata('id');
			  
			  $datos = array(
				  'nombre_usuario'=> $this->input->post('nombre_usuario'),
				  'contrasena' => password_hash($this->input->post('clave1'), PASSWORD_DEFAULT),
				  'nombre' => $this->input->post('nombre'),
				  'apellidos' => $this->input->post('apellidos'),
				  'email' => $this->input->post('email'),
				  'direccion' => $this->input->post('direccion'),
				  'provincia_id' => $this->input->post('provincia')
			  );
			  
			  
			  $this->Model_usuarios->modiUsuario($id, $datos);
			  $contenido['h2Inicial'] = 'Cambios realizados con exito';
			  $this->load->view('plantilla', [
				'titulo' => 'Edita usuario',
				'cuerpo' => $this->load->view("Bienvenida", $contenido, TRUE)
			  ]);
			}
		  else
			{
			  $errormsg= "";
			  $usuario_id = $this->session->userdata('usuario_id');
			//  $datos['usuario'] = $this->Model_usuarios->getUsuario($usuario_id);
			  $contenido['usuario']= $this->Model_usuarios->getUsuario($usuario_id);
			  $contenido['errores']=['error'=> $errormsg];
			  $this->load->view('plantilla', [
				'titulo' => 'Edita usuario',
				'cuerpo' => $this->load->view("EditaUsuario",$contenido, TRUE)
	
			]);
	
			}
		  
		


		

	  }

}