<?php
function random_color_part()
{
	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
	return random_color_part() . random_color_part() . random_color_part();
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
function populate_docs(& $dd,& $l) {
	$r="";
	$rc=0;
	foreach ($dd as &$value) {
		$r .='<tr><td>'.$value->rfq_filename.'</td><td><a href="'.$value->rfq_linkname.'" target="_blank"> <i class="fa fa-cloud-download"></i> Download</a></td></tr>';
	}
	return $r;
}
function populate_uom($value) {
	$r="";
	if ($value=="Pieces") 	{
		$r .='<option value="Pieces" selected>Pieces</option>';
	} else 	{
		$r .='<option value="Pieces">Pieces</option>';
	} 

	if ($value=="Meters") 	{
		$r .= '<option value="Meters" selected>Meters</option>';
	} 	else 	{
		$r .= '<option value="Meters">Meters</option>';
	}

	if ($value=="Metersquare") 	{
		$r .= '<option value="Metersquare" selected>Metersquare</option>';

	} 	else 	{
		$r .= '<option value="Metersquare">Metersquare</option>';

	}
	if ($value=="Kilogram") 	{
		$r .= '<option value="Kilogram" selected>Kilogram</option>';
	} 	else 	{
		$r .= '<option value="Kilogram">Kilogram</option>';

	}
	if ($value=="Ton") 	{
		$r .= '<option value="Ton">Ton</option>';
	} 	else 	{
		$r .= '<option value="Ton">Ton</option>';
	}

	return $r;

}
function populate_rfq_table(& $langm,& $rfqtd) {
	$r="";
	$rr="";
	$rc=0;
	foreach ($rfqtd as &$value)  	{
		$bc=random_color();
		$rc=$rc+1;

		$r .='<tr id="initrfqrow">
		<td>
			<div class="btn-group-vertical">
				<button type="button" value="or" id="animateinitme" class="addbidme btn btn-default form-control" >Bid</button>
			</div>
		</td>
		<td>
			<input type="text" class="form-control" style="border:1px solid #'.$bc.'" '.'value="'.htmlspecialchars($value->serialno).'" name="rfqtsn[]" readonly />
		</td>
		<td>
			<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->cdesc).'" name="rfqtcdesc[]" readonly />
		</td>
		<td>
			<input type="text"  class="form-control" '.'value="'.htmlspecialchars($value->spec).'" name="rfqtspec[]" readonly />
		</td>

		<td>
			<input type="text"  class="form-control" '.'value="'.htmlspecialchars($value->dimension).'" name="rfqtdi[]"  readonly  />
		</td>

		<td>
			<input type="text"  class="form-control" '.'value="'.htmlspecialchars($value->quantity).'" name="rfqtqu[]"  readonly />
		</td>

		<td>
			<select class="form-control" name="rfqtuom[]"  readonly >
				'.populate_uom($value->uom).'
			</select>
		</td>
		<td>
			<input type="text"  class="form-control" onblur="rfqtotal()" '.'value="'.htmlspecialchars($value->reqprice).'" name="rfqtreqprice[]"  readonly />
		</td>
		<td>
			<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->reqleadtime).'" name="rfqtleadtime[]"  readonly />
			<input type="hidden"  value="1" name="isorig[]"/>

		</td>
		<td>
		</td>
	</tr>';

	$rr .='<tr id="initrfqrow" style="display:none">
	<td>
	</td>
	<td>
		<input type="text" class="form-control" style="border:1px solid #'.$bc.'" '.'value="'.htmlspecialchars($value->serialno).'" name="rfqtsn[]" readonly />
	</td>
	<td>
		<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->cdesc).'" name="rfqtcdesc[]" />
	</td>
	<td>
		<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->spec).'" name="rfqtspec[]" />
	</td>

	<td>
		<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->dimension).'" name="rfqtdi[]" />
	</td>

	<td>
		<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->quantity).'" name="rfqtqu[]" />
	</td>

	<td>
		<select  name="rfqtuom[]" class="form-control">
			'.populate_uom($value->uom).'
		</select>
	</td>
	<td>
		<input type="text"  class="form-control" onblur="rfqtotal()" '.'value="'.htmlspecialchars($value->reqprice).'" name="rfqtreqprice[]" />
	</td>
	<td>
		<input type="text" class="form-control" '.'value="'.htmlspecialchars($value->reqleadtime).'" name="rfqtleadtime[]" />
	</td>
	<td>
	</td>
</tr>';

}

return $r;
}
?>
<script>
	$(document).ready(function() {
	});
</script>
<style>
	.readonlyenabled
	{
		background-color:whitesmoke!important;
	}
	.iseditable
	{
		background-color:white !important;
	}
</style>
<script type="text/javascript" language="javascript" src="<?php echo  base_url(); ?>application/js/bootstrap3-typeahead.min.js"></script>
<div class="container" style="background:whitesmoke">


	<div id="mainFormRFQ">
		<div id="rfqLabel">
			<h2 style="font-weight:100"><?php echo dp($info_holder,"RFQ Bidding");?></h2>
		</div>

		<div id="rfqInstruction" style="margin-top:10px">
			<h4 style="font-weight:100;color:purple"><?php echo dp($info_holder,"Upload only necessary documents");?></h4>
			<h4 style="font-weight:100;color:purple"><?php echo dp($info_holder,"You can update the information which are not readonly");?></h4>
		</div>
		<form id="RFQBidSubmitForm" action="../../rfq/rfq_bid_submit" method="post" enctype="multipart/form-data">
			<div class="row" style="margin-top:10px">
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"RFQ Number");?></label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfqno" id="rfqno" value="<?php echo $rfqm[0]->rfq_no;?>"  readonly/>
				</div>
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"RFQ Title");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfqtitle"  id="rfqtitle" value="<?php echo $rfqm[0]->rfq_title;?>" readonly  />
				</div>
			</div>

			<div class="row" style="margin-top:10px">
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"RFQ Issued By");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfqissuedby"  id="rfqissuedby" value="<?php echo $rfqm[0]->rfq_issueby;?>" readonly  />
				</div>
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"Registered Company Name");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfqcname"  id="rfqcname" value="<?php echo $adu[0]->user_orgname;?>" readonly/>
				</div>
			</div>

			<div class="row" style="margin-top:10px">
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"RFQ Issue Date");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfq_issuedate"  id="rfq_issuedate" value=""  readonly/>
				</div>
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"RFQ Close Date");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfq_closedate"  id="rfq_closedate" value="<?php echo $rfqm[0]->rfq_close_date;?>" readonly   />
				</div>
			</div>

			<div class="row" style="margin-top:10px">
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"Country of Imports");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfqcimports"  id="rfqcimports" value="<?php echo $rfqm[0]->rfq_country_imports;?>" readonly   />
				</div>
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"Preferred country of export");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<input type="text" class="form-control" name="rfqcexports"  id="rfqcexports" data-items="4" data-provide="typeahead" value="<?php echo $rfqm[0]->rfq_pref_cn_export;?>" required="required"   />
				</div>
			</div>

			<div class="row" style="margin-top:10px">
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"Preferred currency");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<select name="rfqcurrency" id="rfqcurrency" class="form-control"   >
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
					<select name="rfqqval" id="rfqqval" class="form-control"   >
						<option value="1" <?php if( $rfqm[0]->rfq_quot_validation=="1"){ echo "selected";}?>><?php echo dp($info_holder,"One month");?></option>
						<option value="2" <?php if( $rfqm[0]->rfq_quot_validation=="2"){ echo "selected";}?>><?php echo dp($info_holder,"Two months");?></option>
						<option value="3" <?php if( $rfqm[0]->rfq_quot_validation=="3"){ echo "selected";}?>><?php echo dp($info_holder,"Three months");?></option>
						<option value="6" <?php if( $rfqm[0]->rfq_quot_validation=="6"){ echo "selected";}?>><?php echo dp($info_holder,"Six months");?></option>
						<option value="12" <?php if( $rfqm[0]->rfq_quot_validation=="12"){ echo "selected";}?>><?php echo dp($info_holder,"One year");?></option>

					</select>
				</div>
			</div>

			<div class="row" style="margin-top:10px">
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"Incoterm");?>*</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<select name="rfqincoterm" id="rfqincoterm" class="form-control"   >
						<option value="EXW" <?php if( $rfqm[0]->rfq_incoterm=="EXW"){ echo "selected";}?>>EXW</option>
						<option value="FOB" <?php if( $rfqm[0]->rfq_incoterm=="FOB"){ echo "selected";}?>>FOB</option>
						<option value="CIF" <?php if( $rfqm[0]->rfq_incoterm=="CIF"){ echo "selected";}?>>CIF</option>
						<option value="DDU" <?php if( $rfqm[0]->rfq_incoterm=="DDU"){ echo "selected";}?>>DDU</option>
						<option value="DDP" <?php if( $rfqm[0]->rfq_incoterm=="DDP"){ echo "selected";}?>>DDP</option>
						<option value="Others" <?php if( $rfqm[0]->rfq_incoterm=="Others"){ echo "selected";}?>>Others</option>

					</select>
				</div>
				<div class="col-xs-12 col-md-3">
					<label class="control-label"><?php echo dp($info_holder,"Partial Shipment Allowed");?></label>
				</div>
				<div class="col-xs-12 col-md-3">
					<select name="rfqpship" id="rfqpship" class="form-control"   >
						<option value="yes" <?php if( $rfqm[0]->rfq_partial=="yes"){ echo "selected";}?>><?php echo dp($info_holder,"Yes");?></option>
						<option value="no" <?php if( $rfqm[0]->rfq_partial=="no"){ echo "selected";}?>><?php echo dp($info_holder,"No");?></option>
						<option value="na" <?php if( $rfqm[0]->rfq_partial=="na"){ echo "selected";}?>><?php echo dp($info_holder,"N/A");?></option>

					</select>
				</div>
			</div>


			<div id="rfqLabel" style="margin-top:10px">
				<h2 style="font-weight:100"><?php echo dp($info_holder,"RFQ information");?></h2>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="RFQDataEntryTable">
					<thead id="rfqDataHeader">
						<tr>
							<th><?php echo dp($info_holder,"Bid Action");?></th>
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
						<?php  echo populate_rfq_table($info_holder,$rfqt); ?>
					</tbody>
					<tfoot>
						<tr id="rfqDataFooter"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					</tfoot>
				</table>
			</div>

			<div id= "rfqMediaContentPrevious" style="margin-top:10px" class="light-weight-font">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo dp($info_holder,"Previously Attached Documents");?></div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="RFQMediaContentAttached">
								<thead>
									<th><?php echo dp($info_holder,"File Name");?></th>
									<th><?php echo dp($info_holder,"Download Link");?></th>
								</thead>
								<tbody>
									<?php echo populate_docs($rfqd,$info_holder);?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div id= "rfqMediaContent"  class="light-weight-font">
				<div class="panel panel-default" style="margin-top:10px">
					<div class="panel-heading"><?php echo dp($info_holder,"Bidder Supporting Documents");?></div>
					<div class="panel-body">
						<div  id="attachRFQDocument">
							<div style="margin-top:5px;">
								<input  type="file"    name='multipartFilePath[]' />
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

			<div id="rfqSubmissionChoice"  >
				<div class="row">
					<div class="col-xs-12 col-md-2" style="display:none">
						<input type="hidden" name="rfqactiveme" id="rfqactiveme" value="1">
						<input type="hidden" value="<?php echo $RFQGUID;?>" name="rfqid">
					</div>
					<div class="col-xs-12 col-md-3" style="margin-top:5px">
						<input type="submit" class="btn btn-u form-control" value="<?php echo dp($info_holder,"Submit Bid");?>">
					</div>

				</div>
			</div>
		</form>
	</div>
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
					<p><?php echo dp($info_holder,"Please wait, while we update your bidding information.");?></p>
				</div>
			</div>
			<div class="modal-footer">
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
	$( "#RFQDataEntryTableadd" ).click(function() {
		add_rfq();
		rfqtotal();
	});

	function rfqtotal()
	{
		return;
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
	function add_rfq()
	{
		var row = $("#initrfqrow").html();
		$('#RFQDataEntryTable tbody').append('<tr>'+row+'</tr>');
	}
	var gtrace;
	function rme(rew)
	{
		var rowCount = $('#RFQDataEntryTable tbody tr').length;
		if (rowCount != 1)
		{
			var gi = rew.parentElement.parentElement.parentElement;
			gi.parentNode.removeChild(gi);

//rfqtotal();
}
}
</script>
<script>
	var country_list = ['Others'];

	$('#rfqcexports').typeahead({source: country_list});
	$.getJSON('<?php echo base_url();?>general/country_list', function(data) {
		$.each(data, function(key, val) {
			country_list.push(val.country_name);  
		});
	});
	var adddoc = $('#attachRFQDocument').html();
	$( "#addMoreRFQDocs" ).click(function() 
	{
		$('#attachRFQDocument').append(adddoc);
	});
	var gtrace;
	$(document).on('click', '.addbidme', function()
	{
		var ritem=this;
		gtrace=this;

		if ($(ritem).val() == ""  || $(ritem).val() == "or")
		{
			if ($(ritem).text()=="Original Information")
			{
				return;
			}
		}
		$(gtrace).text("Add More Bid");
		var rowIndex = gtrace.parentElement.parentElement.parentElement.rowIndex-1;
		var thisRow = $("#RFQDataEntryTable tbody tr").eq(rowIndex);
		var cc=$( thisRow ).clone();
		$("#RFQDataEntryTable tbody tr").eq(rowIndex).after(cc);

		var newRow = $("#RFQDataEntryTable tbody tr").eq(rowIndex+1);

		if ($(ritem).val() == ""  || $(ritem).val() == "or")
		{
			$(ritem).text("Original Information");
//$(ritem).addClass('disabled');
var guidi=guid();
$(ritem).attr('tokenid', guidi);
$( newRow ).find( 'button').attr("id","addbidme");
$( newRow ).find( 'button').after('<button type="button" class="btn btn-danger form-control" onclick="rme(this);">Remove</button>')
$( newRow ).find( 'button' ).val("sec");
$( newRow ).find( 'input:hidden' ).val("2");
$( newRow ).find( 'button' ).attr('tokenid', guidi);
}

$( newRow ).find( 'input:text' ).removeAttr("readonly");
$( newRow ).find( 'select' ).removeAttr("readonly");
$( newRow ).find( 'select' ).removeAttr("disabled");
$( newRow ).find( 'input[name="rfqtsn[]"]' ).attr("readonly","readonly");

return;
});
function rme(ritem)
{
	gtrace=ritem;

	var gi=gtrace.parentElement.parentElement.parentElement;
	gi.parentNode.removeChild(gi);
	var tokenid=$(ritem).attr("tokenid");
	var id_se='button[tokenid='+tokenid+']';
	if ($(id_se).length == 1)
	{
		$(id_se).text("Bid");
//$(id_se).removeClass();
//$(id_se).addClass("btn");
}
}
function s4() {
	return Math.floor((1 + Math.random()) * 0x10000)
	.toString(16)
	.substring(1);
};

function guid() {
	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	s4() + '-' + s4() + s4() + s4();
}
$('.readonlyenabled').attr("readonly","readonly");

$('#rfqcurrency').val("<?php echo $rfqm[0]->rfq_pref_currency;?>");

$( "#RFQBidSubmitForm" ).submit(function( event ) {
	$("#myModal").modal();
	return;
});
$('#animateinitme').focus();
function testAnim(x) {
	$('#animateinitme').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$(this).removeClass();
		$(this).addClass("addbidme btn btn-default");
	});
};
testAnim("flash");  
</script>