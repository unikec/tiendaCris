<h2><?=$h2Inicial?></h2>

    <div class="row  col-md-12">
       
         <?php foreach ($productos as $producto) : ?>
            <table class="table-borderless col-md-4 text-center">
                <tr><td><a href="<?= site_url() . '/Productos/mostrarDetalle/' . $producto->producto_id ?>"><img src="<?= base_url() . '/img/' . $producto->imagen ?>" alt="" class="img-fluid" height="200" width="200"></a></td></tr>
                <tr><td> <?= $producto->nombre ?></td></tr>
                <tr><td>Precio: <?= $producto->precio ?> €</td></tr>
                <tr><td>
                        <?php if ($producto->stock<=0):?>
                            <h4 class="text-danger">No hay stock</h4>                                           
                        <?php else:?>
                        <a class="btn btn-info" href="<?=site_url().'/productos/addProducto/'.$producto->producto_id?>">Al carrito</a ></td></tr>
                        <?php endif;?>
            </table>
        <?php endforeach; ?>          
         
     </div>
    <div class="row col-md-12">
        <div class="mx-auto">
            <p><?=$pag?></p>
        </div> 
    </div>


