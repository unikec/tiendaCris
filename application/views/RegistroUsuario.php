<?= validation_errors(); ?>
<?php if (isset($error)) :?>
	<h5 style="color:red;"><?= $error ?></h5>
 <?php endif;?>
<?php $attributes = array('class' => 'form-horizontal'); ?>
<?= form_open('Usuarios/registro', $attributes); ?>


<div class='form-group row'>
<div class="col-sm-10">
    <label class="control-label col-sm-2">Usuario</label>
    <input type="text" class="form-control" name="nombre_usuario" value=""  />
</div>
<div class="col-sm-10">
    <label>Contraseña</label>
    <input type="password" class="form-control" name="contrasena" value=""  />
</div>
<div class="col-sm-10">
    <label class="control-label col-sm-2">Email</label>
    <input type="email" class="form-control" name="email" value=""  />
</div>
<div class="col-sm-10">
    <label class="control-label col-sm-2">Nombre</label>
    <input type="text" class="form-control" name="nombre" value=""  />
</div>
<div class="col-sm-10">
    <label class="control-label col-sm-2">Apellidos</label>
    <input type="text" class="form-control" name="apellidos" value=""  />
</div>
<div class="col-sm-10">
    <label class="control-label col-sm-2">DNI</label>
    <input type="text" class="form-control" name="dni" value="" />
</div>
<div class="col-sm-10">
    <label class="control-label col-sm-2">Direccion</label>
    <input type="text" class="form-control" name="direccion" value=""  />
</div>
<div class="col-sm-10">
    <label class="control-label col-sm-2">Código Postal</label>
    <input type="text" class="form-control" name="cp" value=""  />
</div>
<div class="col-sm-10">
<label class="control-label col-sm-2">Provincia</label>
<select class="form-control" name="provincia" >
    <?php
foreach ($provincias as $row) {
    echo '<option value="'. $row->provincia_id .'" >' . $row->nombre . '</option>';
}
?>
</select>
<div class="form-group row">
            <div class="col-sm-offset-2 col-sm-12">
                <input type="submit" value="Enviar" name="submit" class="btn btn-success btn-lg btn-block" />
            </div>

</div>
</div>
<?=form_close()?>