<?php
function module_split(& $mdata,$mname) {
  $ms=explode(":",$mdata);
  $v=false;
  foreach($ms as &$value)
  {
    if($value==$mname)
    {
      $v=true;
      break;
    }
  }
  return $v;
}
function rfq_no($ucountry,$comp) {
  $r=strtoupper(substr($comp,0,2)).strtoupper(substr($ucountry,0,3)).date('d').date('m').date('Y').strtoupper(substr(sha1(rand()), 0, 5));
  return  $r;
}
function GUID() {
  if (function_exists('com_create_guid') === true)
  {
    return trim(com_create_guid(), '{}');
  }

  return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function useremaildata(& $audata) {
  $dyd="";
  $v=0;
  foreach($audata as &$value)
  {
    $v=1;
    if ($value->user_email != "")
    {
      $dyd .='<div class="checkbox"><label><input type="checkbox" class="alreadylisted" value="'.htmlspecialchars($value->user_email).'" >'.htmlspecialchars($value->user_email).'</label></div>';
    }
  }
  if ( $v==1)
  {
    return $dyd;
  }
  else
  {
    return "";
  }
}
function useremaildata_popup(& $audata) {
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
function dp(& $info_holderdy,$f) {
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
function is_selected($arrd,$fdat) {
  $pieces = explode(",", $arrd);
  foreach($pieces as &$value)
  {

    if (strtolower($value) == strtolower($fdat))
    {
      return "checked";
    }
  }
}
function build_group_selection(& $data, & $ih,$ps) {
  $sel="";
  foreach($data as $row)
  {
    if ($row['uselectiontext']=="Others, please specify")
    {
      $sel .= '<div class="checkbox"> <label> <input  type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> '.dp($ih,'Others not listed above').'</label></div>';
    }
    else
    {
      $sel .= '<div class="checkbox">  <label> <input type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> '.dp($ih,$row['uselectiontext']).'</label></div>';

    }
  }
  $sel .="";
  return $sel;
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
<div class="container" style="background:whitesmoke;"> <!-- MAIN CONTAINER START -->

  <div class="row nav-row" style="margin-top:10px">
    <div class="col-md-3">
      <div><span class="glyphicon glyphicon-user"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/my_profile"><?php echo dp($info_holder,"Edit my profile");?></a></div>
    </div>
    <div class="col-md-3">

      <div><span class="glyphicon glyphicon-lock"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></div>
    </div>
    <div class="col-md-3">

      <div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management System");?></a></div>
    </div>
    <div class="col-md-3 active">

      <div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>rfq"><?php echo dp($info_holder,"Request for quotation");?></a></div>
    </div>
  </div>


  <div  style="margin-top:10px;"> 
    <div class="row nav-row" style="text-align:center">
      <div class="col-md-3 col-centered" style="text-align:center">
        <div style="padding-top:5px;padding-bottom:5px;">          
          <a style="font-weight:100" href="<?php echo base_url();?>rfq"><i class="fa fa-pencil fa-fw"></i><?php echo dp($info_holder,"Create a new RFQ");?></a>
        </div>
      </div>
      <div class="col-md-3 col-centered">
        <div style="padding-top:5px;padding-bottom:5px;text-align:center;">
          <a style="font-weight:100" href="<?php echo base_url();?>rfq/rfq_manage"><i class="fa fa-book fa-fw"></i><?php echo dp($info_holder,"Manage my RFQ");?></a>
        </div>
      </div>
      
      <div class="col-md-3 col-centered">
        <div style="padding-top:5px;padding-bottom:5px;" style="text-align:center">
        <span class="fa fa-info-circle"></span>  
          <a style="font-weight:100" href="<?php echo  base_url();?>help" target="_"><?php echo dp($info_holder,"Help");?></a>
        </div>
      </div>

    </div>
  </div>
  <?php
  if (module_split($subsd[0]->subs_module,"sub_onceweekly")==true or $adu[0]->recordno==1)
  {
  ?>
    <div id="mainFormRFQ">
     <div id="rfqLabel">
       <h2 style="font-weight:100"><?php echo dp($info_holder,"new RFQ");?></h2>
     </div>
     <form id="rfqformdata"  class="form-horizontal" action="rfq/rfq_save" method="post" enctype="multipart/form-data">
      <div class="row" style="margin-top:10px">
        <div class="col-xs-12 col-md-3">
          <label class="control-label"><?php echo dp($info_holder,"RFQ Number");?></label>
        </div>
        <div class="col-xs-12 col-md-3">
          <input type="text" class="form-control" name="rfqno" id="rfqno" value="<?php echo rfq_no($adu[0]->user_country,$adu[0]->user_orgname);?>" required="required" readonly/>
        </div>
        <div class="col-xs-12 col-md-3">
          <label class="control-label"><?php echo dp($info_holder,"RFQ Title");?>*</label>
        </div>
        <div class="col-xs-12 col-md-3">
          <input type="text" class="form-control" name="rfqtitle"  id="rfqtitle" value="" required="required"/>
        </div>
      </div>

      <div class="row" style="margin-top:10px">
        <div class="col-xs-12 col-md-3">
          <label class="control-label"><?php echo dp($info_holder,"RFQ Issued By");?>*</label>
        </div>
        <div class="col-xs-12 col-md-3">
          <input type="text" class="form-control" name="rfqissuedby"  id="rfqissuedby" value="<?php echo $adu[0]->user_name;?>" required="required"/>
        </div>
        <div class="col-xs-12 col-md-3">
          <label class="control-label"><?php echo dp($info_holder,"Registered Company Name");?>*</label>
        </div>
        <div class="col-xs-12 col-md-3">
          <input type="text" class="form-control" name="rfqcname"  id="rfqcname" value="<?php echo $adu[0]->user_orgname;?>" required="required" readonly/>
        </div>
      </div>

      <div class="row" style="margin-top:10px">
        <div class="col-xs-12 col-md-3">
          <label class="control-label"><?php echo dp($info_holder,"RFQ Issue Date");?>*</label>
        </div>
        <div class="col-xs-12 col-md-3">
          <input type="text" class="form-control" name="rfq_issuedate"  id="rfq_issuedate" value="" required="required" readonly/>
        </div>
        <div class="col-xs-12 col-md-3">
          <label class="control-label"><?php echo dp($info_holder,"RFQ Close Date");?>*</label>
        </div>
        <div class="col-xs-12 col-md-3">
         <input type="text" class="form-control" name="rfq_closedate"  id="rfq_closedate" value="" required="required"/>
       </div>
     </div>

     <div class="row" style="margin-top:10px">
      <div class="col-xs-12 col-md-3">
        <label class="control-label"><?php echo dp($info_holder,"Country of Imports");?>*</label>
      </div>
      <div class="col-xs-12 col-md-3">
        <input type="text" class="form-control" name="rfqcimports"  id="rfqcimports" value="<?php echo $adu[0]->user_country;?>" required="required"/>
      </div>
      <div class="col-xs-12 col-md-3">
        <label class="control-label"><?php echo dp($info_holder,"Preferred country of export");?>*</label>
      </div>
      <div class="col-xs-12 col-md-3">
        <input type="text" class="form-control" name="rfqcexports"  id="rfqcexports" data-items="4" data-provide="typeahead" value="" required="required"/>
      </div>
    </div>

    <div class="row" style="margin-top:10px">
      <div class="col-xs-12 col-md-3">
        <label class="control-label"><?php echo dp($info_holder,"Preferred currency");?>*</label>
      </div>
      <div class="col-xs-12 col-md-3">
        <select name="rfqcurrency" id="rfqcurrency" class="form-control">
          <option value="USD" selected>US Dollars</option>
          <option value="EUR">EURO</option>
          <option value="YUAN">Yuan Renminbi</option>
          <option value="AFA">Afghani</option>
          <option value="AFN">Afghani</option><option value="ALK">Albanian old lek</option><option value="ALL">Lek</option><option value="DZD">Algerian Dinar</option><option value="USD">US Dollar</option><option value="ADF">Andorran Franc</option><option value="ADP">Andorran Peseta</option><option value="AOR">Angolan Kwanza Readjustado</option><option value="AON">Angolan New Kwanza</option><option value="AOA">Kwanza</option><option value="XCD">East Caribbean Dollar</option><option value="ARA">Argentine austral</option><option value="ARS">Argentine Peso</option><option value="ARL">Argentine peso ley</option><option value="ARM">Argentine peso moneda nacional</option><option value="ARP">Peso argentino</option><option value="AMD">Armenian Dram</option><option value="AWG">Aruban Guilder</option><option value="AUD">Australian Dollar</option><option value="ATS">Austrian Schilling</option><option value="AZM">Azerbaijani manat</option><option value="AZN">Azerbaijanian Manat</option><option value="BSD">Bahamian Dollar</option><option value="BHD">Bahraini Dinar</option><option value="BDT">Taka</option><option value="BBD">Barbados Dollar</option><option value="BYR">Belarussian Ruble</option><option value="BEC">Belgian Franc (convertible)</option><option value="BEF">Belgian Franc (currency union with LUF)</option><option value="BEL">Belgian Franc (financial)</option><option value="BZD">Belize Dollar</option><option value="XOF">CFA Franc BCEAO</option><option value="BMD">Bermudian Dollar</option><option value="INR">Indian Rupee</option><option value="BTN">Ngultrum</option><option value="BOP">Bolivian peso</option><option value="BOB">Boliviano</option><option value="BOV">Mvdol</option><option value="BAM">Convertible Marks</option><option value="BWP">Pula</option><option value="NOK">Norwegian Krone</option><option value="BRC">Brazilian cruzado</option><option value="BRB">Brazilian cruzeiro</option><option value="BRL">Brazilian Real</option><option value="BND">Brunei Dollar</option><option value="BGN">Bulgarian Lev</option><option value="BGJ">Bulgarian lev A/52</option><option value="BGK">Bulgarian lev A/62</option><option value="BGL">Bulgarian lev A/99</option><option value="BIF">Burundi Franc</option><option value="KHR">Riel</option><option value="XAF">CFA Franc BEAC</option><option value="CAD">Canadian Dollar</option><option value="CVE">Cape Verde Escudo</option><option value="KYD">Cayman Islands Dollar</option><option value="CLP">Chilean Peso</option><option value="CLF">Unidades de fomento</option><option value="CNX">Chinese People's Bank dollar</option><option value="COP">Colombian Peso</option><option value="COU">Unidad de Valor real</option><option value="KMF">Comoro Franc</option><option value="CDF">Franc Congolais</option><option value="NZD">New Zealand Dollar</option><option value="CRC">Costa Rican Colon</option><option value="HRK">Croatian Kuna</option><option value="CUP">Cuban Peso</option><option value="CYP">Cyprus Pound</option><option value="CZK">Czech Koruna</option><option value="CSK">Czechoslovak koruna</option><option value="CSJ">Czechoslovak koruna A/53</option><option value="DKK">Danish Krone</option><option value="DJF">Djibouti Franc</option><option value="DOP">Dominican Peso</option><option value="ECS">Ecuador sucre</option><option value="EGP">Egyptian Pound</option><option value="SVC">Salvadoran colon</option><option value="EQE">Equatorial Guinean ekwele</option><option value="ERN">Nakfa</option><option value="EEK">Kroon</option><option value="ETB">Ethiopian Birr</option><option value="FKP">Falkland Island Pound</option><option value="FJD">Fiji Dollar</option><option value="FIM">Finnish Markka</option><option value="FRF">French Franc</option><option value="XFO">Gold-Franc</option><option value="XPF">CFP Franc</option><option value="GMD">Dalasi</option><option value="GEL">Lari</option><option value="DDM">East German Mark of the GDR (East Germany)</option><option value="DEM">Deutsche Mark</option><option value="GHS">Ghana Cedi</option><option value="GHC">Ghanaian cedi</option><option value="GIP">Gibraltar Pound</option><option value="GRD">Greek Drachma</option><option value="GTQ">Quetzal</option><option value="GNF">Guinea Franc</option><option value="GNE">Guinean syli</option><option value="GWP">Guinea-Bissau Peso</option><option value="GYD">Guyana Dollar</option><option value="HTG">Gourde</option><option value="HNL">Lempira</option><option value="HKD">Hong Kong Dollar</option><option value="HUF">Forint</option><option value="ISK">Iceland Krona</option><option value="ISJ">Icelandic old krona</option><option value="IDR">Rupiah</option><option value="IRR">Iranian Rial</option><option value="IQD">Iraqi Dinar</option><option value="IEP">Irish Pound (Punt in Irish language)</option><option value="ILP">Israeli lira</option><option value="ILR">Israeli old sheqel</option><option value="ILS">New Israeli Sheqel</option><option value="ITL">Italian Lira</option><option value="JMD">Jamaican Dollar</option><option value="JPY">Yen</option><option value="JOD">Jordanian Dinar</option><option value="KZT">Tenge</option><option value="KES">Kenyan Shilling</option><option value="KPW">North Korean Won</option><option value="KRW">Won</option><option value="KWD">Kuwaiti Dinar</option><option value="KGS">Som</option><option value="LAK">Kip</option><option value="LAJ">Lao kip</option><option value="LVL">Latvian Lats</option><option value="LBP">Lebanese Pound</option><option value="LSL">Loti</option><option value="ZAR">Rand</option><option value="LRD">Liberian Dollar</option><option value="LYD">Libyan Dinar</option><option value="CHF">Swiss Franc</option><option value="LTL">Lithuanian Litas</option><option value="LUF">Luxembourg Franc (currency union with BEF)</option><option value="MOP">Pataca</option><option value="MKD">Denar</option><option value="MKN">Former Yugoslav Republic of Macedonia denar A/93</option><option value="MGA">Malagasy Ariary</option><option value="MGF">Malagasy franc</option><option value="MWK">Kwacha</option><option value="MYR">Malaysian Ringgit</option><option value="MVQ">Maldive rupee</option><option value="MVR">Rufiyaa</option><option value="MAF">Mali franc</option><option value="MTL">Maltese Lira</option><option value="MRO">Ouguiya</option><option value="MUR">Mauritius Rupee</option><option value="MXN">Mexican Peso</option><option value="MXP">Mexican peso</option><option value="MXV">Mexican Unidad de Inversion (UDI)</option><option value="MDL">Moldovan Leu</option><option value="MCF">Monegasque franc (currency union with FRF)</option><option value="MNT">Tugrik</option><option value="MAD">Moroccan Dirham</option><option value="MZN">Metical</option><option value="MZM">Mozambican metical</option><option value="MMK">Kyat</option><option value="NAD">Namibia Dollar</option><option value="NPR">Nepalese Rupee</option><option value="NLG">Netherlands Guilder</option><option value="ANG">Netherlands Antillian Guilder</option><option value="NIO">Cordoba Oro</option><option value="NGN">Naira</option><option value="OMR">Rial Omani</option><option value="PKR">Pakistan Rupee</option><option value="PAB">Balboa</option><option value="PGK">Kina</option><option value="PYG">Guarani</option><option value="YDD">South Yemeni dinar</option><option value="PEN">Nuevo Sol</option><option value="PEI">Peruvian inti</option><option value="PEH">Peruvian sol</option><option value="PHP">Philippine Peso</option><option value="PLZ">Polish zloty A/94</option><option value="PLN">Zloty</option><option value="PTE">Portuguese Escudo</option><option value="TPE">Portuguese Timorese escudo</option><option value="QAR">Qatari Rial</option><option value="RON">New Leu</option><option value="ROL">Romanian leu A/05</option><option value="ROK">Romanian leu A/52</option><option value="RUB">Russian Ruble</option><option value="RWF">Rwanda Franc</option><option value="SHP">Saint Helena Pound</option><option value="WST">Tala</option><option value="STD">Dobra</option><option value="SAR">Saudi Riyal</option><option value="RSD">Serbian Dinar</option><option value="CSD">Serbian Dinar</option><option value="SCR">Seychelles Rupee</option><option value="SLL">Leone</option><option value="SGD">Singapore Dollar</option><option value="SKK">Slovak Koruna</option><option value="SIT">Slovenian Tolar</option><option value="SBD">Solomon Islands Dollar</option><option value="SOS">Somali Shilling</option><option value="ZAL">South African financial rand (Funds code) (discont</option><option value="ESP">Spanish Peseta</option><option value="ESA">Spanish peseta (account A)</option><option value="ESB">Spanish peseta (account B)</option><option value="LKR">Sri Lanka Rupee</option><option value="SDD">Sudanese Dinar</option><option value="SDP">Sudanese Pound</option><option value="SDG">Sudanese Pound</option><option value="SRD">Surinam Dollar</option><option value="SRG">Suriname guilder</option><option value="SZL">Lilangeni</option><option value="SEK">Swedish Krona</option><option value="CHE">WIR Euro</option><option value="CHW">WIR Franc</option><option value="SYP">Syrian Pound</option><option value="TWD">New Taiwan Dollar</option><option value="TJS">Somoni</option><option value="TJR">Tajikistan ruble</option><option value="TZS">Tanzanian Shilling</option><option value="THB">Baht</option><option value="TOP">Pa'anga</option><option value="TTD">Trinidata and Tobago Dollar</option><option value="TND">Tunisian Dinar</option><option value="TRY">New Turkish Lira</option><option value="TRL">Turkish lira A/05</option><option value="TMM">Manat</option><option value="RUR">Russian rubleA/97</option><option value="SUR">Soviet Union ruble</option><option value="UGX">Uganda Shilling</option><option value="UGS">Ugandan shilling A/87</option><option value="UAH">Hryvnia</option><option value="UAK">Ukrainian karbovanets</option><option value="AED">UAE Dirham</option><option value="GBP">Pound Sterling</option><option value="UYU">Peso Uruguayo</option><option value="UYN">Uruguay old peso</option><option value="UYI">Uruguay Peso en Unidades Indexadas</option><option value="UZS">Uzbekistan Sum</option><option value="VUV">Vatu</option><option value="VEF">Bolivar Fuerte</option><option value="VEB">Venezuelan Bolivar</option><option value="VND">Dong</option><option value="VNC">Vietnamese old dong</option><option value="YER">Yemeni Rial</option><option value="YUD">Yugoslav Dinar</option><option value="YUM">Yugoslav dinar (new)</option><option value="ZRN">Zairean New Zaire</option><option value="ZRZ">Zairean Zaire</option><option value="ZMK">Kwacha</option><option value="ZWD">Zimbabwe Dollar</option><option value="ZWC">Zimbabwe Rhodesian dollar</option>
        </select>
      </div>
      <div class="col-xs-12 col-md-3">
        <label class="control-label"><?php echo dp($info_holder,"Quotation validity duration");?>*</label>
      </div>
      <div class="col-xs-12 col-md-3">
       <select name="rfqqval" id="rfqqval" class="form-control">
        <option value="1"><?php echo dp($info_holder,"One month");?></option>
        <option value="2"><?php echo dp($info_holder,"Two months");?></option>
        <option value="3" selected><?php echo dp($info_holder,"Three months");?></option>
        <option value="6"><?php echo dp($info_holder,"Six months");?></option>
        <option value="12"><?php echo dp($info_holder,"One year");?></option>
      </select>
    </div>
  </div>

  <div class="row" style="margin-top:10px">
    <div class="col-xs-12 col-md-3">
      <label class="control-label"><?php echo dp($info_holder,"Incoterm");?>*</label>
    </div>
    <div class="col-xs-12 col-md-3">
      <select name="rfqincoterm" id="rfqincoterm" class="form-control">
        <option value="EXW" selected>EXW</option>
        <option value="FOB">FOB</option>
        <option value="CIF">CIF</option>
        <option value="DDU">DDU</option>
        <option value="DDP">DDP</option>
        <option value="Others">Others</option>
      </select>
    </div>
    <div class="col-xs-12 col-md-3">
      <label class="control-label"><?php echo dp($info_holder,"Partial Shipment Allowed");?></label>
    </div>
    <div class="col-xs-12 col-md-3">
      <select name="rfqpship" id="rfqpship" class="form-control">
        <option value="yes"><?php echo dp($info_holder,"Yes");?></option>
        <option value="no" selected><?php echo dp($info_holder,"No");?></option>
        <option value="na"><?php echo dp($info_holder,"N/A");?></option>
      </select>
    </div>
  </div>

  <div style="margin-top:10px">
    <div class="checkbox">
      <label style="font-weight:bold;" data-toggle="tooltip" data-placement="left" title="By using “By member’s group”, your RFQ shall be qualified by Abrasivesworld before sending to its member groups. It is to ensure no irresponsible RFQ is sent out. It may take 2-3 days before reaching the member in the group selected">
        <input type="checkbox"  value="posthome" name="posthome" id="sendviagroup" > <?php echo dp($info_holder,"Send this RFQ via members group");?>
      </label>
    </div>
  </div>

  <div id="jshowbygroup" style="display:none;margin-top:10px;margin-left:5px">
    <?php echo build_group_selection($usergroupinfo,$info_holder,'');?>
  </div>

  <div>
    <div class="checkbox">
      <label style="font-weight:bold;" data-toggle="tooltip" data-placement="left" title="By using “Sender assigned email”, your RFQ will be viewed by the email receiver with you in copy. Other email receiver will not be able to see other email addresses that you may have added">
        <input type="checkbox" value="jshowbyemailc" name="jshowbyemailc" id="jshowbyemailc" ><?php echo dp($info_holder,"Send this RFQ via email");?>
      </label>
    </div>
  </div>
  <div id="jshowbyemail" style="display:none">
   <div class="row">
     <div class="col-xs-12 col-md-3">
       <input type="text" name="rfqemail" class="typeahead form-control" id="rfqemail"  value="" />
     </div>
     <div class="col-xs-12 col-md-4">
       <input  type="button" class="btn btn-u form-control" value="<?php echo dp($info_holder,"select from your previous entry");?>" onclick='show_previous_entry();'  />
     </div>
   </div>
   <div>
     <b><?php echo dp($info_holder,'You can enter one or more email address by using "," to separate 2 addresses. For example email1@domain.com,email2@domain.com');?>
     </b>
   </div>
 </div>

 <div id="rfqInformation" style="margin-top:5px">
   <div id="rfqLabel">
     <h2 style="font-weight:100"><?php echo dp($info_holder,"RFQ information");?></h2>
   </div>
   <div class="table-responsive">
     <table class="table table-bordered table-hover" id="RFQDataEntryTable">
       <thead id="rfqDataHeader">
         <tr>
          <th><?php echo dp($info_holder,"S/N");?></th>
          <th><?php echo dp($info_holder,"Commodity description");?>*</th>
          <th><?php echo dp($info_holder,"Specification");?>*</th>
          <th><?php echo dp($info_holder,"Dimension");?>*</th>
          <th><?php echo dp($info_holder,"Quantity");?>*</th>
          <th><?php echo dp($info_holder,"Unit of measurement");?>*</th>
          <th><?php echo dp($info_holder,"Requested Price");?></th>
          <th><?php echo dp($info_holder,"Requested Lead Time");?></th>
          <th></th>   
        </tr>
      </thead>
      <tbody id="rfqUserData">
       <tr id="RFQDataEntryInitRow">
         <td><input type="text" value="1" class="form-control" name="rfqtsn[]" readonly></td>
         <td><input type="text" class="form-control" name="rfqtcdesc[]" class="stritemcdesc"></td>
         <td><input type="text" class="form-control" name="rfqtspec[]" class="stritemspec"></td>
         <td><input type="text"class="form-control" name="rfqtdi[]" class="stritemdim" ></td>
         <td><input type="text" class="form-control" name="rfqtqu[]" class="stritemquan" ></td>
         <td>
           <select class="form-control" name="rfqtuom[]">
            <option value="Pieces">Pieces</option>
            <option value="Meters">Meters</option>
            <option value="Metersquare">Metersquare</option>
            <option value="Kilogram">Kilogram</option>
            <option value="Ton">Ton</option>
          </select>
        </td>
        <td><input type="text" class="form-control numitemreqp" onblur="rfqtotal()" name="rfqtreqprice[]" ></td>
        <td><input type="text" class="form-control" name="rfqtleadtime[]" ></td>
        <td></td>
      </tr>
    </tbody>
    <tfoot>
      <tr id="rfqDataFooter">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
      </tr>
    </tfoot>
  </table>
</div>


<div id="rfqDataAdd">
  <div class="row" style="margin-top:10px">
    <div class="col-xs-12 col-md-2">
      <span class="btn btn-u form-control light-weight-font" id="RFQDataNewEntry"><?php echo dp($info_holder,"Add S/N");?> </span>
    </div>
  </div>
</div>

<div id= "rfqMediaContent" style="margin-top:10px" class="light-weight-font">
  <div class="panel panel-default">
    <div class="panel-heading"><?php echo dp($info_holder,"Supporting Documents");?></div>
    <div class="panel-body">
      <div  id="attachRFQDocument">
        <div style="margin-top:5px;">
          <input  type="file"style="height:30px"  name='multipartFilePath[]' />
        </div>
      </div>
      <div class="row" style="margin-top:5px">
        <div class="col-xs-12 col-md-3">
          <span class="btn btn-u form-control light-weight-font"  id="addMoreRFQDocs"><?php echo dp($info_holder,"Add More Docs");?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="rfqSubmissionChoice">
  <div class="row">
    <div class="col-xs-12 col-md-2" style="margin-top:5px">
      <span class="btn btn-u form-control light-weight-font" id="saveRFQAsDraft"><?php echo dp($info_holder,"Save as Draft");?></span>
    </div>
    <div class="col-xs-12 col-md-2" style="margin-top:5px">
      <span class="btn btn-u form-control light-weight-font" id="activerfq"><?php echo dp($info_holder,"Save and post RFQ");?></span>
    </div>
    <div class="col-xs-12 col-md-2">
      <input type="hidden" name="rfqactiveme" id="rfqactiveme" value="1">
      <input type="hidden" value="<?php echo GUID();?>" name="rfqid">
    </div>
  </div>
</div>

</div>
</form>
</div>

<?php
} else {
?>
  <div class="alert alert-warning" style="text-align:center;margin-top:10px">
    <h1 style="font-weight:100"><?php echo dp($info_holder,"Hi, You are not subscribed to RFQ module.");?></h1>
    <p><a class="btn btn-primary btn-lg" role="button" href="account/my_profile#subscr_req"><?php echo dp($info_holder,"Click here to subscribe");?></a></p>
  </div>
  <?
}
?>



</div> <!-- MAIN CONTAINER ENDS -->


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
          <p><?php echo dp($info_holder,"Please wait, while we save your RFQ data.");?></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
     <input type='button' value='<?php echo dp($info_holder,"Remove");?>' onclick='remove_ue();' class='btn'>
     <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
   </div>
 </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }
  var istotaladded=0;
  $( "#RFQDataNewEntry" ).click(function() {
    addRFQDataEntry();
    rfqtotal();
  });

  function rfqtotal()
  {
    var gt=0;
    $('#RFQDataEntryTable tbody tr td:nth-child(7)').find("input").each(function() {
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
    $("#RFQDataEntryTable tfoot tr").remove();
    $('#RFQDataEntryTable tfoot').append(gr);

  }

  function update_serialno() {
    var rno=Number($('#RFQDataEntryTable >tbody >tr').length)-1;
    var sno=Number(1);
    for(i=0;i <= rno;i++)
    {
      $('#RFQDataEntryTable >tbody >tr').eq(i).find('input:text').eq(0).val(sno);
      sno=sno+1;
    }

  }
  function addRFQDataEntry() {
    var row = $("#RFQDataEntryInitRow").html();
    var rowCount = $('#RFQDataEntryTable >tbody >tr').length;
    $('#RFQDataEntryTable tbody').append('<tr>'+row+'</tr>');
    var s=Number($('#RFQDataEntryTable >tbody >tr').eq(rowCount-1).find('input:text').eq(0).val())+1;
    $('#RFQDataEntryTable >tbody >tr').eq(rowCount).find('input:text').eq(0).val(s);
    var rrem='<a href="javascript:;" class="btn btn-small"><i class="fa fa-trash-o fa-lg" onclick="rme(this)"></i></a>';
    $('#RFQDataEntryTable >tbody >tr').eq(rowCount).find("td:last").append(rrem);
    update_serialno();
  }
  var gtrace;
  function rme(rew) {
    var rowCount = $('#RFQDataEntryTable tbody tr').length;
    if (rowCount != 1)
    {
      $(rew.parentElement.parentElement.parentElement).remove();
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
 }
 .light-weight-font 
 {
  font-weight: 100;
}
</style>


<style>

  .nav-row {
    text-align: left;
  }
  .nav-row .col-md-3 {
    background-color: #fff;
    border: 1px solid #e0e1db;
    border-right: none;
    padding-bottom: 7px;
  }
  .nav-row .col-md-3:last-child {
    border: 1px solid #e0e1db;
  }
  .nav-row .col-md-3:first-child {
    border-radius: 5px 0 0 5px;
  }
  .nav-row .col-md-3:last-child {
    border-radius: 0 5px 5px 0;
  }
  .nav-row .col-md-3:hover {
    color: #687074;
    cursor: pointer;
  }
  .nav-row .active {
    color: #1ABB9C;
    margin-top: -2px;
    border-top: 3px solid #1ABB9C;
    border-bottom: 3px solid #1ABB9C;
  }
  .nav-row .active:before {
    content: '';
    position: absolute;
    border-style: solid;
    border-width: 6px 6px 0;
    border-color: #1ABB9C transparent;
    display: block;
    width: 0;
    z-index: 1;
    margin-left: -6px;
    top: 0;
    left: 50%;
  }
  .nav-row .glyphicon {
    padding-top: 8px;
    font-size: 15px;
  }
  .nav-row .col-md-6 {
    background-color: #fff;
    border: 1px solid #e0e1db;
    border-right: none;
  }
  .nav-row .col-md-6:last-child {
    border: 1px solid #e0e1db;
  }
  .nav-row .col-md-6:first-child {
    border-radius: 5px 0 0 5px;
  }
  .nav-row .col-md-6:last-child {
    border-radius: 0 5px 5px 0;
  }
  .nav-row .col-md-6:hover {
    color: #687074;
    cursor: pointer;
  }

  .glyphicon-refresh-animate
  {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
  }

  @-webkit-keyframes spin2
  {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
  }

  @keyframes spin
  {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
  }
</style>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>application/js/bootstrap3-typeahead.min.js"></script>
<script>
  var country_list = ['Others'];
  var country_listim = ['Others'];
  $('#rfqcexports').typeahead({source: country_list});
  $.getJSON('<?php echo base_url();?>general/country_list', function(data) {
   $.each(data, function(key, val) {
     country_list.push(val.country_name);
   });
 });

  $('#rfqcimports').typeahead({source: country_listim});
  $.getJSON('<?php echo base_url();?>general/country_list', function(data) {
   $.each(data, function(key, val) {
     country_listim.push(val.country_name);
   });
 });

  var adddoc = $('#attachRFQDocument').html();
  $( "#addMoreRFQDocs" ).click(function()
  {
    $('#attachRFQDocument').append(adddoc);
  });


  $( "#saveRFQAsDraft" ).click(function() {
    $( "#rfqactiveme" ).val("0");
    bootbox.alert("Please wait while we update your RFQ data");
    $( "#rfqformdata" ).submit();
  });
  function  validate_all() {
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

var fsubmit=0;
$( "#activerfq" ).click(function( event ) {
  if ( validate_all()== true)
  {
  }
  else
  {
    return false;
  }

  bootbox.confirm("<?php echo dp($info_holder,"Abrasivesworld facilitates this features as a platform to  encourage closer engagement among the abrasives communities. Abrasivesworld does not participate in the commercial dealings between the buyers and sellers and therefore shall not be held liable to the outcome of the commercial activities between the parties");?>", auth_submit);
});

function auth_submit(e) {
  if(e==true)
  {
    fsubmit=1;
    bootbox.alert("Please wait while we update your RFQ data");
    $( "#rfqformdata" ).submit();
  }
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

function show_previous_entry() {

  $("#myemailModal").modal();

}


function select_all_ue() {
  $('.alreadylisted').prop('checked', true);
}
function deselect_all_ue() {
  $('.alreadylisted').prop('checked', false);
}
function selected_ue() {
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
var gtr;
function remove_ue() {
  $("#myemailModal").modal('hide');
  var values = $('input:checkbox:checked.alreadylisted').map(function () {

    return this.value;
  }).get(); // ["18", "55", "10"]
  $('input:checkbox:checked.alreadylisted').map(function () {

    $(this.parentElement).remove();
  });

  var myJoinedString = values.join(',')+",";
  url="rfq/remove_email_entry";
  datafs={emails:myJoinedString};
  $.ajax({
    type: "POST",
    url: url,
    data: datafs
  });

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

$('#sendviagroup').change(function() {
  if($("#sendviagroup").is(":checked")) {
    $('#jshowbygroup').show();
  } else {
    $('#jshowbygroup').hide();
    $("#jshowbygroup").find("input:checked").attr("checked",false);
  }
});
</script>

<style>

  .nav-row {
    text-align: left;
  }
  .nav-row .col-md-3 {
    background-color: #fff;
    border: 1px solid #e0e1db;
    border-right: none;
    padding-bottom: 7px;
  }
  .nav-row .col-md-3:last-child {
    border: 1px solid #e0e1db;
  }
  .nav-row .col-md-3:first-child {
    border-radius: 5px 0 0 5px;
  }
  .nav-row .col-md-3:last-child {
    border-radius: 0 5px 5px 0;
  }
  .nav-row .col-md-3:hover {
    color: #687074;
    cursor: pointer;
  }
  .nav-row .active {
    color: #1ABB9C;
    margin-top: -2px;
    border-top: 3px solid #1ABB9C;
    border-bottom: 3px solid #1ABB9C;
  }
  .nav-row .active:before {
    content: '';
    position: absolute;
    border-style: solid;
    border-width: 6px 6px 0;
    border-color: #1ABB9C transparent;
    display: block;
    width: 0;
    z-index: 1;
    margin-left: -6px;
    top: 0;
    left: 50%;
  }
  .nav-row .glyphicon {
    padding-top: 8px;
    font-size: 15px;
  }
  .nav-row .col-md-6 {
    background-color: #fff;
    border: 1px solid #e0e1db;
    border-right: none;
  }
  .nav-row .col-md-6:last-child {
    border: 1px solid #e0e1db;
  }
  .nav-row .col-md-6:first-child {
    border-radius: 5px 0 0 5px;
  }
  .nav-row .col-md-6:last-child {
    border-radius: 0 5px 5px 0;
  }
  .nav-row .col-md-6:hover {
    color: #687074;
    cursor: pointer;
  }

  .glyphicon-refresh-animate
  {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
  }

  @-webkit-keyframes spin2
  {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
  }

  @keyframes spin
  {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
  }
</style>