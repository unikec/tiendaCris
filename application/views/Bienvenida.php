<h2>Bienvenid@ <?=$this->session->userdata('nombre_usuario')?></h2>

				
		</div>
				<div class="col-md-5">
				
				<a  class="btn btn-info" href="<?=site_url().'/Productos/totalPedidos/'.$this->session->userdata('usuario_id')?>">Pedidos</a>
				<a  class="btn btn-warning"  href="<?=site_url().'/Usuarios/editaUsuario/'.$this->session->userdata('usuario_id')?>">Editar Usuario</a>
				<a class="btn btn-success" href="<?=site_url().'/Usuarios/eliminaCuenta/'.$this->session->userdata('usuario_id')?>">Eliminar Cuenta</a>
		
        
		</div>
