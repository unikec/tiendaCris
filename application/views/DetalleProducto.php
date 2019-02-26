<h2 class="center"><?=strtoupper($h2Inicial)?></h2>

    <div class="row">
        
            		
        
         <div class="col-6">
             <img src="<?= base_url().'/img/'.$producto->imagen ?>" height="300px" width="400px">
         </div>
        <div class="col-6">
            <h4>Descripción:</h4>
            <p><?=$producto->descripcion?></p>
            <p><?=$producto->anuncio?></p>
            <h4>Precio: <?=$producto->precio?> €</h4>
            <p><b>Stock: </b>
		<?php if ($producto->stock<=0):?>
            <h3 class="text-danger">No hay stock</h3>                                           
                <?php else:?>
                    <p><?= $producto->stock ?> disponibles</p> 
                    
                    <?= form_open('Productos/addProducto/'.$producto->producto_id.'/TRUE')?>
                    <label>Cantidad: </label>
                    <select  name="cantidad">
                       <?php for($i=1;$i<=$producto->stock;$i++){
                           if($i==1){
                              echo '<option selected>'.$i.'</option>'; 
                           }else{
                              echo '<option>'.$i.'</option>'; 
                           }
                       }?>
                    </select>
                    <input type="hidden" name="productoId" value=<?= $producto->producto_id?> >
                    <input type=submit class="btn btn-info" value="Comprar">
                    <?= form_close()?>  
                 
		<?php endif;?>
            
              
            
            
        </div>                                   
    
    </div>
