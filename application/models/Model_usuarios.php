<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class model_usuarios extends CI_Model {

    public function __construct() { 
        $this->load->database();
    }

    public function logOk($usuario, $password)
    {
        $rs = $this->db
            ->select('nombre_usuario, contraseña')
            ->from('usuario')
            ->where('nombre_usuario', $usuario)
            ->where('contraseña', $password)
            ->get();

        $reg= $rs->row();
        if ($reg) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function registroUsuario($nombre_usuario, $contraseña, $email, $nombre, $apellidos, $dni, $direccion, $provincia){
        $datosUsuario = array(
            'usuario_id' => null,
            'nombre_usuario' => $nombre_usuario,
            'contraseña' => $contraseña,
            'email' => $email,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'dni' => $dni,
            'direccion' => $direccion,
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
}

