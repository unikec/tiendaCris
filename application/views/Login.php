<?= validation_errors(); ?>
<?php if (isset($error)) :?>
	<h5 style="color:red;"><?= $error ?></h5>
 <?php endif;?>
<?php $attributes = array('class' => 'form-horizontal'); ?>
<?= form_open('Usuarios/logIn', $attributes); ?>

    <h2 class='text-center'><img class="" src="<?= base_url() . '/img/user.png' ?>" width="50px">  Login de usuario:</h2>
    <div class="form-group row">

        <label class="control-label col-sm-2" for="name">Usuario:</label>

        <div class="col-sm-10">
            <input type="text" class="form-control"  name='usuario' placeholder="Enter nick" value="<?=set_value('nombre_usuario')?>" >
        </div>
    </div>  
    <div class="form-group row">
        <label class="control-label col-sm-2" for="pwd">Password:</label>
        <div class="col-sm-10">
            <p>Si ha olvidado su contraseña,<a href="<?=site_url().'/Usuarios/nuevaClave'?>"> pinche aquí</a></p>
            <input type="password" class="form-control" id="password" name='password' placeholder="Enter password" value=""/>     
        </div>
         
    </div>

        <div class="form-group row">
            <div class="col-sm-offset-2 col-sm-12">
                <input type="submit" value="Enviar" name="submit" class="btn btn-success btn-lg btn-block" />
            </div>
            
        </div>

    
<?= form_close() ?>
<div class="mx-auto">

<a class="btn btn btn-info" href="<?=site_url().'/Usuarios/registro'?>">Registrese</a>
		
</div>
        


 
