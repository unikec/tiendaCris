
<p>El precio DB del producto con id 6: <?= $precioDB ?></p>
<p>El precio final con descuento: <?= $descuento ?></p>
<p>El total de producto 6 ten en cuenta que le hemos indicado dos unides: <?= $subTotal ?></p>
<p>El iva total por id de producto y cantidad: <?= $ivaSubTotal ?></p>


<h1>comprobando que funciona totalCompra:</h1>
 <?php print_r($totalCompra['aPagar'])?> 


        <div class="row">
            <div class="col-6">Total IVA: <?= $totalCompra['desgloseIVA'] ?> </div>
            <div class="col-6">Total a pagar: <?= $totalCompra['aPagar'] ?> </div>       
        </div>
<!-- enlace para hacer las pruebas-->
<p align="right"><a class="btn btn btn-success" href="<?= site_url() . '/Productos/prueba/' ?>">Prueba</a></p>
