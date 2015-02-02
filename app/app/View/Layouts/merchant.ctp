<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1" />
 <meta http-equiv="Content-Language" content="<?=$hlang?>" />
<title><?php $lang = $this->Template->getLang();
            if($lang == 'en')
                echo stripslashes($setting['Setting']['site_title']);
            else
                echo stripslashes($setting['Setting']['site_title_ar']); ?> | <?=$htitle?></title>
 <meta name="title" content="Price Comparision, Best Products Offers" />
<meta name="description" content="Price Comparision, Best Products Offers">
<meta name="keywords" content="Price Comparision, Best Products Offers">
<?php
        echo $this->Html->meta('icon');     
        $lang=$this->Template->getLang();
      if($lang=="en")
      {
        echo $this->Html->css('front-end/style');
        echo $this->Html->css('front-end/mystyle');
         echo $this->Html->css('front-end/dashboard_style');
         echo $this->Html->css('front-end/site_header');
         echo $this->Html->css('front-end/merchant_header');
		 echo $this->Html->css('front-end/nanoscroller');      
      echo $this->Html->css('front-end/merchant_css');
      echo $this->Html->css('front-end/newmerchant');
     ?>
<link rel='stylesheet' href='<?=$this->webroot?>css/front-end/responsive/mobile/mobile.css' />
<link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/ipad/ipad.css' /> 
<?php
      }
      else
      {
        echo $this->Html->css('front-end/style_ar');
        echo $this->Html->css('front-end/mystyle_ar');
        echo $this->Html->css('front-end/dashboard_style_ar');
        echo $this->Html->css('front-end/site_header_ar');
        echo $this->Html->css('front-end/merchant_header_ar');
    		echo $this->Html->css('front-end/nanoscroller_ar');        
        echo $this->Html->css('front-end/merchant_css_ar');
        echo $this->Html->css('front-end/newmerchant_ar');
         ?>
   <link rel='stylesheet' href='<?=$this->webroot?>css/front-end/responsive/mobile/mobile_ar.css' />
<link rel='stylesheet'  href='<?=$this->webroot?>css/front-end/responsive/ipad/ipad_ar.css' /> 
   <?php
      }
        echo $this->Html->css('front-end/language-switcher');       
        echo $this->Html->css('fancybox/jquery.fancybox-buttons');
        echo $this->Html->css('fancybox/jquery.fancybox-thumbs');
        echo $this->Html->css('fancybox/jquery.fancybox');
        echo $this->Html->css('front-end/jquery.tagit');
        echo $this->Html->css('front-end/tagit.ui-zendesk');
        echo $this->Html->css('front-end/jquery-ui-1.10.4.custom.min');
        //echo $this->Html->css('front-end/jquery-ui-1.8.24.custom.css');        
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        
?>
<!--<link href="css/style.css" type="text/css" rel="stylesheet" media="all" />-->
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<!--<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/ui-darkness/jquery-ui.css" rel="stylesheet">-->
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<link rel="shortcut icon" href="<?php echo $this->webroot.$setting['Setting']['favicon'];?>" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!--<link href="css/language-switcher-inner.css" type="text/css" rel="stylesheet">-->

<!--<script src="js/jquery.min.js"></script>
<script src="js/jquery.polyglot.language.switcher.js" type="text/javascript"></script>-->
  <?php echo $this->Html->script('front-end/jquery.min.js'); ?>
  <?php //echo $this->Html->script('front-end/hint-tooltip.js'); ?>
  
<!--  <script src="http://jquery.bassistance.de/validate/additional-methods.js"></script>-->
  <?php echo $this->Html->script('fancybox/jquery.mousewheel-3.0.6.pack'); ?>
  <?php echo $this->Html->script('fancybox/jquery.fancybox.pack'); ?>
  <?php echo $this->Html->script('fancybox/jquery.fancybox-buttons'); ?>
  <?php echo $this->Html->script('fancybox/jquery.fancybox-media'); ?>
  <?php echo $this->Html->script('fancybox/jquery.fancybox-thumbs'); ?>
  <?php //echo $this->Html->script('front-end/jquery-ui-1.8.24.custom.min'); ?>
  <?php echo $this->Html->script('front-end/jquery-ui-1.10.4.custom'); ?>
  <?php echo $this->Html->script('tag-it'); ?>
  <?php echo $this->Html->script('front-end/jquery.polyglot.language.switcher'); ?>
  <?php echo $this->Html->script('front-end/jquery.nanoscroller.min'); ?>
  <script type="text/javascript" src="<?=$this->webroot?>js/front-end/mustache.js"></script>
  <?php //echo $this->Html->script('front-end/jquery.validater'); ?>
  
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
  <?php echo $this->Html->script('front-end/jquery.form'); ?>
  <!--[if !IE]><!-->
 <script>  
if (/*@cc_on!@*/false) {  
    document.documentElement.className+=' ie10';  
}  
</script>
<!--<![endif]--> 
      <script type="text/javascript">

       var rootPath="<?=$this->webroot?>";
       var here="<?=$this->request->here?>";
       function getLangUrl(current,priv){
                  
                     var fullpath=window.location.href;
                     var getdata=fullpath.split('/'+priv+'/');
                     if(getdata[1]==undefined)
                     {
                     var path=window.location.origin+rootPath;
                     var rest=fullpath.split(path);
                     //rest[1].split;
                     var langPath=path+current+"/"+rest[1];
                     langPath=langPath.replace('#',"");
                     }
                     else
                     {
                      var langPath=getdata[0]+"/"+current+"/"+getdata[1];
                       langPath=langPath.replace('#',"");
                     }
                     return langPath;
       }
   
           $(document).ready(function() {

            $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
        effect: 'fade',
                testMode: true,
                onChange: function(evt){
                  // alert("The selected language is: "+evt.selectedItem);
                    if(evt.selectedItem=="ar")
                    {
                      langPath=getLangUrl(evt.selectedItem,'en');
                    
                   }else if(evt.selectedItem=="en")
                   {
                     langPath= getLangUrl(evt.selectedItem,'ar');

                   }
                    window.location.assign(langPath);
                     //console.log(window.location);
                }
//               
            });
       
            jQuery.validator.setDefaults({
              debug: false,
              success: "valid"
            });
            $("#validates_login").validate({
                 
              submitHandler: function() {
                //console.log($('form#validates_login').serialize());
                $('.loader_img_sign_up').show();
   $.post('<?=$this->webroot?>merchant/login',$('form#validates_login').serialize() , 
                        function(r){
                           //console.log(r);
                           if(r==1)
                           {
                              $('.loader_img_sign_up').hide();
                              window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/dashbord');
                           }
                           else
                           {
                              $('.mer_login_msg').html('<div id="badMessage" class="message">'+r+'</div>');
                              $('.loader_img_sign_up').hide();
                           }
                        }
                        );
                    
              }
             });
            $("form").validate({rules: {
                  phone: {
                    required: true,
                    digits: true
                  },

              }
             });
            $(".validate").validate({rules: {
                  phone: {
                    required: true,
                    digits: true
                  },

              }
             });
           
            
        });

</script>
<script>
$(document).ready(function(){

    // hide #back-top first
    $("#back-top").hide();
    
    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('#back-top a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

});
</script>
<script type="text/javascript">

$(document).ready(function(){
//$(".ui-accordion-content-active").css('height','300px');
});
    $(function(){

      // Accordion
      $("#accordion").accordion({ header: "h3", autoHeight: false });
      $( "#accordion" ).accordion({
         autoHeight: false,
        navigation: true,
        collapsible: true,
        active: 0
      });
      
    });
  </script> 

<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete;
var componentForm = {
 
  locality: 'long_name',
  administrative_area_level_1: 'long_name',
  country: 'long_name',
  postal_code: 'short_name'
};


function initialize() {
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {HTMLInputElement} */(document.getElementById('adress')),
      { types: ['geocode'] });
  // When the user selects an address from the dropdown,
  // populate the address fields in the form.
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    fillInAddress();
  });
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
//console.log(place);
  for (var component in componentForm) {
    console.log(component);
    //document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }
  console.log(componentForm.length);
  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    console.log(componentForm[addressType]);
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
          geolocation));
    });
  }
}
// [END region_geolocation]
var data = [
      { value: "AL", label: "Alabama" },
      { value: "AK", label: "Alaska" },
      { value: "AZ", label: "Arizona" },
      { value: "AR", label: "Arkansas" },
      { value: "CA", label: "California" },
      { value: "CO", label: "Colorado" },
      { value: "CT", label: "Connecticut" },
      { value: "DE", label: "Delaware" },
      { value: "FL", label: "Florida" },
      { value: "GA", label: "Georgia" },
      { value: "HI", label: "Hawaii" },
      { value: "ID", label: "Idaho" },
      { value: "IL", label: "Illinois" },
      { value: "IN", label: "Indiana" },
      { value: "IA", label: "Iowa" },
      { value: "KS", label: "Kansas" },
      { value: "KY", label: "Kentucky" },
      { value: "LA", label: "Louisiana" },
      { value: "ME", label: "Maine" },
      { value: "MD", label: "Maryland" },
      { value: "MA", label: "Massachusetts" },
      { value: "MI", label: "Michigan" },
      { value: "MN", label: "Minnesota" },
      { value: "MS", label: "Mississippi" },
      { value: "MO", label: "Missouri" },
      { value: "MT", label: "Montana" },
      { value: "NE", label: "Nebraska" },
      { value: "NV", label: "Nevada" },
      { value: "NH", label: "New Hampshire" },
      { value: "NJ", label: "New Jersey" },
      { value: "NM", label: "New Mexico" },
      { value: "NY", label: "New York" },
      { value: "NC", label: "North Carolina" },
      { value: "ND", label: "North Dakota" },
      { value: "OH", label: "Ohio" },
      { value: "OK", label: "Oklahoma" },
      { value: "OR", label: "Oregon" },
      { value: "PA", label: "Pennsylvania" },
      { value: "RI", label: "Rhode Island" },
      { value: "SC", label: "South Carolina" },
      { value: "SD", label: "South Dakota" },
      { value: "TN", label: "Tennessee" },
      { value: "TX", label: "Texas" },
      { value: "UT", label: "Utah" },
      { value: "VT", label: "Vermont" },
      { value: "VA", label: "Virginia" },
      { value: "WA", label: "Washington" },
      { value: "WV", label: "West Virginia" },
      { value: "WI", label: "Wisconsin" },
      { value: "WY", label: "Wyoming" }
    ];
  $(function() {
    $(".various").fancybox({
      maxWidth  : 480,
      maxHeight : 330,
      fitToView : false,
      width   : '70%',
      height    : '70%',
      autoSize  : false,
      closeClick  : false,
      openEffect  : 'none',
      closeEffect : 'none'
    });
$(".various_log").fancybox({
      maxWidth  : 450,
      maxHeight : 330,
      fitToView : false,
      width   : '70%',
      height    : '70%',
      autoSize  : false,
      closeClick  : false,
      openEffect  : 'none',
      closeEffect : 'none'
    });
      function highlightText(text, $node) {
        var searchText = $.trim(text).toLowerCase(), currentNode = $node.get(0).firstChild, matchIndex, newTextNode, newSpanNode;
        while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
          newTextNode = currentNode.splitText(matchIndex);
          currentNode = newTextNode.splitText(searchText.length);
          newSpanNode = document.createElement("span");
          newSpanNode.className = "highlight";
          currentNode.parentNode.insertBefore(newSpanNode, currentNode);
          newSpanNode.appendChild(newTextNode);
        }
      }

      <?php
        //echo $this->params['controller'];
       // echo $this->params['action'];
       if($this->params['controller'] == "products" && $this->params['action'] == "merchant_update"){ ?>
      $("#autocomplete").autocomplete({
        delay: 500,
        minLength: 3,
        source: function(request, response) {
          //alert(request.term);
          $.getJSON("<?=$this->webroot?>products/getCategoryByName/"+request.term, {            
            ajax: "true",           
            page_limit: 10
          }, function(data) {
            // data is an array of objects and must be transformed for autocomplete to use
           
            var array = data.error ? [] : $.map(data, function(m) {
              return {
                label: m.label,
                value: m.value,                
              };
            });
            response(array);
          });
        },
        focus: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          //$(this).val(ui.item.label);
        },
        select: function(event, ui) {
          // prevent autocomplete from updating the textbox
          event.preventDefault();
          // navigate to the selected item's url
          //window.open(ui.item.url);
          $(this).val(ui.item.label);
          $("#autocomplete2-value").val(ui.item.value);
        }
      }).data("ui-autocomplete")._renderItem = function(ul, item) {
        var $a = $("<a></a>").text(item.label);
        highlightText(this.term, $a);
        return $("<li></li>").append($a).appendTo(ul);
      };
      <?php } ?>
    });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".nano").nanoScroller();
    //$("div.hover-text").hide();
   // $("div.gimage").hover(function(){
   // $(this).find("div.hover-text").slideToggle(500);
 // });
  
  $("div.gimage").css({'position' : 'relative'});
  $("div.hover-text").css({'position' : 'absolute','bottom' :1});
    /*$('#singleFieldTags').tagit({
                availableTags: sampleTags,
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
                singleFieldNode: $('#mySingleField')
            });*/
            var eventTags = $('#singleFieldTags');
            function isUrl(s) {
                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                return regexp.test(s);
            }
         function isValidImageUrl(url) {
  
                var tester=new Image();
                tester.onLoad=isGood;
                tester.onError=isBad;
                tester.src=URL;
                }

                function isGood() {
                 return true;
                }

                function isBad() {
                return false;
                } 

            var addEvent = function() {
               $('.showImg_area').html('');

                  var getdata=$('#mySingleField').val();
                  if(getdata!="")
                  {
                        var dat=getdata.split(',');
                       
                       for (var x in dat) {

                            $('.showImg_area').append('<div class="prod_image '+x+'"><span>x</span><img src="'+dat[x]+'" width="100px"></div>');
                       }
                  }
      $('.prod_image span').bind('click',function(){
        var parent=$(this).parent('.prod_image').attr('class');
        var dt=parent.split(' ');
        var dleted=$(this).parent('.prod_image').index();
        console.log(dleted);
        var imgs=$('#mySingleField').val();
        if(imgs)
        {
           var img_dat= imgs.split(',');

           img_dat.splice(dleted,1);

           //console.log(img_dat);
           $('#singleFieldTags .tagit-choice:nth-child('+(dleted+1)+')').remove();
           $('.showImg_area .prod_image:nth-child('+(dleted+1)+')').remove();
           var strig_images=img_dat.join();
           $('#mySingleField').val(strig_images);

        }
    })
            };
 var sampleTags="";
            eventTags.tagit({
                availableTags: sampleTags,
                singleField: true,
                singleFieldNode: $('#mySingleField'),
                removeConfirmation: true,
                beforeTagAdded: function(evt, ui) {
                    if (!ui.duringInitialization) {
                       // addEvent('beforeTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                     $('#shoeimg_error').hide();
                       if(isUrl(ui.tag[0].outerText))
                       {
                       // $('#singleFieldTags').tagit('removeTagByName', ui.tag[0].outerText)
                      if( isValidImageUrl(ui.tag[0].outerText)){
                        //alert(result);
                         if(!result)
                         {
                           $('#shoeimg_error').show();
                           return false;
                         }else
                         {
                           $('#shoeimg_error').hide();
                         }

                       }
                        
                        
                       }
                       else
                       {
                        $('#shoeimg_error').show();
                        return false;
                       }

                    }
                },
                afterTagAdded: function(evt, ui) {
                    if (!ui.duringInitialization) {
                      
                       addEvent();
                    

                    }
                },
                beforeTagRemoved: function(evt, ui) {
                    //addEvent('beforeTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
                },
                afterTagRemoved: function(evt, ui) {
                      addEvent();
                },
                onTagClicked: function(evt, ui) {
                   // addEvent('onTagClicked: ' + eventTags.tagit('tagLabel', ui.tag));
                },
                onTagExists: function(evt, ui) {
                   // addEvent('onTagExists: ' + eventTags.tagit('tagLabel', ui.existingTag));
                }
                

            });
  });
$(document).mouseup(function (e){
     var container = $("#sample");
    var container1 = $("#sample1");
    var container2 = $("#sample2");
   
    //var container6 = $(".listdatapan");
    if(e.target.id=="active1" )
    {
          container2.hide();
          container1.hide();
          $('#offer').val(1);       
          $('#brand').val(1);
          $("#active2").attr('class', 'white');
          $("#active3").attr('class', 'white');
        
    }
    else if(e.target.id=="active2" )
    {
      
          container.hide();
          container2.hide();
          $('#offer').val(1);
          $('#dept').val(1);
          $("#active1").attr('class', 'white');
          $("#active3").attr('class', 'white');
          
      
    }
    else if(e.target.id=="active3" )
    {
          container.hide();
          container1.hide();         
          $('#dept').val(1);
          $('#brand').val(1);
          $("#active1").attr('class', 'white');
          $("#active2").attr('class', 'white');
        
    }
    else 
    {if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        
        container.hide();
        $("#active1").attr('class', 'white');
        //$('#dept').val(1);
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
    }
    
    if (!container1.is(e.target) // if the target of the click isn't the container...
        && container1.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container1.hide();
        $("#active2").attr('class', 'white');
        //$('#brand').val(1);
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
    }
    
    if (!container2.is(e.target) // if the target of the click isn't the container...
        && container2.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container2.hide();
        $("#active3").attr('class', 'white');
        //$('#offer').val(1);
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
    }
  }
     
});

function show1()
{
    // check the panel display status
    if($('#dept').val() == 1){
        $("#sample").show();
        $('#dept').val(2);
        $('#brand').val(1);
        $('#offer').val(1);
        $("#active1").attr('class', 'yellow');
    }else{
        $("#sample").hide();
        $('#dept').val(1);
        $('#brand').val(1);
        $('#offer').val(1);
        $("#active1").attr('class', 'white');
    }
}

function show2()
{
    if($('#brand').val() == 1){
        $("#sample1").show();
        $('#brand').val(2);
        $('#dept').val(1);
        $('#offer').val(1);
        $("#active2").attr('class', 'yellow');
    }else{
        $("#sample1").hide();
        $('#brand').val(1);
        $('#dept').val(1);
        $('#offer').val(1);
        $("#active2").attr('class', 'white');
    }
}

function show3()
{
    if($('#offer').val() == 1){
        $("#sample2").show();
        $('#offer').val(2);
        $('#dept').val(1);
        $('#brand').val(1);
        $("#active3").attr('class', 'yellow');
		$(".nano").nanoScroller();
    }else{
        $("#sample2").hide();
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
        $("#active3").attr('class', 'white');
    }
}

function show4()
{
    $(".listdatapan").toggle();
}
function hide_department(){
        $("#sample").slideUp();
        $('#dept').val(1);
        $('#brand').val(1);
        $('#offer').val(1);
        $("#active1").attr('class', 'white');
}
function hide_brand(){
        $("#sample1").slideUp();
        $('#brand').val(1);
        $('#dept').val(1);
        $('#offer').val(1);
        $("#active2").attr('class', 'white');
}
function hide_offer(){
       $("#sample2").slideUp();
        $('#offer').val(1);
        $('#dept').val(1);
        $('#brand').val(1);
        $("#active3").attr('class', 'white');
}
</script>
	<style>    
     .validate label.error{color:#f00;}
     #validates_login label.error{color:#f00;}
    .ui-autocomplete .highlight {
      text-decoration: underline;
    }
#back-top img {
width: 23px;
height: 31px;
position: relative;
top: 6px;
display:none;
}
#back-top span
{
  background:url(../../img/gototop.png) no-repeat 0px 8px!important;
  height:50px;
  background-color: transparent!important;
  border-radius:0px!important;
  width: 50px;
  margin:0!important;
  background-size: 80%!important;
}
#back-top span:hover
{
  background:url(../../img/gototop_hov.png) no-repeat 0px 8px!important;
  background-color: transparent!important;
  background-size: 80%!important;
}
#back-top
{
  right:-1px!important;
  bottom:-1px!important;
  border-radius:0px!important;
}
#back-top a{width:auto!important; height:auto!important;}

  </style>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55012366-1', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body style="background:#fff;" onload="initialize()">
    <div class="wrapper">
     <div class="header">   
    <div class="grid">
        <div class="inner_grid">
                <div class="shopby"><?php echo $this->template->getWord('shop_by');?><div class="homefl"><a href="http://hoppay.com">Home</a></div></div>

                <div id="nav">
                    <ul>
                        <li>
                            <a href="javascript:void(0)" onclick="return show1();" id="active1" class="white"><?php echo $this->template->getWord('department');?></a>
                            <input type="hidden" name="dept" id="dept" value="1" />
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="return show2();" id="active2" class="white"><?php echo $this->template->getWord('brands');?></a>
                            <input type="hidden" name="brand" id="brand" value="1" />
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="return show3();" id="active3" class="white"><?php echo $this->template->getWord('offers');?></a>
                            <input type="hidden" name="offer" id="offer" value="1" />
                        </li>
                        <div class="clear" style="height:1px;"></div>
                    </ul>
                </div>
                
                <div class="loginpan" style="display:block;">
                    <ul>
                        <!--<li><a href="#" onclick="language_selector()">Language</a></li>-->
                        <?php 

           // $this->Template->getMultiLang();
            ?>
                       <?php /*?> <div id="polyglotLanguageSwitcher">
                        <?php $lang = $this->Template->getLang();?>
                            <form action="#">
                                <select id="polyglot-language-options">
                                    <option id="en" value="en" <?php if($lang == 'en'){echo 'selected';}?>> English <?php //echo $this->template->getWord('english');?></option>
                                  <?php /*?>    <option id="ar" value="ar" <?php if($lang != 'en'){echo 'selected';}?>><?php echo $this->template->getWord('arabic');?></option>
                                </select>
                            </form>
                        </div>
                        
                        <div class="languagepanel" id="languagepan" style="display:none;">
                            <a href="#">English<?php //echo $this->template->getWord('english');?></a>
                           <?php /*?> <a href="#" style="border:none; margin:0; padding:0;"><?php echo $this->template->getWord('arabic');?> </a> 
                            <!--<div class="languagedot"></div>-->
                        </div><?php */ ?>
                    </ul>
                </div>
             </div>
            </div>
              <div class="menupanel1" id="sample" style="display:none;">
              <?php echo $this->Template->getDepartMentTop(); ?>
            </div>
            <!--  Shop By Department Menu Panel Start  -->
            
            <!--  Shop By Brand Menu Panel Start  -->
            <div class="menupanel1" id="sample1" style="display:none;">
                <?php echo $this->Template->getBrandOnTop(); ?>
            </div>
            <!--  Shop By Brand Menu Panel Start  -->
            
            <!--  Shop By Offer Menu Panel Start  -->
            <div class="menupanel1" id="sample2" style="display:none;">
                <div class="grid">
                    <div class="listdata">
                        <?php /*?><ul>
                            <div class="drop3"></div>

                            <?php foreach ($offer as $key => $value) { 
                                
                                $image=json_decode($value['Product']['image_url']);
                                $offer_price=($value['Product']['price']-($value['Product']['price']*$value['Offer']['discount']/100));

                                $product_lang_data = $this->Template->languageChanger($value['Product_lang']);

                                ?>
                                <li>
                                <a href="<?=$this->webroot.$this->Template->getLang()."/products/".$value['Product']['id']?>-<?=$value['Product']['slug']?>" style="text-decoration:none;">
                                <div class="gimage">
                                    <div class="g-offers"><s><?=$this->Template->getPriceFormat(number_format($value['Product']['price'],2));?></s>&nbsp;&nbsp;<b><?=$this->Template->getPriceFormat(number_format($offer_price,2));?></b><br><img src="<?=$value['Offer']['offer_image']?>" style="height:30px;float:left;margin-top:1px;width:auto" alt="hoppay"><span><?=$value['Offer']['offer_desc']?></span></div>
                                    <div class="img_cover">
                               <img src="<?=$image[0]?>" alt="hoppay">
                           </div>
                                <h2><?=(strlen($product_lang_data['title'])>10)?substr($product_lang_data['title'],0,20).'..':$product_lang_data['title']?></h2>
                                </div>
                                </a>
                            </li>
                            <?php } ?>
                        
                            <?php if(!empty($offer)){ ?>
                            <li class="last">
                                <div class="gimage">

                                    <a href="<?=$this->webroot.$this->Template->getLang()?>/homes/offers">
                                      <div class="img_cover">
                                        <?php echo $this->Html->image('seeall.png', array('alt' => ''));?>
                                      </div>
                                    </a>
                                </div>
                            </li> 
                            <?php }else{ ?>
                                <h1 style="width: 100%"><span>No offers found.</span></h1>
                            <?php } ?>
                        </ul><?php */?>
                        <?php $this->Template->getHeaderOffers();?>
                    </div>
                </div>
                <div class="icon_close" onclick="hide_offer()">&nbsp;</div>
            </div>
            </div>
    	<div class="inner_header">
        	<!--  Main Menubar link Panel Start  -->
        	<div class="grid_inner">
            	<div class="toplogo">
                	<a href="<?=$this->webroot.$this->Template->getLang()?>">
                    	 <?php echo $this->Html->image('../'.$setting['Setting']['logo'], array('alt' => ''));?>
                       <?=$this->Template->getTagLine('innertag')?>
                    </a>
                </div>
               
                <div class="logintag">Merchant Center</div>
			<div class="loginpan"  style="display:block;">
                 <?php /*?> <ul>
                        <div id="polyglotLanguageSwitcher" >
                            <form action="#">
                                <select id="polyglot-language-options">
                                    <option id="en" value="en"<?=$this->Template->Select($this->Template->getLang(),'en')?>>English</option>
                                    <option id="ar" <?=$this->Template->Select($this->Template->getLang(),'ar')?> value="ar">Arabic</option>
                                </select>
                            </form>
                        </div>
                                
                        <!--<div class="languagepanel" id="languagepan" style="display:none;">
                            <a href="#">English</a>
                            <a href="#" style="border:none; margin:0; padding:0;">Arabic </a>
                        </div>-->
                     </ul><?php */?>
                </div>
            <?php if(!$this->Session->check('Merchant') ){

             // print_r($merchant);
             ?>

                 
                
          <div class="signinpan" style="float: right;margin-left:0px">
                <ul>
 						<li><a href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'signup'))?>">Sign up</a></li>
            <li style="border:none;"><a class="various_log" href="#login_popup<?php /*$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'login'))*/?>">Sign in</a></li>
            <?php }else{ ?>
          <div class="signinpan" style="float: right;margin-left:0px">
            <ul>
            <li><h3 class="merchant_head_log_user"><a style="box-shadow: none;background: none;" href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'index'))?>"><?="Welcome, <b>".ucfirst($merchant['Merchant']['first_name']."</b>")?></a></h3></li>
            <li style="border:none;"><a href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'logout'))?>">Sign out</a></li>
              
           <?php }?>
					
					</ul>
				</div>
				
                <!--  Login Panel StaEndrt  -->
                
            </div>
      </div>
         <div class="innernavpan">
                  <div id="nav2">
                    
                    <div class="grid_inner">

                    <?=$this->Template->menuCreater($merchant_menu,isset($merchantid)?$merchantid:"")?>
                    
                    </div>
                  
                        </ul>
                    </div>
                    
                </div>
        
        <div class="clear" style="height:1px; background:#fff;"></div>
        
        <!--  Main Body Panel Start  -->
        <div class="bodypanl">
       
        	<div class="grid_inner">
            	
               
  <?php echo $this->Session->flash(); ?>
  <?php echo $this->fetch('content'); ?>
    <div class="clear" style="height:0px;">&nbsp;</div>
          <?php echo $this->element('sql_dump'); ?>

            <div style="width:100%; background: #222a35; position:relative;">
                <div class="grid" style="padding: 14px 0px 17px 0px;margin-bottom: 14px;margin: 0 auto;width: 1002px;height: 10px;">
                <div class="fot1">
                     <?php 
                      $lang = $this->Template->getLang();
                      if($lang == 'en')
                        echo stripslashes($setting['Setting']['copyrgt_txt']);
                      else
                        echo stripslashes($setting['Setting']['copyrgt_txt_ar']);
                      ?>
                </div>
            
                <div class="fot2">
                    <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'ContactUs'))?>">Contact Us</a>  &nbsp; | &nbsp;
                    <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'TermsAndConditions'))?>">Terms & Conditions</a> &nbsp; | &nbsp;
                    <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'PrivacyPolicy'))?>">Privacy Policy</a>
                </div>
            
            </div>
            </div>
        
        </div>
        <!--  Footer Panel End  -->
        
</div>
        <style>
.delete_overly
{
  position: fixed;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  top: 0px;
  display: none;
  z-index: 100000000;
}
  .delete_action_popup{
    width: 50%;
    margin: 100px auto;
    height: auto;
    background: #fff;
    border: 11px solid rgba(85, 82, 82, 0.56);
    border-radius: 5px;

  }
.del_cnf_heading{
  width: 100%;
  font-size: 17px;
  text-align: center;
  padding: 7px 0px;
  background: #4A6EFF;
  color: #fff;
  font-weight: bold;
}
.del_cnf_inner_content .del_cnf_inner_deltails img{
  max-width: 150px;
  max-height: 109px;
  text-align: center;
  display: block;
  margin: 15px auto 0px auto;
}
 .del_cnf_inner_content .del_cnf_inner_deltails  .item_title{
  display: block;
  text-align: center;
  font-weight: bold;
  color: #1C75E7;
  text-transform: capitalize;
  font-size: 15px;
  margin-top: 20px;
 }
 .del_cnf_inner_content .del_cnf_inner_deltails  .conf_msg{
  display: block;
  text-align: center;
  font-size: 15px;
  color: #D36C1B;
 }
 .del_cnf_inner_action{
  border: 2px solid rgba(122, 143, 209, 0.34);
  border-bottom: 0px;
  border-left: 0px;
  border-right: 0px;
  padding: 13px 5px;
  margin-top: 25px;
 }
 .del_cnf_inner_action a{
  padding: 7px 29px;
  background: #5883CF;
  color: #fff;
  margin-left: 16px;
  border-radius: 2px;
  font-weight: bold;
 }
</style>
<script>
function deleteAction(updateUrl,type,title,imgpath,text){
  var CreateDeleteJson={
    'updateUrl':updateUrl,
    'type':type,
    'title':title,
    'imgpath':imgpath,
    'text':text
  }
    var template = $('#belete_cnf_inner').html();
    console.log(CreateDeleteJson);
    var html = Mustache.to_html(template, CreateDeleteJson);
    console.log(html);
    $('.delete_action_popup').html(html);
    $('.delete_overly').show();
}
function closeDeleterCnf(){
  $('.delete_overly').hide();
}


</script>
<script id="belete_cnf_inner" type="text/template">
 <div class="del_cnf_heading"> Delete confirmation for "{{type}}" </div>
 <div class="del_cnf_inner_content">
     <div class="del_cnf_inner_deltails">
     {{#imgpath}}
        <img src="{{imgpath}}" alt="hoppay">
     {{/imgpath}}
        <span class="item_title">{{title}}</span>
        <span class="conf_msg">{{text}}</span>
     </div>
     <div class="del_cnf_inner_action">
        <a href="{{updateUrl}}">Delete</a>
        <a href="javascript:void(0)" onclick="closeDeleterCnf()">Cancel</a>
     </div>
 </div>
</script>
<div class="delete_overly">
  <div class="delete_action_popup">

  </div>
</div>
<div id="login_popup" style="display:none">
<div class="signinleftpannew1" id="signinftr" style="height:inherit;">
                    <div class="rowpanel3" style="position:inherit;">
                        <div class="suez-cols" style="margin-top: -10px;">
                            <div class="rowpanel3" style="margin-top:5px;">
                            
                        <div class="suez-cols" style="margin: 0 auto;">
                            <div class="col3x offers" style="width:100% ; margin-top:0; padding-top:0;">
                    
                            <div id="step1" class="loginform" style="width: 100% !important;border:none!important;">
                        <div class="mer_login_msg"></div>                                             
          
                    <form  action="javascript:void(0);" name="loginform" id="validates_login" class="loginregisterform" style="display: block;">
                      <h2>
                        Have an Account? Sign in Here
                      </h2>
                      <div class="div60x loginpanel">
                        
                        <div class="form-field">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Username</label>
                          <input size="30" required type="text" name="username" id="user_email" class="form-text hasPlaceholder" style="background-image: url(<?=$this->webroot?>images/front-end/id.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 90%;">
                          </fieldset>
                          <p id="user_email_error" class="message">
                          </p>
                        </div>
                        <div class="form-field givepassword">
                          <fieldset class="user_name">
                          <label class="loginaddtion">Password</label>
                          <input size="30" required name="password" id="password" type="password" class="form-text"  style="background-image: url(<?=$this->webroot?>images/front-end/pass.png);background-repeat: no-repeat;
background-position: 3px 5px;padding-left: 35px;width: 90%;">
                          </fieldset>
                        </div>
                        
                      </div>
                      <div class="form-btns">
                        <span class="forgetpwd" style="display: none;">
                        <a href="#" class="thickbox" title="Forgot Password">
                        Forgot password?
                        </a>
                        </span>
                        <input type="submit" value="Sign in" name="login" style="float:left" class="form-sub">
                        <img src="<?=$this->webroot?>/images/sign_in_loader.gif" class="loader_img_sign_up" style="margin-top: 4px;display:none" width="25" alt="loader">
                        <br>
                      </div>
                      <div class="form-field" data-role="fieldcontain">
                        <fieldset>
                        <label class="inline newfiled">
                        <a href="<?=$this->Template->CreateParamLink(array(                                    
                                             'controller' => 'merchant',
                                             'action' => 'forgot_password'))
                                             ?>">
                        Forgot password?
                        </a>
                        </label>
                        </fieldset>
                      </div>
                    </form>
                                </div>
                            </div>
                        </div>
                        
                   </div>
                        </div>
                        
                        
                   </div>
                   
                    <!-- <div class="clear">&nbsp;</div> -->
                    
                </div>
              </div> 
                             

                    </div>
 <p id="back-top">
          <a href="#top"><span>
              
              <!--<br>Back <br><br>to <br><br>Top-->
              <img src="<?php echo $this->webroot;?>images/front-end/up-arrow.png" alt="up">
              </span></a>
        </p>
</body>
</html>