<?php $this->load->model('Model_productos');?>;
<div class="container xm-auto">
<h2><?= $h2Inicial ?></h2>
<ul class="list-group">
<?php foreach ($todosPedidos as $datos): ?>
<?php $cancelar="<a  role='button' class='btn btn-danger' href=".site_url().'/Productos/cancelarPedido/'.$datos->pedido_id.">CANCELAR</a>" ?>
<?php $factura="<a  role='button' class='btn btn-info' href=".site_url().'/Productos/facturaPedido/'.$datos->pedido_id.">FACTURA</a>" ?>

    <li class="list-group-item"><b>Pedido Número:</b> <?=$datos->pedido_id ?>&nbsp; con fecha de <?=$datos->fecha ?>&nbsp;
    &nbsp;<b>Estado: </b> <?=$this->Model_productos->aclaraEstado($datos->estado) ?>&nbsp;
      Total <?= $this->Model_productos->totalPedido($datos->pedido_id) ?>€&nbsp;&nbsp;&nbsp;&nbsp;
      <a  role="button" class="btn btn-success" href="<?= site_url().'/Productos/verDetallePedido/'.$datos->pedido_id?>">Ver en Detalle</a>&nbsp;&nbsp;&nbsp;
     <?= ($datos->estado=="P")? $cancelar:"" ?>&nbsp;&nbsp;&nbsp;&nbsp;<?= ($datos->estado=="R")? $factura:"" ?></li>
<?php endforeach;?>
  </ul>
</div>


