<h2 class="center"><?=$h2Inicial?></h2>
<h3 style='margin-left: 4em'>Recuperación de clave</h3>
				
<?php echo form_open('Usuarios/recuperarClave'); ?>
	<div class="row">
	    <div class="col-xs-4">
			<div class="form-group">
                 <input style='margin-left: 7em' type="text" name="usuario" class="form-control" id="usuario" placeholder="Tu nombre de usuario">
            </div>
		   <button style='margin-left: 7em' type="submit" name="bcontinuar" class="btn btn-success">Enviar</button>

	   </div>
   </div>	
		
<a style='margin-left: 7em' class="btn btn btn-default" href="<?=site_url().'/Usuarios/Login'?>">Volver</a>	
<?php echo form_close() ?>
