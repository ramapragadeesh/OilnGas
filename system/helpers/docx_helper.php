<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function docx_create($html,$docname="My_Article") 
{
     header( 'Content-Type: application/msword' ); 
    header("Content-disposition: attachment; filename=" .$docname.".doc");  
    /*
    header("Content-type: application/vnd.ms-word");
    header("Content-disposition: attachment; filename=" .date("Y-m-d").".rtf");
    */
    //$html = preg_replace('%/[^\\s]+\\.(jpg|jpeg|png|gif)%i', 'http://www.akubocrm.com\\0', $html);

    print "<html xmlns:v=\"urn:schemas-microsoft-com:vml\"";
    print "xmlns:o=\"urn:schemas-microsoft-com:office:office\"";
    print "xmlns:w=\"urn:schemas-microsoft-com:office:word\"";
    print "xmlns=\"http://www.w3.org/TR/REC-html40\">";
    print "<xml>
     <w:WordDocument>
      <w:View>Print</w:View>
      <w:DoNotHyphenateCaps/>
      <w:PunctuationKerning/>
      <w:DrawingGridHorizontalSpacing>9.35 pt</w:DrawingGridHorizontalSpacing>
      <w:DrawingGridVerticalSpacing>9.35 pt</w:DrawingGridVerticalSpacing>
     </w:WordDocument>
    </xml>
    ";

    die($html);

}
?>