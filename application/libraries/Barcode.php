<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/tcpdf/tcpdf_barcodes_2d.php');

class Barcode
{
   
	
	//Page header
    public function GetHTML($URL) {
       // include 1D barcode class (search for installation path)

// set the barcode content and type

// set the barcode content and type
$barcodeobj = new TCPDF2DBarcode($URL, 'DATAMATRIX');

// output the barcode as HTML object
return $barcodeobj->getBarcodeHTML(6, 6, 'black');

    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */