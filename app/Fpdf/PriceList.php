<?php
namespace App\Fpdf;
use \Codedge\Fpdf\Fpdf\Fpdf;

Class PriceList extends Fpdf {
	private $_x;
	private $_y;
	var $y0;
	function Header()
	{
		//$this->Image(PUBLICO."img".DS.'logo_miraldi3.jpg',10,8,33);
		//$this->SetTextColor(56,56,56);

		$this->SetFont('Arial','B',15);            
		$this->Cell(0,10,$this->_titulo."  ".date("d/m/Y H:i:s"),'0',1,'C');
		$this->SetFont('Arial','B',8);
		$this->Ln(1);

		$this->SetFont('Arial','B',8);
		//$this->Cell(10,5,utf8_decode($linea),1,0);
		$this->Ln(5);
        $this->Cell(15,5,utf8_decode('CODIGO'),1,0);
        $this->Cell(125,5,utf8_decode('NOMBRE'),1,0);
        $this->Cell(17,5,utf8_decode('PRECIO'),1,0,'C');
        $this->Cell(18,5,utf8_decode('DISP. REF.'),1,0,'C');
        $this->Cell(15,5,utf8_decode('x CAJA'),1,0,'C');
        $this->Ln(5);
        $this->y0 = $this->GetY();

	}

	// Pie de página
	function Footer()
	{
	}

	function PintaDetalle($stocks){


        $c1=count($stocks);
        if ($c1 > 0) {
        	$this->SetFont('Arial','',8);

            for ($i=0; $i < $c1; $i++) {
                if ($i%2==0) {
                    $this->SetFillColor(200);
                } else {
                    $this->SetFillColor(255);
                }
                $this->Cell(15, 5, $stocks[$i]->ACODIGO,0,0,'L',true);
                $this->Cell(125, 5, $stocks[$i]->ADESCRI,0,0,'',true);
                $this->Cell(17, 5, number_format($stocks[$i]->PRE_ACT,2),0,0,'R',true);
                $this->Cell(18, 5, number_format($stocks[$i]->STSKDIS,2)." ".$stocks[$i]->AUNIDAD,0,0,'R',true);
                $this->Cell(15, 5, (($stocks[$i]->APESO>0) ? number_format($stocks[$i]->APESO, 0) : ''), 0,0,'R',true);
                $this->Ln(4);
            }
        }
	}
	function firmas(){

	}
}
?>