<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuarios extends CI_Controller {
/**
 * Nos lleva al inicio a la pantalla
 * de inicio de sesión, registro y recuperación de contraseña
 */
	public function index(){
        $this->load->model('Model_productos');

			$this->load->view('plantilla', [
					'titulo' => 'Inicio de sesion',
					'cuerpo' => $this->load->view('Login',[],true)
				]	);
	 }
/**
 * Comprueba el usuario ha introcido un nick y contraseñas 
 * correspondientes
 */
	public function logIn(){

		$this->load->model('Model_productos');
		$this->load->model('Model_usuarios');

		$this->form_validation->set_rules('usuario', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');              

		if ($this->Model_usuarios->logOK(
			$this->input->post('usuario'),
			$this->input->post('password'))&
			$this->form_validation->run() == TRUE) {			
			//con set_userdata() almacenamos las los datos necesarios de 
			$this->session->set_userdata('usuario_id', $this->Model_usuarios->getUsuarioId($this->input->post('usuario')));
			$this->session->set_userdata('nombre_usuario', $this->Model_usuarios->getNombreUsuario($this->input->post('usuario')));
			$this->session->set_userdata('administrador', $this->Model_usuarios->getAdmin($this->input->post('usuario')));
			$this->session->set_userdata('dentro',TRUE);///????
			
		/*	 $this->load->view('Plantilla', [
				'titulo' => 'Iniciando sesion',
				'cuerpo' => $this->load->view('Bienvenida',[],true)
			 ]);*/
			 redirect('Productos/index');

		} else {
			$errormsg= "";
			if ($this->form_validation->run() == TRUE) {
				$errormsg= "Error en usuario o contraseña";
			}
			$this->load->view('Plantilla', [
				'titulo' => 'Loging',
				//'menu'=>  $this->load->view('Menu', $datos_categorias, true),
				'cuerpo' => $this->load->view('Login',['error'=> $errormsg],true)
			 ]);
		}
	}

	/*hacer estaDentro()
return $this->session->userdata('dentro');
*/ 


	/**hacer cierraSession() 
 * $this->session->get_userdata('dentro', false);
*/
/**
 * Cierra la sesión activa
 * El método unset_userdata() elimina las entradas
 *  de cualquier período de sesiones
 */
	public function logOut(){
		$this->load->model('Model_productos');
		 
		$this->session->unset_userdata('usuario_id');
		$this->session->unset_userdata('nombre');
		$this->session->unset_userdata('administrador');
		$this->session->unset_userdata('dentro');

		redirect('Productos/index');
	}



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
	$this->form_validation->set_rules('cp', 'Código Postal', 'required');
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
				$this->input->post('cp'),
				$this->input->post('provincia')
		);
	   
		$this->session->set_userdata('usuario_id', $this->Model_usuarios->getUsuarioId($this->input->post('nombre_usuario')));
		$this->session->set_userdata('nombre', $this->Model_usuarios->getNombreUsuario($this->input->post('nombre_usuario')));
		$this->session->set_userdata('administrador', $this->Model_usuarios->getAdmin($this->input->post('nombre_usuario')));
		$this->session->set_userdata('dentro',TRUE);
		
		$datos['h2Inicial'] = 'Bienvenid@ '.$this->Model_usuarios->getNombreUsuario($this->input->post('usuario'));
		
		$this->load->view('plantilla', [
			'titulo' => 'Registro con éxito',
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
	  /**
		 * Guardar los cambios efectuados en la cuenta
		 */
	  public function guardarEdicion(){
		$this->load->model('Model_productos');
		$this->load->model('Model_usuarios');

		//$this->form_validation->set_rules('nombre_usuario', 'nombre_usuario', 'required');
		$this->form_validation->set_rules('nombre_usuario', 'Nick o alias', 'required');
		$this->form_validation->set_rules('clave1', 'Contraseña 1', 'required|trim|min_length[2]');
		$this->form_validation->set_rules('clave2', 'Contraseña 2', 'required|trim|min_length[2]|matches[clave1]');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		$this->form_validation->set_rules('email', 'Correo', 'required|trim');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('cp', 'Codigo Postal', 'required');
		
		$this->form_validation->set_message('required', 'Debe introducir el campo %s');
		$this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
		$this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
		$this->form_validation->set_message('matches', 'Los campos %s y %s no coinciden');
		  
		  
		  if ($this->form_validation->run() === true)
			{
			  $id = $this->session->userdata('usuario_id');
			  
			  $datos = array(
				  'nombre_usuario'=> $this->input->post('nombre_usuario'),
				  'contrasena' => password_hash($this->input->post('clave1'), PASSWORD_DEFAULT),
				  'nombre' => $this->input->post('nombre'),
				  'apellidos' => $this->input->post('apellidos'),
				  'email' => $this->input->post('email'),
					'direccion' => $this->input->post('direccion'),
				  'cp' => $this->input->post('cp'),					
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
	
			]);}

		}
		/**
		 * Borra los datos relativos a ese cliente
		 */
		public function eliminaCuenta($id) {
			$this->load->model('Model_productos');
	   	$this->load->model('Model_usuarios');

        $this->Model_usuarios->borrarUsuario($id);
        $this->session->sess_destroy();
        redirect('Productos/index');
			}
			

			/**
			 * Nos lleva a la vista donde se recogen los datos necesarios
			 * para poder ver restaurar la clave
			 */
			public function nuevaClave(){
				$this->load->model('Model_productos');
				$this->load->model('Model_usuarios');
				
				$datos['h2Inicial']='';
				$this->load->view('plantilla', [
					'titulo' => 'Restaurando clave',
					'cuerpo' => $this->load->view("NuevaClave",$datos, TRUE)
					]);
			}

			/**
			 * Se tiene que crear una nueva clave y entregarla por un medio seguro
			 * a un correo electronico proporcionado por el usuario cuando se registró
			 */
			public function recuperarClave()
      {
				$this->load->library('email','','correo');
				$this->load->model('Model_productos');
				$this->load->model('Model_usuarios');

        $nueva = substr( md5(microtime()), 1, 8);//cosntruyo una nueva contraseña en base a la fecha y hora
        
				$datos = array("contrasena" => password_hash($nueva, PASSWORD_DEFAULT));
				
        $email=$this->Model_usuarios->getEmailUsuario($this->input->post('usuario'));
				$usuario_id=$this->Model_usuarios->getUsuarioId($this->input->post('usuario'));

				$this->Model_usuarios->modiUsuario($usuario_id,$datos);
				
        $this->correo->from('tiendacrist@gmail.com', 'Copi Billy Papper');
        $this->correo->to($email);
        $this->correo->subject('Recuperación de clave');
        $this->correo->message('Hola '.$this->input->post('usuario').', su nueva contraseña es: ' . $nueva);
        
		if($this->correo->send()){
			$datos['h2Inicial']='Correo de recuperación enviado satisfactoriamente';
				$this->load->view('plantilla', [
					'titulo' => 'Recuperación de clave exitosa',
					'cuerpo' => $this->load->view("NuevaClave", $datos, TRUE)
					]);
		}else{
			$datos['h2Inicial']='Lo sentimos pero se ha producido un error y no se ha podido mandar el correo, intentelo de nuevo más tarde';
				$this->load->view('plantilla', [
					'titulo' => 'Recuperación de clave Fallida',
					'cuerpo' => $this->load->view("NuevaClave", $datos, TRUE)
					]);
		}		
	}//end funcionRecupera Clave
	


}