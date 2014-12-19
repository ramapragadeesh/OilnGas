<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
	
	//Page header
    public function Header($compname="") {
	  
	  $this->SetFont('dejavusans', '', 14, '', true);
$this->SetFont('helvetica', '', 20);
// set font
$this->SetFont('cid0jp', '', 12);

      $this->WriteHTML('<div>
<table>
<tr>
<td>	  
<a href="http://abrasivesworld.com/" style="font-size:20px;color:rgb(158, 31, 99);text-decoration:none">
<span><b>Abrasivesworld</b></span> </a>
<a href="http://abrasivesworld.com/" style="font-size:20px;color:rgb(158, 31, 99);text-decoration:none">
<span> <b>研磨世界</b></span></a>
</td>
</tr>
<tr>
<td>
<br/>
<br/>
<a href="'.$_SESSION['PDFH_ORGURL'].'" style="font-size:14px;color:rgb(158, 31, 99);text-decoration:none">
<span><b> &nbsp;'.$_SESSION['PDFH_ORG'].' Public URL : </b> 
'.$_SESSION['PDFH_ORGURL'].'
</span>
</a>
</td>
</tr>
</table>
');
        // Logo
		/*
        $image_file = K_PATH_IMAGES.'AB.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Abrasivesworld', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		*/
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */