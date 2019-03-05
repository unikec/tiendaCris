<h2 class="center"><?=$h2Inicial?></h2>
<div>
  <table class="table table-borderless">
        <tr>
            <td colspan="6"><h4>Aquí están sus productos seleccionados.</h4></td>
            <td><a href="<?= site_url() . '/Productos/eliminarCarrito/' ?>"><i class="fas fa-cart-arrow-down"></i></a></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Precio</td>
            <td>Descuento</td>
            <td>Cantidad</td>
            <td>Subtotal</td>
            <td></td>
        </tr>
        <?php foreach ($productosCarrito as $row) :?>
        
            <tr>
                <td><img src="<?=base_url().'img/'.$row['imagen']?> " height="50px" width="50px" ></td>
                <td><b><?= $row['name'] ?></b></td>
                <td><b><?= $row['price'] ?>€</b></td>
                <td><b><?= $row['descuento'] ?>%</b></td>
                <td><i class="far fa-minus-square"></i>&nbsp;&nbsp;<b><?= $row['qty']?></b>&nbsp;&nbsp;<i class="far fa-plus-square"></i></td>
                <td><b><?= ($row['price']-($row['price']*($row['descuento']/100)))*$row['qty'] ?>€</b></td>
                <td><a href="<?= site_url() . '/Productos/eliminarProducto/'.$row['rowid']?>"><i class="fas fa-times"></i></a></td>
            </tr>
          <?php endforeach;?>
  </table>  

     <div class="container-fluid">
    <div class="row ">
        <div class="col-md-8">Total IVA <small>desglosado</small>:<b> <?= $totales['desgloseIVA'] ?> €</b> </div>  
        <div class="col-md-4"><label>Total,<small> IVA incluido</small>: <b> <?= $totales['aPagar'] ?> €</b></label></div>
             
    </div>
  <p>Todos los productos llevan IVA incluido en le precio, en el apartodo subtotal dedrá aplicado el pertinente descuento</p>

     </div> 
    <div class="clearfix">
        <div class="float-right">
            <a class="btn btn btn-info " href="<?= site_url() . '/Productos/index/' . $this->session->userdata('id') ?>"><b><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Continuar comprando</b></a>
        </div>
        
        <div class="float-left">
            <a class="btn btn btn-info" href="<?= site_url() . '/Productos/tramitarPedido/' ?>"><b><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Finalizar compra</b></a>
        </div>
         
    </div>
</div>