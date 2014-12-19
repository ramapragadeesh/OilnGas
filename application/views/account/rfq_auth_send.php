<?php
$RFQ_GROUP=false;
function list_gmem(& $ai)
{

  if ($ai=="")
  {
    return "No member list is found";
  }
  $h='<div> <b> Member List </b> </div><form><table class="table"><tr><th>Member Email</th><th>Member Company Name</th></tr>';

  foreach($ai as &$v)
  {
    $h .="<tr><td><div class='checkbox'><label><input type='checkbox' name='approvedEmail[]'>

    ".$v['user_email']."</label></div></td><td>".$v['user_orgname']."</td></tr>";
  }

  return $h."</table></form>";
}
function is_selected($arrd,$fdat)
{
  global $RFQ_GROUP;

  $pieces = explode(";", $arrd);
  foreach($pieces as &$value)
  {
    $RFQ_GROUP=true;
    if (strtolower($value) == strtolower($fdat))
    {

      return "checked";
    }
  }
}

function build_group_selection(& $data, & $ih,$ps)
{
  $sel="";
  foreach($data as $row)
  {
    if ($row['uselectiontext']=="Others, please specify")
    {
      $sel .= '<input style="margin:0px 0px 0px 0px" type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> <span>'.dp($ih,'Others not listed above').'</span><br/>';
    }

    else
    {
      $sel .= '<input style="margin:0px 0px 0px 0px" type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> <span>'.dp($ih,$row['uselectiontext']).'</span><br/>';
    }
  }
  $sel .="";
  return $sel;
}

function useremaildata(& $audata)
{
  $dyd="<div class='checkbox'>
  ";
  $v=0;
  foreach($audata as &$value)
  {
    $v=1;
    if ($value->user_email != "")
    {
      $dyd .='<label><input type="checkbox" class="alreadylisted" value="'.htmlspecialchars($value->user_email).'" >'.htmlspecialchars($value->user_email).'</label>';
    }
  }
  $dyd .="</div>
  ";
  if ( $v==1)
  {
    return $dyd;
  }
  else
  {
    return "";
  }
}
function useremaildata_popup(& $audata)
{
//uemaildata
  $dyd="
  !function(source) {
    function extractor(query) {
      var result = /([^,]+)$/.exec(query);
      if(result && result[1])
        return result[1].trim();
      return '';
    }
    
    $('.typeahead').typeahead({
      source: source,
      updater: function(item) {
        return this.\$element.val().replace(/[^,]*$/,'')+item+',';
      },
      matcher: function (item) {
        var tquery = extractor(this.query);
        if(!tquery) return false;
        return ~item.toLowerCase().indexOf(tquery.toLowerCase())
      },
      highlighter: function (item) {
        
        var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
        return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
          return '<strong>' + match + '</strong>'
        })
}
});

}([";
  $v=0;
  foreach($audata as &$value)
  {
    $v=1;
    $dyd .='"'. htmlspecialchars($value->user_email).'",';
  }
  $dyd .='""]);';
if ($v==1)
{
  return $dyd;
}
else
{
  return "";
}
}
function GUID()
{
  if (function_exists('com_create_guid') === true)
  {
    return trim(com_create_guid(), '{}');
  }

  return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function dp(& $info_holderdy,$f)
{
  $rt=$f;
  foreach ($info_holderdy as &$value) 
  {
    if (strtolower($value->default_text) == strtolower($f))
    {
      $rt = $value->dp;
      break;
    }
  }
  return $rt;
}
function populate_docs(& $dd,& $l,$rfqactive)
{

  $r="";
  $rc=0;
  foreach ($dd as &$value) 
  {
    $readonlyf='<a href="javascript:;" class="btn btn-small">
    <i class="btn-icon-only icon-remove" onclick="dme('.$value->doc_id.',this)"></i>										
  </a>
  ';
  if ($rfqactive == 1)
  {
    $readonlyf="";
  }

  $r .='
  <tr>
    <td>
      '.$value->rfq_filename.'
    </td>

    <td>
      <a href="'.$value->rfq_linkname.'" target="_blank">Download</a>
    </td>
    <td>
      '.$readonlyf.'
    </td>

  </tr>
  ';
}
return $r;
}
function populate_uom($value)
{
  $r="";
  if ($value=="Pieces")
  {
    $r .='<option value="Pieces" selected>Pieces</option>';
  }
  else
  {
    $r .='<option value="Pieces">Pieces</option>';
  }

  if ($value=="Meters")
  {
    $r .= '<option value="Meters" selected>Meters</option>';
  }
  else
  {
    $r .= '<option value="Meters">Meters</option>';
  }

  if ($value=="Metersquare")
  {
    $r .= '<option value="Metersquare" selected>Metersquare</option>';

  }
  else
  {
    $r .= '<option value="Metersquare">Metersquare</option>';

  }
  if ($value=="Kilogram")
  {
    $r .= '<option value="Kilogram" selected>Kilogram</option>';

  }
  else
  {
    $r .= '<option value="Kilogram">Kilogram</option>';

  }
  if ($value=="Ton")
  {
    $r .= '<option value="Ton">Ton</option>';
  }
  else
  {
    $r .= '<option value="Ton">Ton</option>';
  }

  return $r;



}
function populate_rfq_table(& $langm,& $rfqtd,$rfqactive)
{
  $rfqdelete='<a href="javascript:;" class="btn btn-small">
  <i class="btn-icon-only icon-remove" onclick="rme(this)"></i>										
</a>
';
$rfqreadonly="";

if ($rfqactive == 1)
{
  $rfqdelete="";
  $rfqreadonly="readonly disabled";
}

$r="";
$rc=0;
$dc=0;
foreach ($rfqtd as &$value) 
{
  $dc=$dc+1;

  $rc=$rc+1;
  if ($rc==1)
  {
    $r .='<tr id="initrfqrow">
    <td>
      <input type="text" style="width:40px" '.'value="'.htmlspecialchars($value->serialno).'" name="rfqtsn[]" '.$rfqreadonly.' readonly/>
    </td>
    <td>
      <input type="text" '.'value="'.htmlspecialchars($value->cdesc).'" name="rfqtcdesc[]"  '.$rfqreadonly.' class="stritemcdesc" />
    </td>

    <td>
      <input type="text" style="width:80px" '.'value="'.htmlspecialchars($value->spec).'" name="rfqtspec[]" '.$rfqreadonly.' class="stritemspec" />
    </td>

    <td>
      <input type="text" style="width:80px" '.'value="'.htmlspecialchars($value->dimension).'" name="rfqtdi[]"  '.$rfqreadonly.' class="stritemdim" />
    </td>

    <td>
      <input type="text" style="width:80px" '.'value="'.htmlspecialchars($value->quantity).'" name="rfqtqu[]"  '.$rfqreadonly.' class="stritemquan" />
    </td>

    <td>
      <select style="width:80px" name="rfqtuom[]"  '.$rfqreadonly.' >
        '.populate_uom($value->uom).'
      </select>
    </td>

    <td>
      <input type="text" style="width:40px" onblur="rfqtotal()" '.'value="'.htmlspecialchars($value->reqprice).'" name="rfqtreqprice[]"  '.$rfqreadonly.' class="numitemreqp"/>
    </td>
    <td>
      <input type="text" style="width:40px" '.'value="'.htmlspecialchars($value->reqleadtime).'" name="rfqtleadtime[]"  '.$rfqreadonly.' />
    </td>

    <td>
    </td>

  </tr>';
}
else
{
  $r .='<tr>
  <td>
    <input type="text" style="width:40px" '.'value="'.htmlspecialchars($value->serialno).'" name="rfqtsn[]"  '.$rfqreadonly.' readonly />
  </td>
  <td>
    <input type="text" '.'value="'.htmlspecialchars($value->cdesc).'" name="rfqtcdesc[]"  '.$rfqreadonly.' class="stritemcdesc" />
  </td>

  <td>
    <input type="text" style="width:80px" '.'value="'.htmlspecialchars($value->spec).'" name="rfqtspec[]"  '.$rfqreadonly.' class="stritemspec" />
  </td>

  <td>
    <input type="text" style="width:80px" '.'value="'.htmlspecialchars($value->dimension).'" name="rfqtdi[]" '.$rfqreadonly.' class="stritemdim" />
  </td>

  <td>
    <input type="text" style="width:80px" '.'value="'.htmlspecialchars($value->quantity).'" name="rfqtqu[]"  '.$rfqreadonly.' class="stritemquan" />
  </td>

  <td>
    <select style="width:80px" name="rfqtuom[]"  '.$rfqreadonly.' >
      '.populate_uom($value->uom).'
    </select>
  </td>

  <td>
    <input type="text" style="width:40px" onblur="rfqtotal()" '.'value="'.htmlspecialchars($value->reqprice).'" name="rfqtreqprice[]"  '.$rfqreadonly.' class="numitemreqp" />
  </td>
  <td>
    <input type="text" style="width:40px" '.'value="'.htmlspecialchars($value->reqleadtime).'" name="rfqtleadtime[]"  '.$rfqreadonly.' />
  </td>
  <td>
    '.$rfqdelete.'
  </td>
</tr>';
}


}
return $r;
}
?>
<script>
  $(document).ready(function() {
    var d = new Date();
    var currDate = d.getDate();
    var currMonth = d.getMonth()+1;
    var currYear = d.getFullYear();
    var dateStr = currDate + "/" + currMonth + "/" + currYear;
    $('#rfq_issuedate').val(dateStr);

  });
</script>
<style>
  .tooltipc {
   display:none;
   position:absolute;
   border:1px solid #333;
   background-color:#161616;
   border-radius:5px;
   padding:10px;
   color:#fff;
   font-size:12px Arial;
 }
</style>
<div id="main_container" class="main_container">
  <div>    
    <div class="header_text">
      <div style="margin-left:30px;">
        <span style="padding-right:20px">
          <i class="icon-user"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>account/my_profile"><?php echo dp($info_holder,"Edit my profile");?></a></span></span>
          <span style="padding-right:20px"><i class="icon-lock"></i><span style="padding-left:5px"><a  style="color:white"  href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></span></span>
          <span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management System");?></a></span>
        </span>
        <span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:orange" href="<?php echo base_url();?>rfq"><b><?php echo dp($info_holder,"Request for quotation");?></b></a></span>
      </span>
    </div>
  </div>
  <div id="maincon">

    <div style="margin-top:20px;margin-left:50px">
      <?php echo list_gmem($rgp);?>

      <div>

        <a href="../approve_rfq/?rfqid=<?php echo $rfqm[0]->rfq_id;?>"><button class="btn btn-info">Approve</button></a>
        <a href="../approve_rfq/?rfqid=<?php echo $rfqm[0]->rfq_id;?>"><button class="btn btn-warning">Revoke</button></a>

      </div>
    </div>

    <?php
    $readon=" readonly disabled ";
    if ($rfqm[0]->rfq_active == 0)
    {
      $readon="";
    }
    ?>

    <div style="padding-top:30px">
    </div>
    <div id="rfqcontent" style="margin-left:50px;">
      <form id="rfqformdata" action="../../rfq/rfq_modify_save" method="post" enctype="multipart/form-data">
        <table style="width:800px" >
          <tr>

            <td>
              <label for="scw_oldpass"><?php echo dp($info_holder,"RFQ Number");?></label>
            </td>

            <td>
              <input type="text" name="rfqno" id="rfqno" value="<?php echo $rfqm[0]->rfq_no;?>" required="required" readonly/>
            </td>

            <td>
              <label><?php echo dp($info_holder,"RFQ Title");?>*</label>
            </td>
            <td>
              <input type="text" name="rfqtitle"  id="rfqtitle" value="<?php echo $rfqm[0]->rfq_title;?>" required="required" <?php echo $readon;?> required="required" />
            </td>

          </tr>

          <tr>
            <td>
              <label><?php echo dp($info_holder,"RFQ Issued By");?>*
              </label>
            </td>

            <td>
              <input type="text" name="rfqissuedby"  id="rfqissuedby" value="<?php echo $rfqm[0]->rfq_issueby;?>" required="required"  <?php echo $readon;?> required="required" />
            </td>

            <td>
              <label><?php echo dp($info_holder,"Registered Company Name");?>*
              </label>

            </td>

            <td>
              <input type="text" name="rfqcname"  id="rfqcname" value="<?php echo $rfqm[0]->rfq_company_name;?>" required="required" readonly/>
            </td>

          </tr>


          <tr>

            <td>
              <label><?php echo dp($info_holder,"RFQ Issue Date");?>*
              </label>

            </td>

            <td>
              <input type="text" name="rfq_issuedate"  id="rfq_issuedate" value="" required="required" readonly/>
            </td>

            <td>
              <label><?php echo dp($info_holder,"RFQ Close Date");?>*
              </label>

            </td>

            <td>
              <input type="text" name="rfq_closedate"  id="rfq_closedate" value="<?php echo $rfqm[0]->rfq_close_date;?>" required="required"  <?php echo $readon;?> required="required" />

            </td>

          </tr>


          <tr>
            <td>
              <label><?php echo dp($info_holder,"Country of Imports");?>*
              </label>

            </td>

            <td>
              <input type="text" name="rfqcimports"  id="rfqcimports" value="<?php echo $rfqm[0]->rfq_country_imports;?>" required="required"  <?php echo $readon;?> required="required" />

            </td>


            <td>
              <label ><?php echo dp($info_holder,"Preferred country of export");?>*
              </label>


            </td>

            <td>
              <input type="text" name="rfqcexports"  id="rfqcexports" data-items="4" data-provide="typeahead" value="<?php echo $rfqm[0]->rfq_pref_cn_export;?>" required="required"  <?php echo $readon;?> required="required"/>
            </td>

          </tr>


          <tr>
            <td>
              <label><?php echo dp($info_holder,"Preferred currency");?>*
              </label>

            </td>

            <td>
              <select name="rfqcurrency" id="rfqcurrency"  <?php echo $readon;?> >
                <option value="USD" selected>US Dollars</option>
                <option value="EUR">EURO</option>
                <option value="YUAN">Yuan Renminbi</option>  
                <option value="AFA">Afghani</option>
                <option value="AFN">Afghani</option><option value="ALK">Albanian old lek</option><option value="ALL">Lek</option><option value="DZD">Algerian Dinar</option><option value="USD">US Dollar</option><option value="ADF">Andorran Franc</option><option value="ADP">Andorran Peseta</option><option value="AOR">Angolan Kwanza Readjustado</option><option value="AON">Angolan New Kwanza</option><option value="AOA">Kwanza</option><option value="XCD">East Caribbean Dollar</option><option value="ARA">Argentine austral</option><option value="ARS">Argentine Peso</option><option value="ARL">Argentine peso ley</option><option value="ARM">Argentine peso moneda nacional</option><option value="ARP">Peso argentino</option><option value="AMD">Armenian Dram</option><option value="AWG">Aruban Guilder</option><option value="AUD">Australian Dollar</option><option value="ATS">Austrian Schilling</option><option value="AZM">Azerbaijani manat</option><option value="AZN">Azerbaijanian Manat</option><option value="BSD">Bahamian Dollar</option><option value="BHD">Bahraini Dinar</option><option value="BDT">Taka</option><option value="BBD">Barbados Dollar</option><option value="BYR">Belarussian Ruble</option><option value="BEC">Belgian Franc (convertible)</option><option value="BEF">Belgian Franc (currency union with LUF)</option><option value="BEL">Belgian Franc (financial)</option><option value="BZD">Belize Dollar</option><option value="XOF">CFA Franc BCEAO</option><option value="BMD">Bermudian Dollar</option><option value="INR">Indian Rupee</option><option value="BTN">Ngultrum</option><option value="BOP">Bolivian peso</option><option value="BOB">Boliviano</option><option value="BOV">Mvdol</option><option value="BAM">Convertible Marks</option><option value="BWP">Pula</option><option value="NOK">Norwegian Krone</option><option value="BRC">Brazilian cruzado</option><option value="BRB">Brazilian cruzeiro</option><option value="BRL">Brazilian Real</option><option value="BND">Brunei Dollar</option><option value="BGN">Bulgarian Lev</option><option value="BGJ">Bulgarian lev A/52</option><option value="BGK">Bulgarian lev A/62</option><option value="BGL">Bulgarian lev A/99</option><option value="BIF">Burundi Franc</option><option value="KHR">Riel</option><option value="XAF">CFA Franc BEAC</option><option value="CAD">Canadian Dollar</option><option value="CVE">Cape Verde Escudo</option><option value="KYD">Cayman Islands Dollar</option><option value="CLP">Chilean Peso</option><option value="CLF">Unidades de fomento</option><option value="CNX">Chinese People's Bank dollar</option><option value="COP">Colombian Peso</option><option value="COU">Unidad de Valor real</option><option value="KMF">Comoro Franc</option><option value="CDF">Franc Congolais</option><option value="NZD">New Zealand Dollar</option><option value="CRC">Costa Rican Colon</option><option value="HRK">Croatian Kuna</option><option value="CUP">Cuban Peso</option><option value="CYP">Cyprus Pound</option><option value="CZK">Czech Koruna</option><option value="CSK">Czechoslovak koruna</option><option value="CSJ">Czechoslovak koruna A/53</option><option value="DKK">Danish Krone</option><option value="DJF">Djibouti Franc</option><option value="DOP">Dominican Peso</option><option value="ECS">Ecuador sucre</option><option value="EGP">Egyptian Pound</option><option value="SVC">Salvadoran colon</option><option value="EQE">Equatorial Guinean ekwele</option><option value="ERN">Nakfa</option><option value="EEK">Kroon</option><option value="ETB">Ethiopian Birr</option><option value="FKP">Falkland Island Pound</option><option value="FJD">Fiji Dollar</option><option value="FIM">Finnish Markka</option><option value="FRF">French Franc</option><option value="XFO">Gold-Franc</option><option value="XPF">CFP Franc</option><option value="GMD">Dalasi</option><option value="GEL">Lari</option><option value="DDM">East German Mark of the GDR (East Germany)</option><option value="DEM">Deutsche Mark</option><option value="GHS">Ghana Cedi</option><option value="GHC">Ghanaian cedi</option><option value="GIP">Gibraltar Pound</option><option value="GRD">Greek Drachma</option><option value="GTQ">Quetzal</option><option value="GNF">Guinea Franc</option><option value="GNE">Guinean syli</option><option value="GWP">Guinea-Bissau Peso</option><option value="GYD">Guyana Dollar</option><option value="HTG">Gourde</option><option value="HNL">Lempira</option><option value="HKD">Hong Kong Dollar</option><option value="HUF">Forint</option><option value="ISK">Iceland Krona</option><option value="ISJ">Icelandic old krona</option><option value="IDR">Rupiah</option><option value="IRR">Iranian Rial</option><option value="IQD">Iraqi Dinar</option><option value="IEP">Irish Pound (Punt in Irish language)</option><option value="ILP">Israeli lira</option><option value="ILR">Israeli old sheqel</option><option value="ILS">New Israeli Sheqel</option><option value="ITL">Italian Lira</option><option value="JMD">Jamaican Dollar</option><option value="JPY">Yen</option><option value="JOD">Jordanian Dinar</option><option value="KZT">Tenge</option><option value="KES">Kenyan Shilling</option><option value="KPW">North Korean Won</option><option value="KRW">Won</option><option value="KWD">Kuwaiti Dinar</option><option value="KGS">Som</option><option value="LAK">Kip</option><option value="LAJ">Lao kip</option><option value="LVL">Latvian Lats</option><option value="LBP">Lebanese Pound</option><option value="LSL">Loti</option><option value="ZAR">Rand</option><option value="LRD">Liberian Dollar</option><option value="LYD">Libyan Dinar</option><option value="CHF">Swiss Franc</option><option value="LTL">Lithuanian Litas</option><option value="LUF">Luxembourg Franc (currency union with BEF)</option><option value="MOP">Pataca</option><option value="MKD">Denar</option><option value="MKN">Former Yugoslav Republic of Macedonia denar A/93</option><option value="MGA">Malagasy Ariary</option><option value="MGF">Malagasy franc</option><option value="MWK">Kwacha</option><option value="MYR">Malaysian Ringgit</option><option value="MVQ">Maldive rupee</option><option value="MVR">Rufiyaa</option><option value="MAF">Mali franc</option><option value="MTL">Maltese Lira</option><option value="MRO">Ouguiya</option><option value="MUR">Mauritius Rupee</option><option value="MXN">Mexican Peso</option><option value="MXP">Mexican peso</option><option value="MXV">Mexican Unidad de Inversion (UDI)</option><option value="MDL">Moldovan Leu</option><option value="MCF">Monegasque franc (currency union with FRF)</option><option value="MNT">Tugrik</option><option value="MAD">Moroccan Dirham</option><option value="MZN">Metical</option><option value="MZM">Mozambican metical</option><option value="MMK">Kyat</option><option value="NAD">Namibia Dollar</option><option value="NPR">Nepalese Rupee</option><option value="NLG">Netherlands Guilder</option><option value="ANG">Netherlands Antillian Guilder</option><option value="NIO">Cordoba Oro</option><option value="NGN">Naira</option><option value="OMR">Rial Omani</option><option value="PKR">Pakistan Rupee</option><option value="PAB">Balboa</option><option value="PGK">Kina</option><option value="PYG">Guarani</option><option value="YDD">South Yemeni dinar</option><option value="PEN">Nuevo Sol</option><option value="PEI">Peruvian inti</option><option value="PEH">Peruvian sol</option><option value="PHP">Philippine Peso</option><option value="PLZ">Polish zloty A/94</option><option value="PLN">Zloty</option><option value="PTE">Portuguese Escudo</option><option value="TPE">Portuguese Timorese escudo</option><option value="QAR">Qatari Rial</option><option value="RON">New Leu</option><option value="ROL">Romanian leu A/05</option><option value="ROK">Romanian leu A/52</option><option value="RUB">Russian Ruble</option><option value="RWF">Rwanda Franc</option><option value="SHP">Saint Helena Pound</option><option value="WST">Tala</option><option value="STD">Dobra</option><option value="SAR">Saudi Riyal</option><option value="RSD">Serbian Dinar</option><option value="CSD">Serbian Dinar</option><option value="SCR">Seychelles Rupee</option><option value="SLL">Leone</option><option value="SGD">Singapore Dollar</option><option value="SKK">Slovak Koruna</option><option value="SIT">Slovenian Tolar</option><option value="SBD">Solomon Islands Dollar</option><option value="SOS">Somali Shilling</option><option value="ZAL">South African financial rand (Funds code) (discont</option><option value="ESP">Spanish Peseta</option><option value="ESA">Spanish peseta (account A)</option><option value="ESB">Spanish peseta (account B)</option><option value="LKR">Sri Lanka Rupee</option><option value="SDD">Sudanese Dinar</option><option value="SDP">Sudanese Pound</option><option value="SDG">Sudanese Pound</option><option value="SRD">Surinam Dollar</option><option value="SRG">Suriname guilder</option><option value="SZL">Lilangeni</option><option value="SEK">Swedish Krona</option><option value="CHE">WIR Euro</option><option value="CHW">WIR Franc</option><option value="SYP">Syrian Pound</option><option value="TWD">New Taiwan Dollar</option><option value="TJS">Somoni</option><option value="TJR">Tajikistan ruble</option><option value="TZS">Tanzanian Shilling</option><option value="THB">Baht</option><option value="TOP">Pa'anga</option><option value="TTD">Trinidata and Tobago Dollar</option><option value="TND">Tunisian Dinar</option><option value="TRY">New Turkish Lira</option><option value="TRL">Turkish lira A/05</option><option value="TMM">Manat</option><option value="RUR">Russian rubleA/97</option><option value="SUR">Soviet Union ruble</option><option value="UGX">Uganda Shilling</option><option value="UGS">Ugandan shilling A/87</option><option value="UAH">Hryvnia</option><option value="UAK">Ukrainian karbovanets</option><option value="AED">UAE Dirham</option><option value="GBP">Pound Sterling</option><option value="UYU">Peso Uruguayo</option><option value="UYN">Uruguay old peso</option><option value="UYI">Uruguay Peso en Unidades Indexadas</option><option value="UZS">Uzbekistan Sum</option><option value="VUV">Vatu</option><option value="VEF">Bolivar Fuerte</option><option value="VEB">Venezuelan Bolivar</option><option value="VND">Dong</option><option value="VNC">Vietnamese old dong</option><option value="YER">Yemeni Rial</option><option value="YUD">Yugoslav Dinar</option><option value="YUM">Yugoslav dinar (new)</option><option value="ZRN">Zairean New Zaire</option><option value="ZRZ">Zairean Zaire</option><option value="ZMK">Kwacha</option><option value="ZWD">Zimbabwe Dollar</option><option value="ZWC">Zimbabwe Rhodesian dollar</option>

              </select>

            </td>

            <td>
              <label><?php echo dp($info_holder,"Quotation validity duration");?>*
              </label>

            </td>

            <td>
              <select name="rfqqval" id="rfqqval"  <?php echo $readon;?> >
                <option value="1" <?php if( $rfqm[0]->rfq_quot_validation=="1"){ echo "selected";}?>><?php echo dp($info_holder,"One month");?></option>
                <option value="2" <?php if( $rfqm[0]->rfq_quot_validation=="2"){ echo "selected";}?>><?php echo dp($info_holder,"Two months");?></option>
                <option value="3" <?php if( $rfqm[0]->rfq_quot_validation=="3"){ echo "selected";}?>><?php echo dp($info_holder,"Three months");?></option>
                <option value="6" <?php if( $rfqm[0]->rfq_quot_validation=="6"){ echo "selected";}?>><?php echo dp($info_holder,"Six months");?></option>
                <option value="12" <?php if( $rfqm[0]->rfq_quot_validation=="12"){ echo "selected";}?>><?php echo dp($info_holder,"One year");?></option>

              </select>

            </td>

          </tr>

          <tr>
            <td>
              <label><?php echo dp($info_holder,"Incoterm");?>*
              </label>
            </td>

            <td>
              <select name="rfqincoterm" id="rfqincoterm"  <?php echo $readon;?> >
                <option value="EXW" <?php if( $rfqm[0]->rfq_incoterm=="EXW"){ echo "selected";}?>>EXW</option>
                <option value="FOB" <?php if( $rfqm[0]->rfq_incoterm=="FOB"){ echo "selected";}?>>FOB</option>
                <option value="CIF" <?php if( $rfqm[0]->rfq_incoterm=="CIF"){ echo "selected";}?>>CIF</option>
                <option value="DDU" <?php if( $rfqm[0]->rfq_incoterm=="DDU"){ echo "selected";}?>>DDU</option>
                <option value="DDP" <?php if( $rfqm[0]->rfq_incoterm=="DDP"){ echo "selected";}?>>DDP</option>
                <option value="Others" <?php if( $rfqm[0]->rfq_incoterm=="Others"){ echo "selected";}?>>Others</option>
              </select>
            </td>

            <td>
              <label><?php echo dp($info_holder,"Partial Shipment Allowed");?>
              </label>
            </td>
            <td>
              <select name="rfqpship" id="rfqpship"  <?php echo $readon;?> >
                <option value="yes" <?php if( $rfqm[0]->rfq_partial=="yes"){ echo "selected";}?>><?php echo dp($info_holder,"Yes");?></option>
                <option value="no" <?php if( $rfqm[0]->rfq_partial=="no"){ echo "selected";}?>><?php echo dp($info_holder,"No");?></option>
                <option value="na" <?php if( $rfqm[0]->rfq_partial=="na"){ echo "selected";}?>><?php echo dp($info_holder,"N/A");?></option>
              </select>

            </td>

          </tr>

          <tr>
            <td valign="top">
              <label><?php echo dp($info_holder,"Send this RFQ via");?>*
              </td>

              <td valign="top">
                <span><a href="#"  class="masterTooltip"  style="color:black" title="Send this RFQ via Group Members Group” indicating “Your message shall be qualified by Abrasivesworld before sending to its members group. It is to ensure that no irresponsible article are sent out. It shall take another 2-3 days before reaching the member group."><b><?php echo dp($info_holder,"Via members group");?></b></a></span> <input  style="margin:0 0 0 0" type="checkbox"  value="posthome" name="posthome" id="sendviagroup"/>

                <div id="jshowbygroup" style="display:none">
                  <?php echo build_group_selection($usergroupinfo,$info_holder,$rfqm[0]->rfq_group);?>
                </div>
                
              </td>

              <td>

                <span><a href="#"  class="masterTooltip"  style="color:black" title="Send this RFQ via email” indicating “Your message can only be viewed by the email receiver with you in copy. Each email receiver will not be able to see other email addresses that you may  include"><b><?php echo dp($info_holder,"Via email");?></b></a></span> <input style="margin:0 0 0 0" type="checkbox"  value="jshowbyemailc" name="jshowbyemailc" id="jshowbyemailc"/>

                <div id="jshowbyemail" style="display:none">
                 <br/>			
                 <span>
                   <input type="text" name="rfqemail" class="typeahead" id="rfqemail" style="width:200px;" value="<?php echo $rfqm[0]->rfq_email;?>"  <?php echo $readon;?> />
                   <input style="margin-top:-5px" type="button" class="btn btn-default" value="select from your previous entry" onclick='show_previous_entry();'  <?php echo $readon;?> />
                 </span>
                 <br/>
                 You can enter one or more email address by using "," to separate 2 addresses. For example email1@domain.com,email2@domain.com			
               </div>
               
               
             </td>

             <td>
             </td>

           </tr>

         </table>
         <div  class="padme">
          <div id="rfqinit" style="margin-top:20px;width:90%;min-width:500px;">
            <div style="border:3px solid whitesmoke">
              <p style="font-weight:bold;font-size:15px;padding-left:30px;height:20px;background-color:whitesmoke"><?php echo dp($info_holder,"RFQ information");?></p>

              <table class="table" style="width:80%" id="rfqtable">
                <thead>
                  <tr>
                    <th>
                      <?php echo dp($info_holder,"S/N");?>
                    </th>
                    <th>
                      <?php echo dp($info_holder,"Commodity description");?>*
                    </th>

                    <th>
                      <?php echo dp($info_holder,"Specification");?>*
                    </th>
                    <th>
                      <?php echo dp($info_holder,"Dimension");?>*
                    </th>
                    <th>
                      <?php echo dp($info_holder,"Quantity");?>*
                    </th>

                    <th>
                      <?php echo dp($info_holder,"Unit of measurement");?>*
                    </th>
                    <th>
                      <?php echo dp($info_holder,"Requested Price");?>
                    </th>

                    <th>
                      <?php echo dp($info_holder,"Requested Lead Time");?>
                    </th>

                    <th>
                    </th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                  echo populate_rfq_table($info_holder,$rfqt,$rfqm[0]->rfq_active);?>
                </tbody>
                <tfoot>
                  <tr><td></td><td></td><td></td><td></td><td></td><td><b><?php echo dp($info_holder,"Total");?></b></td><td><b></b></td></tr>
                </tfoot>
              </table>

              <?php
              if ($rfqm[0]->rfq_active == "0")
              {
                ?>
                <div  class="padme" style="text-align:right;width:80%;margin-bottom:10px">
                  <input type="button" class="btn" id="rfqtableadd" value="<?php echo dp($info_holder,"Add S/N");?>">
                </div>
                <?php
              }
              ?>

              <div style="clear:both">
              </div>

            </div>
          </div>


        </div>



        <div style="clear:both">
        </div>

        <div  class="padme" style="text-align:right;width:80%;margin-bottom:20px;margin-top:10px">
          <div style="border:3px solid whitesmoke">
            <p style="font-weight:bold;font-size:15px;padding-left:30px;height:20px;background-color:whitesmoke;text-align:left"><?php echo dp($info_holder,"Previously Attached Documents");?></p>
            <table class="table" style="width:80%" id="rfqtableadded">
              <thead>
                <th>
                  <?php echo dp($info_holder,"File Name");?>
                </th>

                <th>
                  <?php echo dp($info_holder,"Download Link");?>

                </th>

                <th>
                  <?php
                  if ($rfqm[0]->rfq_active == "0")
                  {
                    ?>
                    <?php echo dp($info_holder,"Delete");?>
                    <?php
                  }
                  ?>
                </th>

              </thead>
              <tbody>
                <?php
                echo populate_docs($rfqd,$info_holder,$rfqm[0]->rfq_active);?>
              </tbody>
            </table>

          </div>

        </div>


        <div style="clear:both">
        </div>

        <div  class="padme" style="margin-top:10px" id="">

          <?php
          if ($rfqm[0]->rfq_active == "0")
          {
            ?>
            <div style="border:3px solid whitesmoke;width:500px;margin-top:10px;margin-bottom:10px;margin-left:5px">
              <p style="font-weight:bold;font-size:15px;padding-left:30px;height:20px;background-color:whitesmoke"><?php echo dp($info_holder,"Supporting Documents");?></p>
              <div>
                <div  class="padme" style="margin-top:10px" id="attachdocuments">
                  <div style="margin-top:10px;">
                    <input  type="file"style="height:30px"  name='multipartFilePath[]' /> 
                  </div>
                </div>
              </div>
              <div style="clear:both">
              </div>

              <div  class="padme" style="margin-top:10px">
                <input type="button" class="btn"  id="addmoredocs" value="<?php echo dp($info_holder,"Add More Docs");?>">
              </div>
              <br/>
            </div>
            <?php
          }
          ?>
        </div>

        <div style="clear:both">
        </div>

        <?php
        if ($rfqm[0]->rfq_active == "0")
        {
          ?>

          <?php
        }
        ?>
        <div style="clear:both">
        </div>
        <?php
        if ($rfqm[0]->rfq_active == "1")
        {
          ?>
          <div  class="padme" style="margin-top:20px">
            <input type="hidden" value="<?php echo $RFQGUID;?>" name="rfqid">
          </div>
          <?php
        }
        else
        {
          ?>
          <div  class="padme" style="margin-top:20px">
            <input type="hidden" name="rfqactiveme" id="rfqactiveme" value="1">
            <input type="button" id="draftactuvate" class="btn" value="<?php echo dp($info_holder,"Save as Draft");?>">
            <input type="button" class="btn" id="activerfq" value="<?php echo dp($info_holder,"Save and post RFQ");?>">
            <input type="hidden" value="<?php echo $RFQGUID;?>" name="rfqid">
          </div>


          <?php
        }
        ?>
        <div style="clear:both">
        </div>

      </form>
    </div>


    <!-- Modal -->
    <div style="display:none" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body" id="svauth">
            <div id="dyen">
              <p><?php echo dp($info_holder,"Please wait, while we update your RFQ data.");?></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    
  </div>
</div>
</div>


<!-- Modal -->
<div style="display:none" class="modal fade" id="myemailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title"></h4>
     </div>
     <div class="modal-body" id="svauth">
      <div>
        <strong>
          <?php echo dp($info_holder,"Previously added email entries");?>
        </strong>
        <br/>
      </div> 
      <?php
      $va=useremaildata($uemaildata);
      if ($va == "") { echo dp($info_holder,"No email entries are found.");}else{ echo $va;};
      ?>
    </div>
    <div class="modal-footer">
     <input type='button' value='<?php echo dp($info_holder,"Select All");?>' class='btn' onclick='select_all_ue();'>
     <input type='button' value='<?php echo dp($info_holder,"Deselect All");?>' class='btn' onclick='deselect_all_ue();'>

     <input type='button' value='<?php echo dp($info_holder,"OK");?>' onclick='selected_ue();' class='btn'>		
     <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
   </div>
 </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<script>
  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }
  var istotaladded=0;
  $( "#rfqtableadd" ).click(function() {
    add_rfq();
    rfqtotal();
  });

  function rfqtotal()
  {
    var gt=0;
    $('#rfqtable tbody tr td:nth-child(7)').find("input").each(function() {
      try
      {
        if (isNumeric($(this).val()))
        {
          var gc= parseInt($(this).val());
          gt=gt+gc;
        }
      }
      catch(err)
      {
      }
    });

    var gr="<tr><td></td><td></td><td></td><td></td><td></td><td><b>"+"<?php echo dp($info_holder,"Total")?>"+"</b></td><td><b>"+gt.toString()+" "+$("#rfqcurrency").val()+"</b></td></tr>";
    $("#rfqtable tfoot tr").remove(); 
    $('#rfqtable tfoot').append(gr);

  }
  function add_rfq()
  {
    var row = $("#initrfqrow").html();
    $('#rfqtable tbody').append('<tr>'+row+'</tr>');
    var rrem='<a href="javascript:;" class="btn btn-small"><i class="btn-icon-only icon-remove" onclick="rme(this)"></i></a>';
    var srl=Number($('#rfqtable >tbody >tr').length);
    $('#rfqtable >tbody >tr').eq(srl-1).find("td:last").append(rrem);
    update_serialno();
  }
  var gtrace;
  function rme(rew)
  {
    var rowCount = $('#rfqtable tbody tr').length;
    if (rowCount != 1)
    {
      rew.parentElement.parentElement.parentElement.remove();
      rfqtotal();
    }
    update_serialno();
  }
</script>
<style>
  .shape{	
   border-style: solid; border-width: 0 70px 40px 0; float:right; height: 0px; width: 0px;
   -ms-transform:rotate(360deg); /* IE 9 */
   -o-transform: rotate(360deg);  /* Opera 10.5 */
   -webkit-transform:rotate(360deg); /* Safari and Chrome */
   transform:rotate(360deg);
 }
 .offer{
   background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
 }
 .offer-radius{
   border-radius:7px;
 }
 .offer-danger {	border-color: #d9534f; }
 .offer-danger .shape{
   border-color: transparent #d9534f transparent transparent;
   border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
 }
 .offer-success {	border-color: #5cb85c; }
 .offer-success .shape{
   border-color: transparent #5cb85c transparent transparent;
   border-color: rgba(255,255,255,0) #5cb85c rgba(255,255,255,0) rgba(255,255,255,0);
 }
 .offer-default {	border-color: #999999; }
 .offer-default .shape{
   border-color: transparent #999999 transparent transparent;
   border-color: rgba(255,255,255,0) #999999 rgba(255,255,255,0) rgba(255,255,255,0);
 }
 .offer-primary {	border-color: #428bca; }
 .offer-primary .shape{
   border-color: transparent #428bca transparent transparent;
   border-color: rgba(255,255,255,0) #428bca rgba(255,255,255,0) rgba(255,255,255,0);
 }
 .offer-info {	border-color: #5bc0de; }
 .offer-info .shape{
   border-color: transparent #5bc0de transparent transparent;
   border-color: rgba(255,255,255,0) #5bc0de rgba(255,255,255,0) rgba(255,255,255,0);
 }
 .offer-warning {	border-color: #f0ad4e; }
 .offer-warning .shape{
   border-color: transparent #f0ad4e transparent transparent;
   border-color: rgba(255,255,255,0) #f0ad4e rgba(255,255,255,0) rgba(255,255,255,0);
 }
 .shape-text{
   color:#fff; font-size:12px; font-weight:bold; position:relative; right:-40px; top:2px; white-space: nowrap;
   -ms-transform:rotate(30deg); /* IE 9 */
   -o-transform: rotate(360deg);  /* Opera 10.5 */
   -webkit-transform:rotate(30deg); /* Safari and Chrome */
   transform:rotate(30deg);
 }	
 .offer-content{
   padding:0 20px 10px;
 </style>
 <script>
  var country_list = ['Others'];
  var country_listim = ['Others'];
  $('#rfqcexports').typeahead({source: country_list});
  $('#rfqcimports').typeahead({source: country_listim});

  $.getJSON('<?php echo base_url();?>general/country_list', function(data) {
   $.each(data, function(key, val) {
     country_list.push(val.country_name);
     country_listim.push(val.country_name);   
   });
 });
  var adddoc = $('#attachdocuments').html();
  $( "#addmoredocs" ).click(function() 
  {
    $('#attachdocuments').append(adddoc);
  });

  var etrace;
  function dme(docid,eid)
  {
    etrace=eid;
    var r = confirm("Do you want to delete?");
    if (r == true)
    {
    }
    else
    {
      return;
    }
    var formData = {
      "docid" : docid        
    };
    $.ajax({
      url : "../docs_delete",
      type: "POST",
      data : formData,
      success: function(data, textStatus, jqXHR)
      {
       
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
       
      }
    });
    etrace.parentElement.parentElement.parentElement.remove();
  }

  $('#jshowbyemailc').change(function() {
    if($("#jshowbyemailc").is(":checked"))
    {
      $('#jshowbyemail').show();
    }
    else
    {
      $('#jshowbyemail').hide();
    }
  });

    function show_previous_entry()
    {

      $("#myemailModal").modal();

    }

    function select_all_ue()
    {
      $('.alreadylisted').prop('checked', true);
    }
    function deselect_all_ue()
    {
      $('.alreadylisted').prop('checked', false);
    }
    function selected_ue()
    {
      $("#myemailModal").modal('hide');
      var values = $('input:checkbox:checked.alreadylisted').map(function () {
        return this.value;
      }).get(); // ["18", "55", "10"]
    var myJoinedString = values.join(',')+",";
    if (myJoinedString != ",")
    {
      $("#rfqemail").val(myJoinedString);
    }
  }

  $( "#draftactuvate" ).click(function() {
    $( "#rfqactiveme" ).val("0");
    bootbox.alert("Please wait while we update your RFQ data");
    $( "#rfqformdata" ).submit();
  });

    $('#rfqcurrency').val("<?php echo $rfqm[0]->rfq_pref_currency;?>");

    var fsubmit=0;
    $( "#activerfq" ).click(function( event ) {
      if ( validate_all()== true)
      {
      }
      else
      {
        return false;
      }

      bootbox.confirm("Abrasivesworld facilitates this features as a platform to  encourage closer engagement among the abrasives communities. Abrasivesworld does not participate in the commercial dealings between the buyers and sellers and therefore shall not be held liable to the outcome of the commercial activities between the parties", auth_submit);
    });

    function auth_submit(e)
    {
      if(e==true)
      {
        fsubmit=1;
        bootbox.alert("Please wait while we update your RFQ data");
        $( "#rfqformdata" ).submit();
      }
    }

    function  validate_all()
    {
      var r=true;
      if ( $( "#rfqtitle" ).val().length <= 3 )
      {
       $("#rfqtitle").focus();
       alert("<?php echo dp($info_holder,"Enter the RFQ Title -  at least 4 characters")?>");
       r=false;
       $("#rfqtitle").focus();
       return false;
     }
     if ( $( "#rfqissuedby" ).val().length <= 3 )
     {
       $("#rfqissuedby").focus();
       alert("<?php echo dp($info_holder,"Enter the RFQ Issue By -  at least 4 characters")?>");
       r=false;
       $("#rfqissuedby").focus();
       return false;
     }

     if ( $( "#rfqcimports" ).val().length <= 3 )
     {
       $("#rfqcimports").focus();
       alert("<?php echo dp($info_holder,"Enter Country Of Imports -  at least 4 characters")?>");
       r=false;
       $("#rfqcimports").focus();
       return false;
     }
     if ( $( "#rfqcexports" ).val().length <= 3 )
     {
       alert("<?php echo dp($info_holder,"Select the RFQ Export Country")?>");
       r=false;
       $( "#rfqcexports" ).focus();
       return false;
     }
     if ( $( "#rfq_closedate" ).val().length <= 3 )
     {
       alert("<?php echo dp($info_holder,"Select the RFQ Close Date")?>");
       r=false;
       $( "#rfq_closedate" ).focus();
       return false;
     }

     $( ".stritemcdesc" ).each(function( index ) {
       gt=this;
       var eval=this.value;
       if (eval.length <= 2)
       {
         alert("<?php echo dp($info_holder,"Enter the Commodity description -  at least 3 characters")?>");
         this.focus();
         r=false;
         return false;
       }
       
     });
     if (r==false)
     {
      return false;
    }

    $( ".stritemspec" ).each(function( index ) {
     gt=this;
     var eval=this.value;
     if (eval.length <= 2)
     {
       alert("<?php echo dp($info_holder,"Enter the Specification - at least 3 characters")?>");
       this.focus();
       r=false;
       return false;
     }
     
   });
    if (r==false)
    {
      return false;
    }
    $( ".stritemdim" ).each(function( index ) {
     gt=this;
     var eval=this.value;
     if (eval.length <= 0)
     {
       alert("<?php echo dp($info_holder,"Enter the Dimension")?>");
       this.focus();
       r=false;
       return false;
     }
     
   });
    if (r==false)
    {
      return false;
    }


    $( ".stritemquan" ).each(function( index ) {
     gt=this;
     var eval=this.value;
     if (eval.length <= 0)
     {
       alert("<?php echo dp($info_holder,"Enter the Quantity")?>");
       this.focus();
       r=false;
       return false;
     }
     
   });
    if (r==false)
    {
      return false;
    }

    $( ".numitemreqp" ).each(function( index ) {
     gt=this;
     var eval=this.value;
     if ($.isNumeric(eval)==false)
     {
       alert("<?php echo dp($info_holder,"Enter numeric value for Requested Price")?>");
       this.focus();
       r=false;
       return false;
     }
     
   });
    return r;
  }

  function update_serialno()
  {
    var rno=Number($('#rfqtable >tbody >tr').length)-1;
    var sno=Number(1);
    for(i=0;i <= rno;i++)
    {
      $('#rfqtable >tbody >tr').eq(i).find('input:text').eq(0).val(sno);
      sno=sno+1;
    }

  }


  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
  var gd; 


  var checkout = $('#rfq_closedate').datepicker({
    onRender: function(date) {
      return date.valueOf() <= now ? 'disabled' : '';
    }
  }).on('changeDate', function(ev) {
    checkout.hide();
  }).data('datepicker');

$(document).ready(function() {
  // Tooltip only Text
  $('.masterTooltip').hover(function(){
    // Hover over code
    var title = $(this).attr('title');
    $(this).data('tipText', title).removeAttr('title');
    $('<p class="tooltipc"></p>')
    .text(title)
    .appendTo('body')
    .fadeIn('slow');
  }, function() {
    // Hover out code
    $(this).attr('title', $(this).data('tipText'));
    $('.tooltipc').remove();
  }).mousemove(function(e) {
    var mousex = e.pageX + 20; //Get X coordinates
    var mousey = e.pageY + 10; //Get Y coordinates
    $('.tooltipc')
    .css({ top: mousey, left: mousex })
  });

<?php 
if ( $RFQ_GROUP== true);
{
  echo "
  $('#sendviagroup').prop('checked', true);
  $('#jshowbygroup').show();

  ";

}

if ($rfqm[0]->rfq_email != "")
{
  echo "
  $('#jshowbyemailc').prop('checked', true);
  $('#jshowbyemail').show();

  ";

}
?>		
});

$('#sendviagroup').change(function() {
  if($("#sendviagroup").is(":checked"))
  {
    $('#jshowbygroup').show();
  }
  else
  {
    $('#jshowbygroup').hide();
  }
});

</script>