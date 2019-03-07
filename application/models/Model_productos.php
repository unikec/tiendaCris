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
    public function productoImg($prodId) {
        $rs = $this->db //rs=resultado
                ->select('imagen')
                ->from('producto')
                ->where('producto_id', $prodId)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->imagen;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }

    /**
     * Directamente saco el stock de un determinado producto
     */
    public function getStock($prodId) {
        $rs = $this->db //rs=resultado
                ->select('stock')
                ->from('producto')
                ->where('producto_id', $prodId)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg->stock;
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
        $datos = array(
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

/**
 * Comprueba  si hay el suficiente stock de un articulo
 */
    public function comprobarStock($idArti, $canti){
        $rs = $this->db //rs=resultado
                ->select('stock')
                ->from('producto')
                ->where('producto_id', $idArti)
                ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            if($reg->stock>=$canti){
                return true;
            }else{
                return false;
            }
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
        
    }

    /**
     * Comprobar el stock de todo el carrito e informar del problema
     */
    public function comprobarStockCarrito($carrito){
        $mensaje="";
        foreach ($carrito as $producto) {
            if(!$this->comprobarStock($producto['id'],$producto['qty'])){
                $mensaje .= "no hay Stock suficiente del producto ".$producto['name']."<br>";
            }else{
                $mensaje .= "";//si está vacio es que hay stock suficiente de todo lo que ha seleccionado
            }
        }
        return $mensaje;

    }
    /**
     * Nos devuelve todos los pedidos realizados por el usuario_id
     */
    public function getPedidos($id) {
        $query = "select * from pedido where usuario_id=" . $id . "";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function ultimoPedido($usuarioID){
        //SELECT MAX(pedido_id) AS pedido_id FROM pedido WHERE usuario_id=12
        $query="SELECT MAX(pedido_id) AS pedido_id FROM pedido WHERE usuario_id=$usuarioID ";
        $query = $this->db->query($query);
       // return $query->result();
        return $query->row()->pedido_id;

    }

    /**
     * Por cada articulo del carrito creo una linea de pedido
     * así almaceno toda la información relativa a la compra
     */
  /*  public function guardarLineaPedido($datos){

          $this->db->insert('linea_pedido', $datos); 
    }*/



/**
 * Por cada una de las lineas de pedido de un usuario en la misma fecha
 * vamos insertado campos en el pedido
 */
    public function registraPedido($productosCarrito, $pedido_id){

       // print_r($pedido_id);
        foreach ($productosCarrito as $producto) {
            $imagen=$this->productoImg($producto['id']);
            $nombre=$this->productoNombre($producto['id']);
            $precioConDescuento= $this->aplicaDescuento($producto['id']);           
            $subT= $this->subTotal($precioConDescuento, $producto['qty']);
        
            $linea= array(
                'producto_id'=>$producto['id'],
                'cantidad'=>$producto['qty'],
                'importe'=>$subT,
                'nombre_producto'=>$nombre,
                'imagen_producto'=>$imagen,
                'pedido_id'=>$pedido_id
            );
          $this->db->insert('linea_pedido', $linea); 
         // $this->guardarLineaPedido($linea);
        }
    }

    /**
     * Nos devuelve todas las lineas de pedido pertenecientes a una misma compra
     */
    public function getLineasPedido($idPedido){
        $query = "select * from linea_pedido where pedido_id=" . $idPedido . "";
        $query = $this->db->query($query);
        return $query->result();
    }

    
     /**
      * Modifica el estock del producto en función de la cantidad vendida del articulo
      */
    public function ventaProducto($idProducto, $cantidad, $stockPrevioVenta){
        $nuevoStock= $stockPrevioVenta- $cantidad ;
        $data = array(
            'producto_id' => $idProducto,
            'stock' => $nuevoStock);
    
        $this->db->where('producto_id', $idProducto);
        $this->db->update('producto', $data);
    }

    public function modificaStockCarrito($cesta){
        foreach ($cesta as $producto) {
            $stockPrevio=$this->getStock($producto['id']);
            $this->ventaProducto($producto['id'],$producto['qty'],$stockPrevio);            # code...
        }

    }
 

    /**
     * Tras la anulación del un pedido pendiente 
     * de procesar, los articulos no se han logrado 
     * vender, por lo tanto hay que restaurar el stock
     * a la situación inicial
     */
    public function devolucionProducto($productoID, $cantidadDevuelta, $stockPostVenta){
        $nuevoStock= $cantidadDevuelta + $stockPostVenta;
        $data = array(
            'producto_id' => $productoID,
            'stock' => $nuevoStock);
    
        $this->db->where('producto_id', $productoID);
        $this->db->update('producto', $data);
    }

    /**
     * Cambia el estado del pedido
     */
    public function cambiaEstadoPedido($idPedido, $nuevoEstado){
        $data = array(
            'estado' => $nuevoEstado);    
        $this->db->where('pedido_id', $idPedido);
        $this->db->update('producto', $data);

    }
    /**
     * Estado Inicial: PENDIENTE de procesar  (este estado se puede ANULAR)
     * Cuando se ha enviado: PROCESADO
     * Se ha realizado la entrega del pedido: RECIBIDO
     */
    public function aclaraEstado($estado){
        switch (strtoupper($estado))
        {
            case 'C':
                return 'Cancelado';
                break;
            case 'P':
                return 'Pendiente';
                break;
            case 'E':
                return 'Enviado';
                break;
            case 'R':
                return 'Recibido';
                break;
        }
    }

    public function getEstadoPedido($idPedido){
        $rs = $this->db //rs=resultado
        ->select('estado')
        ->from('pedido')
        ->where('$pedido_id', $idPedido)
        ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            $reg->estado;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
    }
    /**
     * Obtener los datos de un pedido
     * @param String $id ID de usuario
     */
    public function getPedido($id){
        $rs = $this->db
        ->from('pedido')
        ->where('pedido_id', $id)
        ->get();
        $reg = $rs->row(); //reg = registro de resultado
        if ($reg) { //en el caso de obtener dato a la consulta
            return $reg;
        } else { //en el caso de no obtener ningun resultado a la consulta
            return '';
        }
      }

      public function creaPedido($datosCliente){
          $datos="";
         //S print_r($datosCliente->usuario_id);
          //foreach ($datosCliente as $info) {
            //echo $info['usuario_id'];
              $datos=array(                 
                  'usuario_id' => $datosCliente->usuario_id,
                  'nombre_usuario_pedido' => $datosCliente->nombre,
                  'apellidos_pedido' => $datosCliente->apellidos,
                  'dni_pedido' => $datosCliente->dni
                );
         // }
          $this->db->insert('pedido', $datos);        
      }

      /**No se visualiza el carrito vacio */
      public function eliminarCarritoSolo()
      {
          $this->load->library('cart');
          $this->cart->destroy();
      }

      public function totalPedido($idPedido){
        $lineas= $this->getLineasPedido($idPedido);
        $total=0;
        foreach ($lineas as $col) {
            $total += $col->importe;            
        }
        return $total;
      }
      
   

}