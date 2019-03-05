<div class='alert alert-warning'>
<?= validation_errors(); ?>
<?php if (isset($error)) :?>

	<h5 class='text-danger'><?= $error ?></h5>

 <?php endif;?>
 </div>

<?=form_open('Usuarios/guardarEdicion');?>
        <div class="row">

				<div style='margin-left: 6em' class="container">
								<div class="col-xs-3">
									<div class="form-group">
										<label for="user">Contraseña</label>
										<input type="password" maxlength="10" name="clave1" value="" class="form-control" id="pass" placeholder="Introduce la contraseña">
									</div>
								</div>
								<div class="col-xs-3">
									<div class="form-group">
										<label for="pass">Repetir contraseña</label>
										<input type="password" maxlength="10" name="clave2" value="" class="form-control" id="pass" placeholder="Vuelve a introducir la contraseña">
									</div>
								</div>
				</div>
        </div>

			<div  class="mx-auto">

                <div class="row">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Nick o alias</label>
                            <input type="text" name="nombre_usuario" value="<?=$usuario->nombre_usuario?>" class="form-control" id="name" placeholder="Nombre">
                        </div>
					</div>
                   <div class="col-sm-10">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="surname">Apellidos</label>
                            <input type="text" name="apellidos" value="<?=$usuario->apellidos?>" class="form-control" id="surname" placeholder="Apellidos">
                        </div>
                    </div>
                </div>

				<div class="row">
                    <div class="col-sm-10">
                        <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Email</label>
                                <input type="email" name="email" value="<?=$usuario->email?>" class="form-control" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-sm-10">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name">Nombre</label>
                                <input type="text" name="nombre" value="<?=$usuario->nombre?>" class="form-control" id="name" placeholder="Nombre direccion postal">
                            </div>
                        </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                                <label  class="control-label col-sm-2" for="dni">DNI</label>
                                <input type="text" name="dni" maxlength="9" value="<?=$usuario->dni?>" class="form-control" id="dni" placeholder="DNI">
                        </div>
                    </div>
                    <div class="col-sm-10"><hr>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address">Dirección</label>
                            <input type="text" name="direccion" value="<?=$usuario->direccion?>" class="form-control" id="address" placeholder="Dirección">
                        </div>
                    </div>
                    <div class="col-sm-10"><hr>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="cp">Dirección</label>
                            <input type="text" name="cp" value="<?=$usuario->direccion?>" class="form-control" id="cp" placeholder="Codigo Postal">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="provincias">Provincia</label>
                            <?=form_dropdown('provincia', $this->Model_usuarios->provinciasDropDown(), $usuario->provincia_id, 'class="form-control"');?>
                        </div>
                    </div>

                </div>

        </div>


		<a  class="btn btn btn-default" href="<?=site_url() . '/Productos/index'?>">Cancelar</a>
		<button type="submit" name="bcontinuar" class="btn btn-success">Guardar</button>
    </div>

<?php echo form_close() ?>
<div class="float-right">
<a class="btn btn-danger" href="<?=site_url().'/Usuarios/eliminaCuenta/'.$this->session->userdata('usuario_id')?>">Eliminar Cuenta</a>

</div>
