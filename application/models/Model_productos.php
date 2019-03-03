<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class model_productos extends CI_Model {

    public function __construct() { // son 2 barras bajas _ _ juntitas
        $this->load->database();
    }
/**
 * Devuelve todos los productos de la BBDD
 * @return type $productos 
 */
    public function getProductos() {

        $productos = $this->db->get('producto');
        return $productos;
    }

    /**
     * Devuelve los productos detacados siempre y cuando las fechas coincidan
     * @return type
     */
    public function productosDestacados($desde, $por_pagina) { 
        // $query  = ("select * from producto where destacado=1 and visible=1 and finicio_dest<=CURDATE() and ffin_dest>=CURDATE() LIMIT $desde,$por_pagina");
        $query = ("select * from producto where destacado=1 and visible=1 and finicio_dest<=CURDATE() and ffin_dest>=CURDATE() LIMIT $desde,$por_pagina");

        $prodes = $this->db->query($query);
        return $prodes->result(); //No usar result array, si en la vista quiero usar un foreach normalito
        //return $prodes->result_array();
    }

    /**
     * Busca cuantos artículos se puede considerar como destacados
     * @return type el numero total de registros
     */
    public function numeroDestacados(){
            $query = "select * from producto where destacado=1 and visible=1 and finicio_dest<=CURDATE() and ffin_dest>=CURDATE()";
            $npro  = $this->db->query($query);
            return $npro->num_rows();
    }
    /**
     * Devuelve toda la información de un producto dado su ID
     * @param type $prodId
     * @return type
     */
    public function getProducto($prodId) {
        $produ = $this->db
                ->from('producto')
                ->where('producto_id', $prodId)
                ->get();
        //$produ =$this->db->get('producto');
        return $produ->row();
    }

    /**
     * Devuelve la descrición del producto seleccionado
     * @param type $prodId
     * @return type
     */
    public function descripcionProducto($prodId) {
        $rs = $this->db //rs=resultado
                ->select('descripcion')
                ->from('producto')
                ->where('producto_id', $prodId)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->descripcion;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

    /**
     * Devuelve el Nombre del producto seleccionado
     * @param type $prodId
     * @return type
     */
    public function productoNombre($prodId) {
        $rs = $this->db //rs=resultado
                ->select('nombre')
                ->from('producto')
                ->where('producto_id', $prodId)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->nombre;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

    /**
     * Obtiene el precio de un producto dado su id
     * @param type $prodId
     * @return string
     * 
     */
    public function productoPrecio($prodId) {
        $rs = $this->db //rs=resultado
                ->select('precio')
                ->from('producto')
                ->where('producto_id', $prodId)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->precio;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

    /**
     * Saca los nombres de todas las categorias
     * @return type
     * visible=1 --> visible ok
     * visible =0 --> no visible 
     */
    public function getCategorias() {
        $query = $this->db->query('select * from categorias where visible=1');
        return $query->result();
    }

    
    /**
     * Saca productos por categorias
     * @param type $catId
     * @return type
     */
    public function getProductosPorCategoria($catId) {

        $query = $this->db->query("select * from producto where categoria_id='$catId' and visible=1");
        $productos = $query->result();
        return $productos;
    }
    
    /**
     * Saca productos por categorias adecuados para paginar
     * @param type $catId es el numero de la categoria seleccionada
     * @param type $desde indica el desde tiene que dar resultados
     * @param type $por_pagina el tope o limite
     * @return type un array de productos
     */
    public function getProductosPorCategoriaPaginados($catId, $desde, $por_pagina) {

        $query = $this->db->query("select * from producto where categoria_id='$catId' and visible=1 LIMIT $desde,$por_pagina");
        $productos = $query->result();
        return $productos;
    }
    /**
     * Ofrece el numero de productos por Categoria
     * @param type $catId es el id de la categoria
     * @return type el numero de productos
     */
    public function numeroProductosPorCategoria($catId) {

        $query = ("select * from producto where categoria_id='$catId' and visible=1");
        $numProductos = $this->db->query($query);
        return $numProductos->num_rows();
    }

    /**
     * Devuelve el nombre de la categoría dado su id
     * @param type $id
     * @return string
     */
    public function categoriaNombre($id) {
        $rs = $this->db //rs=resultado
                ->select('nombre')
                ->from('categorias')
                ->where('categoria_id', $id)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->nombre;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

    /**
     * Función que me devuelva la descripción del contenido de una categoria
     * 
     */
    public function descripcionCategoria($id) {
        $rs = $this->db //rs=resultado
                ->select('descripcion')
                ->from('categorias')
                ->where('categoria_id', $id)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->descripcion;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

    /**
     * Crea una nueva categoria
     * @param type $id
     * @param type $nombre
     * @param type $descripcion
     * @param type $anuncio
     * @param type $visible
     */
    public function insertCategoria($id, $nombre, $descripcion, $anuncio, $visible) {
        $datos = array(//
            'categoria_id' => $id,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'anuncio' => $anuncio,
            'visible' => $visible
        );
        $this->db->insert('categoria', $datos);
    }

    /**
     * Calcula el precio final del producto, tras la aplicación del descuento correspondiente
     * @param type $id
     * @return string
     */
    public function aplicaDescuento($id) { //si funciona
        $producto = $this->getProducto($id);
        if ($producto) {
            //print_r($producto);
            $des = $producto->descuento;
            $pre = $producto->precio;

            $porcentajeDescuento = $des / 100;
            $precioFin = $pre - ($pre * $porcentajeDescuento);
            return $precioFin;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }
    
    /**
     * Calcula el total a pagar por producto introducido
     * teniendo en cuenta su posible descuento y cantidad seleccionada
     * @param type $precioPostDescuento
     * @param type $cantidad
     * @return type
     */
    public function subTotal($precioPostDescuento, $cantidad) {//si funciona
        $subT = $precioPostDescuento * $cantidad;
        return $subT;
    }
    
    /**
     * 
     * @param type $id
     * @param type $subTotal
     * @return string
     */
    public function ivaProductoSubTotal($id, $subTotal) { //si funciona
        $rs = $this->db //rs=resultado
                ->select('iva')
                ->from('producto')
                ->where('producto_id', $id)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            //para saber la base pillo el iva/100 y luego le sumo 1= 1*21 que será el divisor
            $divisor= 1+($reg->iva/100);                    //redondeo de dos digitos al alza
            $baseImponible = round(($subTotal / $divisor), 2,PHP_ROUND_HALF_DOWN) ;
           // $baseImponible = $precioPostDescuento / (1 * $reg->iva) ;//sin el redondeo
            return ($subTotal - $baseImponible) ;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

   /**
    * Calcula el total de la compra y el toda del iva desglosado
    * @param type $productosCarrito
    * @return type
    */
     public function totalCompra($productosCarrito) { //SI  funciona
        $info=[];
        $sumaCompra=0;
        $sumaIVA=0;
        foreach ($productosCarrito as $producto) {
            $precioConDescuento= $this->aplicaDescuento($producto['id']);
            $subT= $this->subTotal($precioConDescuento, $producto['qty']);
            $subTIVA= $this->ivaProductoSubTotal($producto['id'], $subT);
            $sumaCompra += $subT;
            $sumaIVA += $subTIVA;

        }
        return $info=array('aPagar'=>$sumaCompra, 'desgloseIVA'=>$sumaIVA);
    }
    
    
   

}