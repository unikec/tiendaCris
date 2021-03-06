<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class model_usuarios extends CI_Model {

    public function __construct() { 
        $this->load->database();
    }
/**
 * Comprueba que el nick y la contraseña introducidos coinciden
 * con lo almacenado en la BBDD
 */
    public function logOk($usuario, $password)
    {
       // echo 'Has entrado en logOk';
       /* echo $usuario;
        echo $password;*/
        $rs = $this->db
            ->from('usuario')
            ->where('nombre_usuario', $usuario)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            //echo 'hay coincidencia con la base de datos';
            if(password_verify($password, $reg->contrasena))
            {
                $data=array('user_data'=>array(
                    'nombre'=>$reg->nombre_usuario,
                    'id'=>$reg->usuario_id,
                    'mail'=>$reg->email,
                    'password'=>$reg->contrasena)
                );
                $this->session->set_userdata($data);
                return true;
            }
            else{
            //echo ' ha fallado el verify';
            }
        }
        else {
            $this->session->unset_userdata('user_data');
            return false;
            //echo 'algo ha fallado ';
        }
    }


   //'clave' => password_hash($this->input->post('clave'), PASSWORD_DEFAULT),
    //$password_hash=password_hash([LACONTRASEÑA], PASSWORD_BCRYPT);

    /**
     * Creación de nuevo usuario con seguridad en la clave 
     */
    public function registroUsuario($nombre_usuario, $contrasena, $email, $nombre, $apellidos, $dni, $direccion,$cp, $provincia){
        $datosUsuario = array(
            'usuario_id' => null,
            'nombre_usuario' => $nombre_usuario,
            'contrasena' => password_hash($contrasena,PASSWORD_DEFAULT),
            'email' => $email,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'dni' => $dni,
            'direccion' => $direccion,
            'cp'=>$cp,
            'provincia_id' => $provincia
    );
    
    $this->db->insert('usuario', $datosUsuario);
       
    }
    

    public function getUsuarioId($usuario){
        $rs = $this->db
            ->select('usuario_id')
            ->from('usuario')
            ->where('nombre_usuario', $usuario)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            return $reg->usuario_id;
        }
        else {
            return '';
        }
    }
    public function getEmailUsuario($usuario){
        $rs = $this->db
            ->select('email')
            ->from('usuario')
            ->where('nombre_usuario', $usuario)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            return $reg->email;
        }
        else {
            return '';
        }
    }
    public function getEmailUsuarioPorID($usuario_id){
        $rs = $this->db
            ->select('email')
            ->from('usuario')
            ->where('usuario_id', $usuario_id)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            return $reg->email;
        }
        else {
            return '';
        }
    }

    public function getNombreUsuario($usuario){
        $rs = $this->db
            ->select('nombre')
            ->from('usuario')
            ->where('nombre_usuario', $usuario)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            return $reg->nombre;
        }
        else {
            return '';
        }
    }
      /**
     * Obtiene todos los datos de un usuario
     * @param type $usuarios usuario_id
     * @return type datos del usuario en forma de array
     */
     public function getUsuario($id) {
        $rs = $this->db
                ->from('usuario')
                ->where('usuario_id', $id)
                ->get();  
        $reg= $rs->row();
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
     } 

    public function getAdmin($usuario){
        $rs = $this->db
            ->select('administrador')
            ->from('usuario')
            ->where('nombre_usuario', $usuario)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            if ($reg->administrador) {
                return 'Si';
            } else {
                return 'No';
            }
            
        }
        else {
            return '';
        }
    }

    public function getProvincias() {
        $rs = $this->db->get('provincias');
        return $rs->result();
    }
     /**
     * Devuelve la lista de las provincias especial para la funcion dropdow
     * @return type Array de provincias
     */
    public function provinciasDropDown()
    {
        $query      = $this->db->query("SELECT * FROM provincias ORDER BY nombre ASC");
        $result     = $query->result_array();
        $provincias = array();
        for ($i = 0; $i < count($result); $i++) {
            $provincias[$result[$i]["provincia_id"]] = $result[$i]["nombre"];
        }
        return $provincias;
    }

     /**
     * Cambia los datos del usuario 
     * @param type $datos los cambios introducidos por el usuario
     */
    public function modiUsuario($id, $datos)
    {
        $this->db->where('usuario_id', $id);
        $this->db->update("usuario", $datos);
    }

    /**
     * Borrado de datos el usuario que lo solicita
     */
    public function borrarUsuario($id){
    //DELETE FROM usuario WHERE 0
        $this->db->query("DELETE FROM usuario WHERE usuario_id='$id'");
    }


    /**
     * FUNCION PARA CREAR UNA CLAVE ALEATORIA 
     */
    function randomText($length) {  
        $key="";
        $pattern = "123456789PIUYTREWQASDFGHJKLMNBVCXZ123456789PLMK1IJNBHUYGVC123456789FTRDXZSEWAQWSDERFTGYHUJ123569876543ERDFREDESWQASWQASDGHGTY";  
        for($i=0;$i<$length;$i++) {  
          $key .= $pattern{rand(0,35)};  
        }  
        return $key;  
    } 

    /**
 * Para comprobar si el usuario está autenticado o no
 */
	public function estaLogueado(){
		if($this->session->userdata('dentro')){
			return true;
		}
		  return false;
    }
    
}

