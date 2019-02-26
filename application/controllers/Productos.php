<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class productos extends CI_Controller {

    public function index($desde=0) {
        // $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->model('Model_productos');
        
        /* URL a la que se desea agregar la paginación*/
        $config['base_url'] = base_url() . 'index.php/Productos/index/';
        
        /*Obtiene el total de registros a paginar */
        $config['total_rows'] = $this->Model_productos->numeroDestacados();
        
        /*Obtiene el numero de registros visibles por pagina */
        $config['per_page'] = '3';
        
        /*Indica que segmento de la URL tiene la paginación, por default es 3*/
        // $config['uri_segment'] = '3';// al tres está por defecto por eso puedo lo puedo comentar
        
        /* Se inicializa la paginacion*/
        $this->pagination->initialize($config);    
        $datos['h2Inicial'] = 'Productos destacados';
        $datos['productos'] = $this->Model_productos->productosDestacados($desde, $config['per_page']);
        //$datos['productos'] = $this->Model_productos->productosDestacados();
        //$datos_categorias['categorias'] = $this->Model_productos->getCategorias();
        $datos['pag']= $this->pagination->create_links();
        
        //cargo la vista pasando los datos de configuacion
        $this->load->view('Plantilla', [
            'titulo' => 'productos destacados',
          //  'menu' => $this->load->view('Menu', $datos_categorias, true),
            'cuerpo' => $this->load->view('Listado_articulos', $datos, true),
        ]);
    }

    public function mostrarCategorias($catId, $desde=0) {
  
        $this->load->model('Model_productos');
        $this->load->library('pagination');       
        $config['base_url'] = base_url() . 'index.php/Productos/MostrarCategorias/index';
        $config['total_rows'] = $this->Model_productos->numeroProductosPorCategoria($catId);
        $config['per_page'] = '3';//quiero que se muestren 3 articulos por pagina
        $config['uri_segment'] = '4';
        
        /* Se inicializa la paginacion*/
        $this->pagination->initialize($config);
        $datos['titulo'] = $this->Model_productos->categoriaNombre($catId);
        $datos['h2Inicial'] = $this->Model_productos->descripcionCategoria($catId);
        $datos['productos'] = $this->Model_productos->getProductosPorCategoriaPaginados($catId, $desde, $config['per_page']);
        $datos['pag']= $this->pagination->create_links();
        
        $this->load->view('Plantilla', [
            'titulo' => $datos['titulo'],
            'cuerpo' => $this->load->view('Listado_articulos', $datos, true),
        ]);
    }

    public function mostrarDetalle($prodId) {
        //$this->load->helper('url'); //ya lo tengo en el autoload
        $this->load->model('Model_productos'); //cargo el modelo

        $datos_titulo['titulo'] = $this->Model_productos->productoNombre($prodId);
        $datos['h2Inicial'] = $this->Model_productos->productoNombre($prodId);
        $datos['producto'] = $this->Model_productos->getProducto($prodId);
       

        $this->load->view('Plantilla', [
            'titulo' => $datos_titulo['titulo'],
            'cuerpo' => $this->load->view('DetalleProducto', $datos, true),
        ]);
    }
    public function verCarrito() {
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->library('cart');

        $datos['h2Inicial'] = 'Mi cesta';
        $datos['productosCarrito'] = $this->cart->contents();
       // $datos['total'] = $this->cart->total();//el total de cart no tiene encuenta los descuentos
        $datos['totales'] = $this->Model_productos->totalCompra($datos['productosCarrito']);
    
        $this->load->view('Plantilla', [
            'titulo' => 'confirmar pedido',            
            'cuerpo' => $this->load->view('Carrito', $datos, true),]);
    }

    
    /**
     * Añade producto seleccionado desde la vista de ListaArticulos
     * o desde la vista DetalleProducto
     * @param type $id
     */
    public function addProducto($id, $otro=FALSE) {
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->library('cart');
        if($otro){
          $cantidad= $this->input->post('cantidad');  
        }else{
            $cantidad=1;
        }
        $producto = $this->Model_productos->getProducto($id);   
        $data = array(//cogemos los productos en un array para insertarlos en el carrito
            'id' => $id,
            'imagen'=> $producto->imagen,
            'qty' => $cantidad, //la cantidad que se está comprando
            'price' => $producto->precio,
            'descuento'=> $producto->descuento,
            'name' => $producto->nombre); 
  
        $this->cart->insert($data); //introduzco el articulo en el carrito
        $this->verCarrito();
    }
           
        
        
        /**
         * Borra toda la informacion contenida en el carrito
         */
        public function eliminarCarrito() {
        $this->load->library('cart');
        $this->cart->destroy();
        $this->verCarrito();
        }
        
        
        /**
         * Tomamos el idrow que identifica cada producto diferente del carrito y dejamos la cantidad a cero 
         * para eliminarlo de la cesta
         * @param type $rowid
         */
        public function eliminarProducto($rowid) { 
        $this->load->library('cart');
       /* $data  =  array ( 
        'rowid'  =>  $rowid, 
        'qty'    => 0,
        );
        $this->cart->update($data);*/
        $this->cart->remove($rowid);
        $this->verCarrito();
        }
        
        public function prueba(){
              $this->load->model('Model_productos'); //cargo el modelo
              $this->load->library('cart');
              $cesta=$this->cart->contents();
            /*  $datos['id'] = $this->Model_productos->idsCesta($cesta);
              $datos['idCanti'] = $this->Model_productos->idProdCantiCesta($cesta);*/
              $datos['totalCompra']=$this->Model_productos->totalCompra($cesta);
              $id=6;
              $cantidad=2;
              $datos['precioDB']= $this->Model_productos->productoPrecio($id);
              $datos['descuento']=$this->Model_productos->aplicaDescuento($id);
              $datos['subTotal']=$this->Model_productos->subTotal($datos['descuento'],$cantidad);
              $datos['ivaSubTotal']=$this->Model_productos->ivaProductoSubTotal($id,$datos['subTotal']);
              

             // $datos['ivaProd']=$this->Model_productos->ivaProductoTotal($id, );
               $this->load->view('Plantilla', [
                  //  'titulo' => $datos_titulo['titulo'],
                    'cuerpo' => $this->load->view('prueba', $datos, true),
        ]);
        }
}
