<?php

function bannerListing($bannerData) {
  $holder = "";
  $i=0;
  $holder="";
  for ($i=1;$i<= 10;$i++) {
    $dataFound=0;

    foreach ($bannerData as $v) {
     $title = '';
     if (strlen($v->title) >= 5) {
      $title = '<div class="capc"><h6>'.$v->title.'</h6></div>';
    }
    if ($dataFound==1) {
      break;
    }
    if ($i == $v->order) {
      $dataFound=1;
      if ($v->link_image != "") {
       $holder .= '<div class="adcontent" style="text-align:center;"><a href="'.$v->link_image_url.'" target="_blank"><img style="width:100%;" src="'.$v->link_image.'" class="img_p" /></a>'.$title.'</div>';
     } else if ($v->description != "") {
      $holder .= $holder .= '<div class="adcontent"><p>'.$v->description.'</p>'.$title.'</div>';
    }
  }
}
if ($dataFound == 0) {
  $holder .= '<div class="adcontent"></div>';
}

}
return $holder;
}

function dp($info_holderdy,$f,$fsl="") {
  $rt=$f;
  foreach ($info_holderdy as &$value) {
    if (strtolower($value->default_text) == strtolower($f)) {
      $rt = $value->dp;
      break;
    }
  }
  return $rt;
}

?>
<div class="container" style="background: #ffffff;margin-top:10px">
  <div class="row">
    <div class="col-md-2 col-xs-12">
      <ul class="nav navbar-nav" style="background:whitesmoke">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo dp($homepage_holder, "Member Listing");?>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>member/search?member_type=A&member_desc=Machine / Equipment  Supplier"><?php echo dp($homepage_holder, "Machine / Equipment Supplier");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=B&member_desc=Raw Material Supplier"><?php echo dp($homepage_holder, "Raw Material Supplier");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=C&member_desc=Abrasive Producer (Bonded)"><?php echo dp($homepage_holder, "Abrasive Producer (Bonded)");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=Z&member_desc=Abrasive Producer (Coated)"><?php echo dp($homepage_holder, "Abrasive Producer (Coated)");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=D&member_desc=Coated Abrasive Converter"><?php echo dp($homepage_holder, "Coated Abrasive Converter");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=E&member_desc=Distributor( Bonded or Coated Abrasive)"><?php echo dp($homepage_holder, "Distributor( Bonded or Coated Abrasive)");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=F&member_desc=Abrasive Users"> <?php echo dp($homepage_holder, "Abrasive Users");?></a></li>
            <li><a href="<?php echo base_url();?>member/search?member_type=ALL&member_desc=Others"><?php echo dp($homepage_holder, "Others");?></a></li>

          </ul>
        </li>
      </ul>
    </div>
    <div class="col-md-10 col-xs-12">
      <div style="text-align:center;">
        <div>
         <h4 style="color:orange"><?php echo dp($homepage_holder,"Abrasivesworld newly launches");?> <span style="font-family:Courgette" class="blink"><?php echo dp($homepage_holder,"Request for Quotation & Personalised home page");?></span></h4>
       </div>

       <p>
        <h4><?php echo dp($homepage_holder,"Abrasivesworld gets you connected to latest abrasives news , development and community worldwide");?></h4>
      </p>

    </div>
  </div>
</div>
</div>

<div class="container bshadow">
  <div id="main-endorser" class="owl-carousel" >

    <div>
      <div class="endorser-position">
        <div class="endorser-image">
          <img src="<?php echo base_url();?>application/img/end/1.jpg" class="imgBorder"/>
        </div>
        <div class="endorser-desc">
          <h6>
            "We finally found a marketing portal that a small, medium company can leverage on to reach out to our target market focus" John Chia - Managing Director, Kitzutech Sdn Bhd, Malaysia
          </h6>
        </div>
        <div class="endorser-add-image">
          <img style="height:120px;width:120px" class="imgBorder" src="<?php echo base_url();?>application/img/end/DSCN1835.JPG"/>
        </div>
      </div>
    </div>

    <div>
      <div class="endorser-position">
        <div class="endorser-image">
          <img src="<?php echo base_url();?>application/img/end/2.jpg" class="imgBorder"/>
        </div>
        <div class="endorser-desc">
          <h6>
            "Abrasivesworld is by far the best marketing platform that enables us to reach out to both our target segment and name customers. It provides the pulse of the market development in the abrasives world" Franco Maternini - President of Davide Maternini, Italy</h6>
          </div>
          <div class="endorser-add-image">
            <img style="height:120px;width:120px" class="imgBorder" src="<?php echo base_url();?>application/img/end/2_en.jpg"/>
          </div>
        </div>
      </div>

      <div>
        <div class="endorser-position">
          <div class="endorser-image">
            <img src="<?php echo base_url();?>application/img/end/3.jpg" class="imgBorder"/>
          </div>
          <div class="endorser-desc">
            <h6>
              "我非常高兴《研磨世界》首创了这样一个平台，成功的将研磨界联结在一起。 现在我能够找到正确的业界人士一同分享交流最新的市场动态，而不用顾虑语言障碍和国界隔阂"
              -李 （玉立研磨，中国）
            </h6>
          </div>
          <div class="endorser-add-image">
            <img style="height:120px;width:120px" class="imgBorder" src="<?php echo base_url();?>application/img/end/3_en.png"/>
          </div>
        </div>
      </div>

      <div>
        <div class="endorser-position">
          <div class="endorser-image">
            <img src="<?php echo base_url();?>application/img/end/4.jpg" class="imgBorder"/>
          </div>
          <div class="endorser-desc">
            <h6>
              "As a global leader that specialises in the flap discs machine and production system, we are very selective in our marketing channel. AbrasivesWorld has what it takes to position us as a global leader in the abrasives arena."  Raffaele Barbieri – Owner of Riflex Italy
            </h6>
          </div>
          <div class="endorser-add-image">
            <img style="height:120px;width:120px" class="imgBorder"  src="<?php echo base_url();?>application/img/end/barbieri.jpg"/>
          </div>
        </div>
      </div>

      <div>
        <div class="endorser-position">
          <div class="endorser-image">
            <img src="<?php echo base_url();?>application/img/end/Machine_494.jpg" class="imgBorder"/>
          </div>
          <div class="endorser-desc">
            <h6>
              "I am amazed by the effectiveness of Abrasivesworld in connecting us to the abrasive community to continue our legacy as the pioneer in the development of conversion equipment" Pascal Amacker – Owner of Amacker + Schmid AG
            </h6>
          </div>
          <div class="endorser-add-image">
            <img style="height:120px;width:120px" class="imgBorder"  src="<?php echo base_url();?>application/img/end/Pascal_120px.jpg"/>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="container bshadow" style="margin-top:10px;">
    <div class="row" style="padding-top:10px">
      <div class="col-xs-12 col-md-12">
        <div class="well well-sm" style="background:#4d4582;color:white">
         <h5><?php echo dp($homepage_holder,"Featured Endorser");?></h5>
       </div>
     </div>
   </div>

   <div id="featured-endorser" class="owl-carousel">
    <div class="adcontent">
      <img src="<?php echo base_url();?>application/img/demo/pl.png" alt="basketball" class="img_p"  />
      <div class="capc">
       <h6>
         <?php echo dp($homepage_holder,"Global leader in production machines for both bonded and coated abrasives production lines");?>
       </h6>
     </div>
   </div>

   <div class="adcontent">
    <img src="<?php echo base_url();?>application/img/demo/pl2.png" alt="basketball" class="img_p"  />
    <div class="capc">
     <h6>
       <?php echo dp($homepage_holder,"Manufacturer of splicing tapes for sanding belt conversion");?>
     </h6>
   </div>
 </div>

 <div class="adcontent">
  <img src="<?php echo base_url();?>application/img/demo/pl3.png" alt="basketball" class="img_p"  />
  <div class="capc">
   <h6>
     <?php echo dp($homepage_holder,"Manufacturer of Flaps discs machines and tools");?>
   </h6>
 </div>
</div>

<div class="adcontent">
  <img src="<?php echo base_url();?>application/img/demo/pl4.png" alt="basketball" class="img_p"  />
  <div class="capc">
   <h6>
    <?php echo dp($homepage_holder,"Manufacturer of Coated and bonded abrasives");?>
  </h6>
</div>
</div>


<div class="adcontent">
  <img src="<?php echo base_url();?>application/img/demo/pl5.png" alt="basketball" class="img_p"  />
  <div class="capc">
   <h6>
     <?php echo dp($homepage_holder,"Manufacturer of conversion machine for coated abrasives");?>
   </h6>
 </div>
</div>

<div class="adcontent">
  <img src="<?php echo base_url();?>application/img/demo/pl6.png" alt="basketball" class="img_p"/>
  <div class="capc">
   <h6>
     <?php echo dp($homepage_holder,"Manufacturer of coated abrasives");?>
   </h6>
 </div>
</div>

<div class="adcontent">
  <img src="<?php echo base_url();?>application/img/demo/pl7.jpg" alt="basketball" class="img_p"/>
  <div class="capc">
   <h6>
     <?php echo dp($homepage_holder,"Abrasive Converting plant");?>
   </h6>
 </div>
</div>
</div>
</div>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="container" style="background:whitesmoke">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3 text-center">
        <span class="ajaxloader1"> </span> Please wait while we loading the search content
      </div>
    </div>
  </div>
</div>


<link href='http://fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>
<script src="https://apis.google.com/js/client.js?onload=OnLoadCallback"></script>
<script>
  function load()
  {

    gapi.client.setApiKey('AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M');
    gapi.client.load('translate', 'v2', makeRequest);
  }
  function translateText(response) {
    document.getElementById("translation").innerHTML += "<br>" + response.data.translations[0].translatedText;
  }
</script>
<style>
  .endorser-position
  {
    padding: 5px 5px 5px 5px;
  }
  .endorser-image
  {
    text-align: center;
  }
  .endorser-desc
  {
    height:100px;
  }
  .abi_carousel
  {
    position: relative;
    padding-left:70px;
    padding-right:20px;
  }
  .imgBorder {
    padding: 5px 5px 5px 5px;
    background-color: white;
    box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
    -moz-box-shadow: 0 1px 2px rgba(34,25,25,0.4);
    -webkit-box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
    width:220px;
    height:200px;
  }
  .list_carousel
  {
    position: relative;
    padding-left:70px;
    padding-right:20px;
    padding-bottom:10px;
  }
  .img_p
  {
    width:140px;
    height:70px;
  }
  .clearfix {
    float: none;
    clear: both;
  }
  .capc
  {
    background-color:rgb(0, 0, 0);
    opacity:0.5;
    color:white;
    -webkit-box-shadow:0px 1px 5px 0px rgb(74, 74, 74);
    -moz-box-shadow:0px 1px 5px 0px rgb(74, 74, 74);
    box-shadow:0px 1px 5px 0px rgb(74, 74, 74);
    height:40px;
    box-sizing:border-box;
    text-align:center;
  }
  .adcontent
  {
    padding:5px 5px 5px 5px;
  }
  .page_cursor
  {
    cursor: pointer;
  }
  .bshadow
  {
    box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
    border:3px solid rgb(223, 223, 223);
    background:whitesmoke;
  }
  .endorser-add-image {
    text-align: center;
  }
</style>

<script>
  $(document).ready(function() {
  });
  (function($)
  {
    $.fn.blink = function(options)
    {
      var defaults = { delay:500 };
      var options = $.extend(defaults, options);

      return this.each(function()
      {
        var obj = $(this);
        setInterval(function()
        {
          if($(obj).css("visibility") == "visible")
          {
            $(obj).css('visibility','hidden');
          }
          else
          {
            $(obj).css('visibility','visible');
          }
        }, options.delay);
      });
    }
  }(jQuery))

  $(document).ready(function()
  {
    $('.blink').blink();
  });
</script>
<link rel="stylesheet" href="application/css//owl.carousel.css">
<!-- Default Theme -->
<link rel="stylesheet" href="application/css/owl.theme.css">

<script src="application/js/owl.carousel.js"></script>
<script>
  $(document).ready(function() {
   $("#featured-endorser").owlCarousel({autoPlay:true,stopOnHover : true, lazyLoad : true,autoPlay : 5000});
   $("#main-endorser").owlCarousel({autoPlay:true,stopOnHover : true, lazyLoad : true,autoPlay : 8000});
   $("#ad-listing").owlCarousel({autoPlay:true,stopOnHover : true, lazyLoad : true,autoPlay : 4000,itemsScaleUp:true});
 });
</script>
