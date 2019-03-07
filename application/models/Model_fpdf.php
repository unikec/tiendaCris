<?php
class Model_fpdf extends CI_Model {

    
    function __construct() {
        parent::__construct();
    }

}
Class FactPDF  extends Fpdf\Fpdf {
		// Cabecera de página
		function Header()
		{	
			$this->Line(10,10,200,10);
            $this->SetFont('Arial','B',16);
            $this->Cell(80);
            $this->Cell(40,25,utf8_decode('Copi Bily Paper'),0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','B',8);
            $this->Cell(85);
            $this->Cell(28,25,utf8_decode('TiendaCris'),0,0,'C');
            $this->Line(10,35,200,35);
			$this->Ln(26);
        }

        function datosCliente($datos){
          
           $this->SetFont('Arial', '', 15);
           $this->Cell(0,6,utf8_decode("Num pedido:".$datos->pedido_id),0,0,"L");
           $this->Ln();
           $this->Cell(0,6,utf8_decode("Fecha de compra:".$datos->fecha),0,0,"L");
           $this->Ln();
           $this->Cell(0,6,utf8_decode("Nombre: ".$datos->nombre_usuario_pedido),0,0,"L");
           $this->Ln();
           $this->Cell(0,6,utf8_decode("Apellidos:".$datos->apellidos_pedido),0,0,"L");
           $this->Ln();
           $this->Cell(0,6,utf8_decode("DNI: ".$datos->dni_pedido),0,0,"L");
           $this->Ln(26);
             
       }

       function tabla($header, $data)
       {
           // Colores, ancho de línea y fuente en negrita
           $this->SetFillColor(255,0,0);
           $this->SetTextColor(255);
           $this->SetDrawColor(128,0,0);
           $this->SetLineWidth(.3);
           $this->SetFont('','B');
           // Cabecera
           $w = array(80, 40, 45);
           //$this->Cell(20,7,"",0);
           for($i=0;$i<count($header);$i++){
               $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
           }
           $this->Ln();
           // Restauración de colores y fuentes
           $this->SetFillColor(224,235,255);
           $this->SetTextColor(0);
           $this->SetFont('');
           // Datos
           $fill = false;
           
          
           foreach($data as $row){

               $this->Cell($w[0],6,utf8_decode($row->nombre_producto),'LR',0,'L',$fill);
               $this->Cell($w[1],6,$row->cantidad,'LR',0,'C',$fill);    
               $this->Cell($w[2],6,$row->importe."€",'LR',0,'C',$fill);
              
               $this->Ln();
               $fill = !$fill;
           }
           // Línea de cierre
          
           $this->Cell(array_sum($w),0,'','T');
       }

		// Pie de página
		function Footer()
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		}
}