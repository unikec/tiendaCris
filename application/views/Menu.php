<?php
$ci=get_instance();
$categorias = $ci->Model_productos->getCategorias();
?>
<nav class="navbar navbar-expand-sm navbar-light bg-light ">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav  ">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url().'/Productos/index/'?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ref='<?= base_url(); ?>categorias'>categorias</a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php foreach ($categorias as $producto) : ?>
                    <a class="dropdown-item" href="<?= site_url().'/Productos/mostrarCategorias/'.$producto->categoria_id?>"><?= $producto->nombre ?></a> 
                    <?php endforeach; ?>   
                </div>
            </li>
            <?php if ($this->session->userdata('usuario_id')) :?>
            <li>
                <a  class="btn btn-info" href="<?=site_url().'/Productos/verPedidos/'.$this->session->userdata('usuario_id')?>">Pedidos</a>
            </li>
            <li>
				<a  class="btn btn-warning"  href="<?=site_url().'/Usuarios/editaUsuario/'.$this->session->userdata('usuario_id')?>">Editar Usuario</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    
    <span class="float-right text-dark rounded p-1">
        <ul class="navbar-nav float-right">
            <?php if ($this->session->userdata('usuario_id')) :?>
            <li class="nav-item">  Hola <?= $this->session->userdata('nombre_usuario') ?></li>
            <a class="nav-link" href="<?= site_url().'/Usuarios/LogOut'?>"><i class="fas fa-user-slash"></i></a>
                    
            <?php else : ?>
            <a   href="<?= site_url().'/Usuarios/index/'?>"><i class="fas fa-user"></i></a>  
            <?php endif; ?>
            <a   href="<?= site_url().'/Productos/verCarrito/'?>"><i class='fas fa-shopping-cart'></i></a>
        </ul>              
     </span>
  </nav>
</div>