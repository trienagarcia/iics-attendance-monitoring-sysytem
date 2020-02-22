<?php
// require('fpdf\fpdf.php');
require('PDF_MC_Table.php');
// include('session.php'); 
// include('process_view_record.php'); 

Class Pdf extends PDF_MC_Table{
	protected $imageKey = '';
	public function setImageKey($key){
		$this->imageKey = $key;
	}

	public function Row($data){
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		$this->CheckPageBreak($h);
		for($i=0;$i<count($data);$i++){
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			$x=$this->GetX();
			$y=$this->GetY();
			$this->Rect($x,$y,$w,$h);

        //modify functions for image 
			if(!empty($this->imageKey) && in_array($i,$this->imageKey)){
				$ih = $h - 0.5;
				$iw = $w - 0.5;
				$ix = $x + 0.25;
				$iy = $y + 0.25;
				$this->MultiCell($w,5,$this->Image ($data[$i],$ix,$iy,$iw,$ih),0,$a);
			}
			else
				$this->MultiCell($w,5,$data[$i],0,$a);
			$this->SetXY($x+$w,$y);
		}
		$this->Ln($h);
	}
}


/* Instanciation of inherited class */
// $anes = "";
// $pat_name = $patient_name . " " . $pat_middle . " " . $pat_lname . " " . $pat_suffix;
// $phy = $physician . " " . $phy_middle . " " . $phy_lname . " " . $phy_suffix;
// $ref = $ref_consultant . " " . $ref_middle . " " . $ref_lname . " " . $ref_suffix;
// $anes .= $anesthesia;
// $anes .= !empty($anesthesia_drugs) ? ", " . $anesthesia_drugs : '';
// $plan = "Return to: " . $returnto . " on " . $returndate . ", " . $followup;
// $title = "BRONCH_report_" . $patient_id;

$pdf = new PDF_MC_Table();
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',18);
$pdf->SetX(35);
$pdf->Cell(100,10,'University of Santo Tomas Hospital');

?>