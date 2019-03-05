
<h3>Detalle del pedido Nº <?= $pedido['id']?> con fecha <?= $pedido['fecha']?><?= $pedido['nombre']?><?= $pedido['apellidos']?> </h3>				


<table class="table table-borderless">
        <tr>
            <td colspan="6"><h4>Contenido del pedido.</h4></td>
    
        </tr>
        <tr>
            <td></td>
            <td>Producto</td>
            <td>Precio</td>
            <td>Cantidad</td><datalist></datalist>

        </tr>
        <?php foreach ($lineas as $row) :?>
        
            <tr>
                <td><img src="<?=base_url().'img/'.$row['imagen_producto']?> " height="50px" width="50px" ></td>
                <td><b><?= $row['nombre_producto'] ?></b></td>
                <td><b><?= $row['cantidad'] ?>€</b></td>
                <td><b><?= $row['importe'] ?>€</b></td>

            </tr>
          <?php endforeach;?>
  </table>  

     <div class="container-fluid">
    <div class="row ">
        <div class="col-md-8">Total IVA <small>desglosado</small>:<b> <?= $totales['desgloseIVA'] ?> €</b> </div>  
        <div class="col-md-4"><label>Total,<small> IVA incluido</small>: <b> <?= $totales['aPagar'] ?> €</b></label></div>
             
    </div>
    
    
    <br>
    <a class="btn btn btn-default" href="<?=site_url().'/Productos/verPedidos/'.$this->session->userdata('id')?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Volver atrás</b></a></center><br><br>


