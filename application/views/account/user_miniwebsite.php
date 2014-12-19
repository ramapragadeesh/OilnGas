<?php
function userLocaleConversion(& $info_holderdy,$f) {
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
?>

<div class="container">
    <h3 style="font-weight:100;padding-bottom:5px;padding-top:10px"><?php echo userLocaleConversion($websiteLanguageInfo,"You can design your company page the way you like it.");?></h3>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <!-- End Carousel Inner -->
        <ul class="nav nav-pills nav-justified">
            <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#"><?php echo $labelHome; ?></small></a></li>
            <li data-target="#myCarousel" data-slide-to="1"><a href="#"><small><?php echo $labelAboutus; ?></small></a></li>
            <li data-target="#myCarousel" data-slide-to="2"><a href="#"><small><?php echo $labelServices; ?></small></a></li>
            <li data-target="#myCarousel" data-slide-to="3"><a href="#"><small><?php echo $labelContactus; ?></small></a></li>
        </ul>

        <form target="_blank" action= "<?php echo base_url();?>user/save" method="post" name="userWebsite" id="userWebSite">
            <div class="carousel-inner">
                <div class="item active">
                    <h2 style="padding-bottom:5px;"><?php echo userLocaleConversion($websiteLanguageInfo,"Home Page Design");?></h2>
                    <textarea id="homeContent" name="homeContent">
                        <?php if ( $homeContent == "0"){ } else { echo $homeContent;}?>
                    </textarea>
                </div>
                <!-- End Item -->
                <div class="item">
                    <h2 style="padding-bottom:5px;"><?php echo userLocaleConversion($websiteLanguageInfo,"About Us Page Design");?></h2>
                    <textarea id="aboutusContent" name="aboutusContent">
                        <?php if ( $aboutusContent == "0"){ } else { echo $aboutusContent;}?>
                    </textarea>
                </div>

                <div class="item">
                    <h2 style="padding-bottom:5px;"><?php echo userLocaleConversion($websiteLanguageInfo,"Service Page Design");?></h2>
                    <textarea id="servicesContent" name="servicesContent">
                        <?php if ( $servicesContent == "0"){ } else { echo $servicesContent;}?>
                    </textarea>
                </div>
                <!-- End Item -->
                <!-- End Item -->
                <div class="item">
                    <h2 style="padding-bottom:5px;"><?php echo userLocaleConversion($websiteLanguageInfo,"Contact Us Page Design");?></h2>
                    <textarea id="contactusContent" name="contactusContent">
                        <?php if ( $contactusContent == "0"){ } else { echo $contactusContent;}?>
                    </textarea>
                </div>
                <!-- End Item -->
            </div>
            <div>
                <h4 style="font-weight:100">
                    <?php echo userLocaleConversion($websiteLanguageInfo,"You can also change the Menu label");?>
                </h4>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-xs-12 col-md-5">
                 <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><?php echo userLocaleConversion($websiteLanguageInfo,"Home");?></div>
                        <input type="hidden" name="preview" value="0" id="preview">
                        <input class="form-control"  type="text" name="labelHome" value="<?php echo $labelHome; ?>">
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-5">
             <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><?php echo userLocaleConversion($websiteLanguageInfo,"About Us");?></div>
                  <input class="form-control" type="text" name="labelAboutus" value="<?php echo $labelAboutus; ?>">
              </div>
          </div>
      </div>
  </div>


  <div class="row" style="margin-top:10px">
    <div class="col-xs-12 col-md-5">
     <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><?php echo userLocaleConversion($websiteLanguageInfo,"Services");?></div>
          <input class="form-control" type="text" name="labelServices" value="<?php echo $labelServices; ?>">
      </div>
  </div>
</div>

<div class="col-xs-12 col-md-5">
 <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon"><?php echo userLocaleConversion($websiteLanguageInfo,"Contact Us");?></div>
      <input class="form-control" type="text" name="labelContactus" value="<?php echo $labelContactus; ?>">
  </div>
</div>
</div>
</div>

<div style="margin-top:10px">
    <input class="btn btn-u" type="submit" value="<?php echo userLocaleConversion($websiteLanguageInfo,"Activate and Preview");?>">
    <input id= "previewButton" class="btn btn-u" onlclick="$('#preview').val(1);return true;" type="button" value="<?php echo userLocaleConversion($websiteLanguageInfo,"Preview");?>">
    <script>
    $( "#previewButton" ).click(function() {
    $('#preview').val("1")
    $( "#userWebSite" ).submit();
    });
    </script>
</div>
</form>

</div>

<!-- End Carousel -->
</div>


<script src="<?php echo  base_url();?>tinymce/tinymce.min.js"> </script>

<script>
    $(document).ready( function() {

        $('#myCarousel').carousel({
            interval:   400000000
        });

        var clickEvent = false;
        $('#myCarousel').on('click', '.nav a', function() {
            clickEvent = true;
            $('.nav li').removeClass('active');
            $(this).parent().addClass('active');
        }).on('slid.bs.carousel', function(e) {
            if(!clickEvent) {
                var count = $('.nav').children().length -1;
                var current = $('.nav li.active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if(count == id) {
                    $('.nav li').first().addClass('active');
                }
            }
            clickEvent = false;
        });
    });
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        relative_urls:false,
        remove_script_host : false,
        plugins: [
        "advlist autolink lists link preview hr anchor pagebreak image",
        "fullscreen",
        "nonbreaking save table contextmenu  media",
        "paste textcolor moxiemanager"
        ],
        toolbar1: "insertfile fontsizeselect undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor"

    });

</script>
<style type="text/css">
    #myCarousel .nav a small
    {
        display: block;
    }
    #myCarousel .nav
    {
        background: #eee;
    }
    .nav-justified > li > a
    {
        border-radius: 0px;
    }
    .nav-pills>li[data-slide-to="0"].active a { background-color: #16a085; }
    .nav-pills>li[data-slide-to="1"].active a { background-color: #e67e22; }
    .nav-pills>li[data-slide-to="2"].active a { background-color: #2980b9; }
    .nav-pills>li[data-slide-to="3"].active a { background-color: #8e44ad; }
</style>