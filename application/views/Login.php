<?= validation_errors(); ?>
<?= (isset($error)) ? $error : ''; ?>
<?php $attributes = array('class' => 'form-horizontal'); ?>
<?= form_open('Usuarios/LogIn', $attributes); ?>

    <h2 class='text-center'><img class="" src="<?= base_url() . '/img/user.png' ?>" width="50px">  Login de usuario:</h2>
    <div class="form-group row">

        <label class="control-label col-sm-2" for="name">Usuario:</label>

        <div class="col-sm-10">
            <input type="text" class="form-control"  name='usuario' placeholder="Enter nick" value="" >
        </div>
    </div>  
    <div class="form-group row">
        <label class="control-label col-sm-2" for="pwd">Password:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name='contrasena' placeholder="Enter password" value=""/>     
              </div>
             
    </div>

        <div class="form-group row">
            <div class="col-sm-offset-2 col-sm-12">
                <input type="submit" value="Enviar" name="submit" class="btn btn-success btn-lg btn-block" />
            </div>
        </div>

    
<?= form_close() ?>


 
