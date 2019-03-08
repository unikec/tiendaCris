<?php

defined('BASEPATH') or exit('No direct script access allowed');

class productos extends CI_Controller
{

    public function index($desde = 0)
    {
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
        $datos['pag'] = $this->pagination->create_links();

        //cargo la vista pasando los datos de configuacion
        $this->load->view('Plantilla', [
            'titulo' => 'productos destacados',
            'cuerpo' => $this->load->view('Listado_articulos', $datos, true),
        ]);
    }

    public function mostrarCategorias($catId, $desde = 0)
    {

        $this->load->model('Model_productos');
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/Productos/mostrarCategorias/index';
        $config['total_rows'] = $this->Model_productos->numeroProductosPorCategoria($catId);
        $config['per_page'] = '3'; //quiero que se muestren 3 articulos por pagina
        $config['uri_segment'] = '4';

        /* Se inicializa la paginacion*/
        $this->pagination->initialize($config);
        $datos['titulo'] = $this->Model_productos->categoriaNombre($catId);
        $datos['h2Inicial'] = $this->Model_productos->descripcionCategoria($catId);
        $datos['productos'] = $this->Model_productos->getProductosPorCategoriaPaginados($catId, $desde, $config['per_page']);
        $datos['pag'] = $this->pagination->create_links();

        $this->load->view('Plantilla', [
            'titulo' => $datos['titulo'],
            'cuerpo' => $this->load->view('Listado_articulos', $datos, true),
        ]);
    }

    public function mostrarDetalle($prodId)
    {
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
    public function verCarrito()
    {
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->library('cart');

        $datos['h2Inicial'] = 'Mi cesta';
        $datos['productosCarrito'] = $this->cart->contents();
        // $datos['total'] = $this->cart->total();//el total de cart no tiene encuenta los descuentos
        $datos['totales'] = $this->Model_productos->totalCompra($datos['productosCarrito']);

        $this->load->view('Plantilla', [
            'titulo' => 'confirmar pedido',
            'cuerpo' => $this->load->view('Carrito', $datos, true)]);
    }

    /**
     * Añade producto seleccionado desde la vista de ListaArticulos
     * o desde la vista DetalleProducto
     * @param type $id
     */
    public function addProducto($id, $otro = false)
    {
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->library('cart');
        if ($otro) {
            $cantidad = $this->input->post('cantidad');
        } else {
            $cantidad = 1;
        }
        $producto = $this->Model_productos->getProducto($id);
        $data = array( //cogemos los productos en un array para insertarlos en el carrito
            'id' => $id,
            'imagen' => $producto->imagen,
            'qty' => $cantidad, //la cantidad que se está comprando
            'price' => $producto->precio,
            'descuento' => $producto->descuento,
            'name' => $producto->nombre);

        $this->cart->insert($data); //introduzco el articulo en el carrito
        $this->verCarrito();
    }

    /**
     * Borra toda la informacion contenida en el carrito
     */
    public function eliminarCarrito()
    {
        $this->load->library('cart');
        $this->cart->destroy();
        $this->verCarrito();
    }
    

    /**
     * Tomamos el idrow que identifica cada producto diferente del carrito y dejamos la cantidad a cero
     * para eliminarlo de la cesta
     * @param type $rowid
     */
    public function eliminarProducto($rowid)
    {
        $this->load->library('cart');
        /* $data  =  array (
        'rowid'  =>  $rowid,
        'qty'    => 0,
        );
        $this->cart->update($data);*/
        $this->cart->remove($rowid);
        $this->verCarrito();
    }

    /*    public function prueba(){
    $this->load->model('Model_productos'); //cargo el modelo
    $this->load->library('cart');
    $cesta=$this->cart->contents();
    /*  $datos['id'] = $this->Model_productos->idsCesta($cesta);
    $datos['idCanti'] = $this->Model_productos->idProdCantiCesta($cesta);*/
    /*    $datos['totalCompra']=$this->Model_productos->totalCompra($cesta);
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
    }*/
    /**
     * Devuelve una vista con la lista de los pedidos que tiene el usuario.
     * @param type $id ID del usuario
     */
    public function totalPedidos($id)
    {
        $this->load->model('Model_productos');

        $datos = $this->Model_productos->getPedidos($id);
        $this->load->view('Plantilla', [
            'titulo' => 'Pedido realizados',
            'cuerpo' => $this->load->view('Pedidos', $datos, true)]);
    }

    public function pdfPedido($idPedido){
      //  echo('hola el id del pedido es '.$idPedido);
        $this->load->library('cart');
        
        $this->load->library('email', '', 'correo');
        $this->load->model('Model_fpdf');
        $this->load->model('Model_productos');

        $datosPedido= $this->Model_productos->getPedido($idPedido);
        $lineasPedido= $this->Model_productos->getLineasPedido($idPedido);
       
        $pdf = new FactPDF();
        $pdf->AddPage("P");

        $pdf->datosCliente($datosPedido);
        $header = ["nombre","cantidad", "subtotal"];
        $pdf->tabla($header, $lineasPedido);
        $pdf->Output("F");//lo guardo con le nombre por defecto Doc.pdf

        $email = $this->Model_usuarios->getEmailUsuarioPorID($datosPedido->usuario_id);
        $this->correo->from('tiendacrist@gmail.com', 'Copi Billy Papper');
        $this->correo->to($email);
       // $this->correo->to('garcasriz@gmail.com');

        $this->correo->subject("Detalle de su pedido en Copi Bily Paper");
        $this->correo->attach('doc.pdf', 'inline');//$this->correo->attach(base_url().'img/prueba.txt');
        //$msg = $CI->load->view('email/vista', $data, true);
                $cesta = $this->cart->contents();
                $datos['pedido'] = $this->Model_productos->getPedido($idPedido);
                $datos['lineas'] = $this->Model_productos->getLineasPedido($idPedido);
                $datos['totales'] = $this->Model_productos->totalCompra($cesta);
        $mensaje= $this->load->view('DetallePedido', $datos, true);
       
        $this->correo->message($mensaje);
        $this->correo->set_header('Content-Type', 'text/html');

        $this->correo->set_mailtype('HTML');
       // $this->correo->message("En el documento adjunto podrá visualizar el contenido de su pedido");

        if($this->correo->send())
        {
         echo 'Correo enviado';
        }
      
        else
        {
         echo 'No ha podido enviarse';
        }
        //$this->correo->send();

    }

    /**
     * Primero: comprobar que el usuario está logueado
     * Segungo: comprobar stock de los productos del carrito
     * tercero:crearPedido
     * cuarto: guardar la información de lo comprado en las lineas de pedido pertinentes
     * quinto: modificar el estock
     * sexto: vista contenido del pedido realizado
     */
    public function tramitarPedido()
    {
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->model('Model_usuarios');
        $this->load->library('cart');

        $cesta = $this->cart->contents();
        if ($this->session->userdata('dentro')) {
            //echo 'hola';
            $clienteID = $this->session->userdata('usuario_id');
            $datosCliente = $this->Model_usuarios->getUsuario($clienteID);

            if ($this->Model_productos->comprobarStockCarrito($cesta) == "") {

                $this->Model_productos->creaPedido($datosCliente); //aqui me peta
                $pedidoID = $this->Model_productos->ultimoPedido($clienteID); //ultimoPedido($usuarioID)
                $this->Model_productos->registraPedido($cesta, $pedidoID);
                $this->Model_productos->modificaStockCarrito($cesta);

                $datos['pedido'] = $this->Model_productos->getPedido($pedidoID);
                $datos['lineas'] = $this->Model_productos->getLineasPedido($pedidoID);
                $datos['totales'] = $this->Model_productos->totalCompra($cesta);
                
                
                $this->pdfPedido($pedidoID);
                $this->load->view('Plantilla', [
                    'titulo' => 'Pedido realizados',
                    'cuerpo' => $this->load->view('DetallePedido', $datos, true)]);
                $this->Model_productos->eliminarCarritoSolo(); //vaciar carrito
            } else {
                $datos['h2Inicial'] = $this->Model_productos->comprobarStockCarrito($cesta);
                $this->load->view('Plantilla', [
                    'titulo' => 'Pedido realizados',
                    'cuerpo' => $this->load->view('ProblemasCompra', $datos, true)]);
            }
        } else {
            $datos['h2Inicial'] = "No está identificado o no está registrado, por favor acceda a su cuenta o cree una para seguir con la commpra";
            $this->load->view('Plantilla', [
                'titulo' => 'Pedido realizados',
                'cuerpo' => $this->load->view('ProblemasCompra', $datos, true)]);
        }

    }

    public function verPedidos(){

        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->model('Model_usuarios');

        $clienteID = $this->session->userdata('usuario_id');
        $datos['h2Inicial'] = "Todos sus pedidos: ";
        $datos['todosPedidos']= $this->Model_productos->getPedidos($clienteID);
        $this->load->view('Plantilla', [
            'titulo' => 'Pedido realizados',
            'cuerpo' => $this->load->view('Pedidos', $datos, true)]);
    }

    public function verDetallePedido($id){
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->model('Model_usuarios');
        $datos['pedido'] = $this->Model_productos->getPedido($id);
        $datos['lineas'] = $this->Model_productos->getLineasPedido($id);
        $datos['totales'] =array('aPagar'=>($this->Model_productos->totalPedido($id)), 'desgloseIVA'=>'valor no actualizado'); ;
                
               
        $this->load->view('Plantilla', [
            'titulo' => 'Pedido realizados',
            'cuerpo' => $this->load->view('DetallePedido', $datos, true)]);
    }

    /**
     * Primero comprobar si el pedido sigue como pendiente,
     * solo se puede anular si el estado es P
     * Segundo: cambiar estado pedido
     * tercero: devolver productos al estos
     */
    public function cancelarPedido($pedido_id) {
        $this->load->model('Model_productos'); //cargo el modelo
        $this->load->model('Model_usuarios');
        
        $this->Model_productos->cambiaEstadoPedido($pedido_id,'C');
        $this->Model_productos->devolucionPedido($pedido_id);
        $this->verPedidos();       

    }

    public function facturaPedido($idPedido){
        $this->load->model('Model_fpdf2');
        $this->load->model('Model_productos');

        $datosPedido= $this->Model_productos->getPedido($idPedido);
        $lineasPedido= $this->Model_productos->getLineasPedido($idPedido);
       
        $pdf = new FacturaPDF();
        $pdf->AddPage("P");

        $pdf->datosCliente($datosPedido);
        $header = ["nombre",'precio',"cantidad", "subtotal"];
        $pdf->tabla($header, $lineasPedido);
        $total=$this->Model_productos->totalPedido($idPedido);
        $iva=$this->Model_productos->totalIVAPedido($idPedido);
        $pdf->totales($total,$iva);
        $pdf->Output();//lo guardo con le nombre por defecto Doc.pdf
    }

}
