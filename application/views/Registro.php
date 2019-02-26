<?php echo validation_errors(); ?>
<?php echo form_open('RegistroUsuario'); ?>
<h5>Usuario</h5>
<input type="text" name="nombre_usuario" value="" size="50" />
<h5>Contraseña</h5>
<input type="text" name="contraseña" value="" size="50" />
<h5>Email</h5>
<input type="text" name="email" value="" size="50" />
<h5>Nombre</h5>
<input type="text" name="nombre" value="" size="50" />
<h5>Apellidos</h5>
<input type="text" name="apellidos" value="" size="50" />
<h5>DNI</h5>
<input type="text" name="dni" value="" size="50" />
<h5>Direccion</h5>
<input type="text" name="direccion" value="" size="50" />
<h5>Provincia</h5>
<select name="provincia" >
    <?php
    foreach ($provincias as $row) {
        echo'<option>'.$row->nombre.'</option>';
    }
    ?>
</select>
<div><input type="submit" value="Enviar" /></div>
</form>