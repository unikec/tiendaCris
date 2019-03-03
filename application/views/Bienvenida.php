<h2>Bienvenid@ <?=$this->session->userdata('nombre_usuario')?></h2>

				
				</div>
				<div class="col-md-5">
				<br>
				
				<?php if (isset($modificado)) :?>
							<center>
							<h5 style="color:#1D8348;"><b>Los datos se han modificado con éxito.</b></h5>
							</center>
				<?php endif;?>
				<h3><b>¿Que deseas hacer?</b></h3></center><ul>
				<hr>
				<li><a href="<?=site_url().'/Productos/verPedidos/'.$this->session->userdata('usuario_id')?>"><b>Ver mis pedidos, cancelarlos y ver sus facturas</b></a></center></li><br>
				<li><a href="<?=site_url().'/Usuarios/editaUsuario/'.$this->session->userdata('usuario_id')?>"><b>Modificar tus datos personales y cambiar tu clave</b></a></center></li><br>
			
				<li><a style="color:red;" href="#" data-toggle="modal" data-target="#bcuenta"><b>Darte de baja y cancelar tu cuenta</b></a></center></li><br></ul>

					  <!-- Modal -->
					  <div class="modal fade" id="bcuenta" role="dialog">
						<div class="modal-dialog modal-sm">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title"><b>Baja del usuario</b></h4>
							</div>
							<div class="modal-body">
							  <p>¿Estás seguro que quieres darte de baja?</p>
							</div>
							<div class="modal-footer">
							  <a class="btn btn-success" href="<?=site_url().'/Usuarios/eliminaUsuario/'.$this->session->userdata('usuario_id')?>">&nbsp;&nbsp;Si&nbsp;&nbsp;</a>
							  <button type="button" class="btn btn-danger" data-dismiss="modal">&nbsp;&nbsp;No&nbsp;&nbsp;</button>
							</div>
						  </div>
						</div>
					  </div>

				</div>
        </div>
		</div>
