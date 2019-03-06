<h3>Detalle del pedido Nº <?= $pedido->pedido_id?></h3>
<h4>Fecha: <?= $pedido->fecha ?></h4>
<h4>Nombre/ Apellidos: <?= $pedido->nombre_usuario_pedido?><?= $pedido->apellidos_pedido?></h4>				
<h4>DNI: <?= $pedido->dni_pedido?></h4>

<table class="table table-borderless">
        <tr>
            <td colspan="6"><h4>Contenido del pedido.</h4></td>
    
        </tr>
        <tr>
            <td></td>
            <td>Producto</td>
            <td>Cantidad</td>
            <td>SubTotal</td>


        </tr>
        <?php foreach ($lineas as $row) :?>
        
            <tr>
                <td><img src="<?=base_url().'img/'.$row->imagen_producto?> " height="50px" width="50px" ></td>
                <td><b><?= $row->nombre_producto ?></b></td>
                <td><b><?= $row->cantidad ?>€</b></td>
                <td><b><?= $row->importe ?>€</b></td>

            </tr>
          <?php endforeach;?>
  </table>  

     <div class="container-fluid">
    <div class="row ">
        <div class="col-md-8">Total IVA <small>desglosado</small>:<b> <?= $totales['desgloseIVA'] ?> €</b> </div>  
        <div class="col-md-4"><label>Total,<small> IVA incluido</small>: <b> <?= $totales['aPagar'] ?> €</b></label></div>
             
    </div>
    
    
    <br>
    <a class="btn btn btn-default" href="<?=site_url().'/Productos/verPedidos/'.$this->session->userdata('id')?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Volver a ver todos los pedidos</b></a></center><br><br>


