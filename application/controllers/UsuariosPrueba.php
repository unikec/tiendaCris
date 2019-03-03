<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuarios extends CI_Controller {

/**
     * Verifica que los datos del formulario cumple con las reglas de validacion e inserta el usuario
     */
    public function verificarRegistro()
      {
        $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim|is_unique[usuario.usuario]');
        $this->form_validation->set_rules('clave', 'Contraseña', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
        $this->form_validation->set_rules('dni', 'DNI', 'required|trim|valid_dni|is_unique[usuario.dni]');
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email|trim|is_unique[usuario.email]');
        $this->form_validation->set_rules('cp', 'CP', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('direccion', 'Direccion', 'required');
        
        $this->form_validation->set_message('required', 'Debe introducir el campo %s');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
        $this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
        $this->form_validation->set_message('valid_dni', 'El %s no es correcto');
        $this->form_validation->set_message('is_unique', 'El campo %s ya existe y no puede estar repetido');
        
        
        if ($this->form_validation->run() === true)
          {
            
            $datos = array(
                'usuario' => $this->input->post('usuario'),
                'clave' => password_hash($this->input->post('clave'), PASSWORD_DEFAULT),
                'nombre' => $this->input->post('nombre'),
                'apellidos' => $this->input->post('apellidos'),
                'dni' => $this->input->post('dni'),
                'email' => $this->input->post('email'),
                'direccion' => $this->input->post('direccion'),
                'cp' => $this->input->post('cp'),
                'provincia_id' => $this->input->post('provincia')
            );
            
            
            $this->musuario->insertarUsuario($datos);
            $cuerpo = $this->load->view("usuario_creado", "", TRUE);
            $this->cargaPlantilla($cuerpo, "");
          }
        else
          {
            $cuerpo = $this->load->view("registro", array(
                'error' => ""
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
          }
        
      }
    
    /**
     * Verifica que el login es correcto y carga el panel de usuarios
     */


    /** */
    public function verificarLogin()
      {
        
        $usuario  = $this->input->post('usuario');
        $clave    = $this->input->post('clave');
        $verifica = $this->musuario->loginCorrecto($usuario, $clave);
        
        if ($verifica == true)
          {
            $userdata = array(
                'usuario' => $this->input->post('usuario'),
                'logged_in' => TRUE,
                'id' => $this->musuario->obtenerDatoUsuario($usuario, 'id'),
                'nombre' => $this->musuario->obtenerDatoUsuario($usuario, 'nombre')
            );
            
            $this->session->set_userdata($userdata);
            $this->cargarVista('panel_usuario');
          }
        else
          {
            $cuerpo = $this->load->view("login", array(
                'error' => true
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
          }
        
      }
    
    /**
     * Carga la vista editar usuario con los datos que ese usuario tiene guardados actualmente
     * @param type $usuario Nombre de usuario
     */
    public function editaUsuario($usuario)
      {
        
        $datos  = $this->musuario->obtenerDatosUsuario($usuario);
        $cuerpo = $this->load->view("edita_usuario", array(
            'datos' => $datos
        ), TRUE);
        $this->cargaPlantilla($cuerpo, "");
      }
    
    /**
     * Verifica que los datos del formulario cumple con las reglas de validacion y modifica el usuario existente
     */
    public function verificarEdicion()
      {
        $this->form_validation->set_rules('clave1', 'Contraseña 1', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('clave2', 'Contraseña 2', 'required|trim|min_length[5]|matches[clave1]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
        $this->form_validation->set_rules('email', 'Correo', 'required|valid_email|trim');
        $this->form_validation->set_rules('cp', 'CP', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('direccion', 'Direccion', 'required');
        
        $this->form_validation->set_message('required', 'Debe introducir el campo %s');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s carácteres');
        $this->form_validation->set_message('valid_email', 'Debe escribir una dirección de email correcta');
        $this->form_validation->set_message('matches', 'Los campos %s y %s no coinciden');
        
        
        if ($this->form_validation->run() === true)
          {
            $id = $this->session->userdata('id');
            
            $datos = array(
                'clave' => password_hash($this->input->post('clave1'), PASSWORD_DEFAULT),
                'nombre' => $this->input->post('nombre'),
                'apellidos' => $this->input->post('apellidos'),
                'email' => $this->input->post('email'),
                'direccion' => $this->input->post('direccion'),
                'cp' => $this->input->post('cp'),
                'provincia_id' => $this->input->post('provincia')
            );
            
            
            $this->musuario->modificaUsuario($id, $datos);
            $cuerpo = $this->load->view("panel_usuario", array(
                'modificado' => true
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
          }
        else
          {
            $usuario = $this->session->userdata('usuario');
            $datos   = $this->musuario->obtenerDatosUsuario($usuario);
            $cuerpo  = $this->load->view("edita_usuario", array(
                'datos' => $datos,
                'error' => true
            ), TRUE);
            $this->cargaPlantilla($cuerpo, "");
          }
        
      }
    
    /**
     * Pone el campo baja como 1 y destruye la sesion
     * @param type $id ID del usuario
     */
    public function eliminaUsuario($id)
      {
        $this->musuario->bajaUsuario($id);
        $this->session->sess_destroy();
        redirect('Inicio');
      }
    
    public function recuperarClave()
      {
        $nueva = substr( md5(microtime()), 1, 8);
        
        $datos = array(
            "clave" => password_hash($nueva, PASSWORD_DEFAULT)
        );
        $email=$this->musuario->obtenerDatoUsuario($this->input->post('usuario'),'email');
		
        $this->musuario->modificaUsuario($this->musuario->obtenerDatoUsuario($this->input->post('usuario'),'id'), $datos);
        $this->email->from('aula4@iessansebastian.com', 'El carrito de Santiago');
        $this->email->to($email);
        $this->email->subject('Nueva clave para "El carrito de Santiago"');
        $this->email->message('Hola '.$this->input->post('usuario').', tu nueva contraseña es: ' . $nueva);
        
		if($this->email->send()){
				$cuerpo = $this->load->view("recuperar_clave", array(
					'enviado' => ''
				), TRUE);
				$this->cargaPlantilla($cuerpo, "");
		}else{
				$cuerpo = $this->load->view("recuperar_clave", array(
					'no' => ''
				), TRUE);
				$this->cargaPlantilla($cuerpo, "");
		}
		

		
      }
}