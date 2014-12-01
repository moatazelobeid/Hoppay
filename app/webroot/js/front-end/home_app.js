$(function(){
	jQuery('#responsive').change(function(){
	  $('#responsive_wrapper').width(jQuery(this).val());
	});
	 $('.nano').nanoScroller({
   preventPageScrolling: true
  });
	/* $("div.hover-text").hide();
		$("div.gimage").hover(function(){
		$(this).find("div.hover-text").slideToggle(500);*/
	//});
	
	$("div.gimage").css({'position' : 'relative'});
	$("div.hover-text").css({'position' : 'absolute','bottom' :1});
	  $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
        effect: 'fade',
                testMode: true,
                onChange: function(evt){
                  // alert("The selected language is: "+evt.selectedItem);
                    if(evt.selectedItem=="ar")
                    { 
                      langPath=getLangUrl(evt.selectedItem,'en');
						 
						 var islang_ar = (langPath.indexOf("/en") > -1);
						 
						 if(islang_ar == true)
						 {
							langPath = langPath.replace("/en", ""); 	 
						 }
						 
						window.location.assign(langPath);
                   }else if(evt.selectedItem=="en")
                   {
                    
					 langPath= getLangUrl(evt.selectedItem,'ar');
					  
						 var islang_eng = (langPath.indexOf("/ar") > -1);
						 
						 if(islang_eng == true)
						 {
							langPath = langPath.replace("/ar", ""); 	 
						 }
						 
						window.location.assign(langPath);
                   }
                    
                     //console.log(window.location);
                }
//               
            });

$('#searchbar').typing({
    start: function (e, $elem) {
    	console.log(e.which);
       var keyup=0;
        switch (e.keyCode) {
            case 40:
                $('.search_hint .move:not(:last-child).selected').removeClass('selected').next('.move').addClass('selected').focus();
                 var searchtext=$('.search_hint li.selected a').text();
                 $elem.val(searchtext);
                 keyup=1;
                break;
            case 38:
                $('.search_hint .move:not(:nth-child(2)).selected').removeClass('selected').prev('.move').addClass('selected').focus();
                var searchtext=$('.search_hint li.selected a').text();
                 $elem.val(searchtext);
                 keyup=1;
                break;
            case 13:
            var searchtext="";
            		if(keyup==1)
            		{
            			 searchtext=$('.search_hint li.selected a').text()
            		}
                   
                   //console.log(searchtext);
                    if(searchtext!='')
                    {
                      $elem.val(searchtext);
                      window.location.assign($('.search_hint li.selected a').attr('href'));
                    }
                    else if($.trim($elem.val())!="")
                    {
                         var id=$("#showlistdata").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($elem.val());
                         slug=slug.replace(/ /g,'-');
                         window.location.assign(rootPath+lang+'/search-for-'+slug+'-'+id);
                    }else
                    {
                    	 var id=$("#showlistdata").attr('data-id');
                    	 if(id!=0)
                    	 {
	                    	var slug=$("#showlistdata").attr('data-slug');
	                    	window.location.assign(rootPath+lang+'/products/category-'+slug);
                         }
                    }
            break;
            default:
            	
            break;
        }
    },
    stop: function (e, $elem) {
    	
     var id=$("#showlistdata").attr('data-id');
            	var slug=$("#showlistdata").attr('data-slug');
	                if(id=="")
	                {
	                    id=0;
	                }
					//getOffer(id,slug,$elem.val());
               if($elem.val().length>3)
               {
	                
					getSearchHints(id,$elem.val());
			   }else
			   {
			   	 $('.search_hints').slideUp();
			   }
    

    },
    delay: 1000
});
	$('#searchbar').keyup(function(e){
		var keyup=0;
      switch (e.keyCode) {
            case 40:
                $('.search_hint .move:not(:last-child).selected').removeClass('selected').next('.move').addClass('selected').focus();
                 var searchtext=$('.search_hint li.selected a').text();
                 $(this).val(searchtext);
                 keyup=1;
                break;
            case 38:
                $('.search_hint .move:not(:nth-child(2)).selected').removeClass('selected').prev('.move').addClass('selected').focus();
                var searchtext=$('.search_hint li.selected a').text();
                 $(this).val(searchtext);
                 keyup=1;
                break;
            case 13:
            var searchtext="";
            		if(keyup==1)
            		{
            			 searchtext=$('.search_hint li.selected a').text()
            		}
                   
                   //console.log(searchtext);
                    if(searchtext!='')
                    {
                      $(this).val(searchtext);
                      window.location.assign($('.search_hint li.selected a').attr('href'));
                    }
                    else if($.trim($(this).val())!="")
                    {
                         var id=$("#showlistdata").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=unifuedSearchText($.trim($(this).val()));
                         slug=slug.replace(/ /g,'-');
                         window.location.assign(rootPath+lang+'/search-for-'+slug+'-'+id);
                    }else
                    {
                    	 var id=$("#showlistdata").attr('data-id');
                    	 if(id!=0)
                    	 {
	                    	var slug=unifuedSearchText($("#showlistdata").attr('data-slug'));
	                    	window.location.assign(rootPath+lang+'/products/category-'+slug);
                         }
                    }
            break;
         
        }
    
	})
$('#ca-container').contentcarousel({
    // speed for the sliding animation
    sliderSpeed     : 500,
    // easing for the sliding animation
    sliderEasing    : 'easeOutExpo',
    // speed for the item animation (open / close)
    itemSpeed       : 500,
    // easing for the item animation (open / close)
    itemEasing      : 'easeOutExpo',
    // number of items to scroll at a time
    scroll          : 1 
});
	var offset = 100;
	var duration = 1000;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > offset) {
			jQuery('.back-to-top').fadeIn(duration);
		} else {
			jQuery('.back-to-top').fadeOut(duration);
		}
	});
	
	jQuery('.back-to-top').click(function(event) {
		event.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, duration);
		return false;
	})
	$('.check_all').change(function(){
  //alert('sdfsd');

  if($(this).is(':checked')){
    $('.check_all').attr('checked','checked');
    $('.user_checked').attr('checked','checked');
  }
  else
  {
     $('.check_all').removeAttr('checked');
     $('.user_checked').removeAttr('checked');
  }

});

$('#action_option').change(function(){
    var data=new Array();
    $('.user_checked:checked').each(function(){
         data.push($(this).data('id'));
     });
   
    var jsonArray = JSON.parse(JSON.stringify(data));
if(data.length<=0){
  //alert('no data');
}
else{
    if($(this).val()=='1')
    {
        $.post('<?=$this->webroot?>Products/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Product'},function(r){
          console.log(r);
          if(r=='1')
          {
             window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>Products/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Product'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>Products/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Product'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#delete').val());
            
          }
        })
    }
 }
})

})
$(document).mouseup(function (e){
    var container = $("#sample");
    var container1 = $("#sample1");
    var container2 = $("#sample2");
    var container5 = $(".clt2");
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
if (!container5.is(e.target) // if the target of the click isn't the container...
        && container5.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container5.find('.search_hints').slideUp();
        container5.find('.listdatapan').hide();
       
    }
   

});
function show1()
{
  //console.log($('#dept').val());
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
	
	if($('#offer').val() == 1)
	{
		$("#sample2").show();
		$('#offer').val(2);
		$('#dept').val(1);
		$('#brand').val(1);
		$("#active3").attr('class', 'yellow');
		 $('.nano').nanoScroller({
   preventPageScrolling: true
  });
	}
	else
	{
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
	$('.nano').nanoScroller({
   preventPageScrolling: true
 });
	$('.search_hints').slideUp();
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
function displayDropdown(id,slug){
	 if($("#linkID"+id).html()!=''){
	 	$("#showlistdata").addClass('search_filterdata'); 
	 }
	 else{
	 	$("#showlistdata").addClass('searchlistpan'); 
	 }
	 
	var divVal = $("#linkID"+id).html();
	$("#showlistdata").html(divVal);
	$("#showlistdata").attr('data-id',id);
	$("#showlistdata").attr('data-slug',slug);
	$(".listdatapan").hide();
	
	//getOffer(id,slug,$('#searchbar').val());
}
function capitalize (text) {
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
}
function changeCss(sert)
{
	$('.clt2').css({'opacity':1,'border': '2px solid #fff'});
}
function changeCss1(sert)
{
	
	$('.clt2 .listdatapan .nano').css({'opacity':1});
	
	 
}
function changeThe(check){
	
	$('.listdatapan').hide();
}
function changeThe1(check){
	$('.clt2 .search_hints').css({'opacity':1,/*'border': '2px solid #FA7E0B'*/});
	

}
function setCookie(key, value) {  
   var expires = new Date();  
   expires.setTime(expires.getTime() + 31536000000); //1 year  
   document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();  
}  
  
function getCookie(key) {  
   var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');  
   return keyValue ? keyValue[2] : null;  
   }  
   function addimage(str){
	if(str != ""){
		$(".clt2 .searchnow_normal").hide();
		$(".clt2 .searchnow").show();
	}else{
		$(".clt2 .searchnow_normal").show();
		$(".clt2 .searchnow").hide();
	}
	
	
	if($("#searchbar").val() != ''){
		
		$("#newbottompan1").hide();
		$("#newbottompan2").show();
	}
	else{
		$(".clt2").css('border','2px solid #fff');
		
		$("#newbottompan1").show();
		$("#newbottompan1").show();
		$("#newbottompan2").hide();
	}
}
function language_selector(){
	$("#languagepan").toggle();
}
window.onload=function(){
	var id=getCookie('id');
	var slug=getCookie('slug');
	var text=getCookie('text');	
	 addimage($('#searchbar').val());
	 if(text!=undefined)
    {
	
    }
	if(id!=undefined)
	{
		
    }
    myonloadefunc();
	resizeTheImage();
};
var onoff=1;
function hidefooter(){
	
	$(".fotpanslider").toggleClass("fullscreen_onclick");
	$(".fullscreen").toggleClass("fullscreen_close_onclick");
	if(onoff==1)
	{
		$(".fotpanslider").removeClass("fullscreen_open");
		onoff=0;
    }
    else
    {
    	$(".fotpanslider").addClass("fullscreen_open");
	  
    }
}
function get_width(){
	var xx;
	
	var cc = $("#showlistdata").html();
	var dd = parseInt(cc.length);
	if(dd <= 7){
	xx = 18	
	}else if(dd > 7 && dd <= 12){
	xx = 13;	
	}else if(dd > 12 && dd <= 20){
	xx = 10;	
	}else if(dd > 21 && dd <= 30){
	xx = 8;	
	}else{
	xx = 8; 
	}
	var dd2 = parseInt(cc.length)  *  xx;
	dd2 = dd2 - 10;
	$("#showlistdata").css('width',''+dd2+'px');
}
function myonloadefunc(){
	$(".fotpanslider").addClass("fullscreen_open");
	var width1=0
	var width = $(window).width(), height = $(window).height();
		
if ((width <= 800) && (height <= 600)) {
    items_num=4;
} 
else if ((width <= 1024) && (height <= 768)) {
   items_num=6;
}
else if ((width <= 1280) && (height <= 850)) {
   items_num=8;
}
else if ((width <= 1366) && (height <= 850)) {
   items_num=9;
}
else
{
	 items_num=10;
}
$(".ca-item").each(function(k,v){
			if(k< items_num)
			width1+=$(this).width();
			
			$('.ca-wrapper').css({'width':width1,'margin':'0 auto'})
		})
		
		
	
}
function resizeTheImage(){
    var width = $(window).width(), height = $(window).height();
  if(width<height)
  {
    $('.front_back_banner').each(function(){
      $(this).attr('src',$(this).data('port'));
    });
    
  } 
  else 
  {
     $('.front_back_banner').each(function(){
      $(this).attr('src',$(this).data('land'));
    });
  }
}
jQuery(window).resize(function () {
var width2=0;
    var items_num=0;
		var width = $(window).width(), height = $(window).height();
    console.log(width);
    console.log(height);
	resizeTheImage();
if ((width <= 768) && (height <= 1024)) {
   items_num=4;
  }
 else if ((width <= 800) && (height <= 1280)) {
    items_num=5;
} 
 else if ((width <= 980) && (height <= 1280)) {
    items_num=6;
} 
else if ((width <= 800) && (height <= 600)) {
    items_num=4;
} 
else if ((width <= 1024) && (height <= 768)) {
   items_num=6;
}
else if ((width <= 1280) && (height <= 980)) {
  items_num=8;
 }
else if ((width <= 1280) && (height <= 850)) {
   items_num=8;
}
else if ((width <= 1366) && (height <= 850)) {
   items_num=9;
}
else
{
	 items_num=10;
}
$(".ca-item").each(function(k,v){
			if(k< items_num)
			width2+=$(this).width();
			
			$('.ca-wrapper').css({'width':width2,'margin':'0 auto'})
		})
});
 /* function getLangUrl(current,priv){
                  
                     var fullpath=window.location.href;
                     var getdata=fullpath.split('/'+priv+'/');
					
					 
                     if(getdata[1]==undefined)
                     {
						 var path=window.location.origin+rootPath;
						 var rest=fullpath.split(path);
                     	
						 
						 var langPath=path+current+"/"+rest[1];
						 langPath=langPath.replace(/#/g,"");
                     }
                     else
                     {
                      var langPath=getdata[0]+"/"+current+"/"+getdata[1];
                       langPath=langPath.replace(/#/g,"");
                     }
                     return langPath;
       }*/
       function getLangUrl(current,priv){
                  
                     var fullpath=window.location.origin+window.location.pathname;
                     console.log(window.location);
                     var getdata=fullpath.split('/'+priv+'/');
                     if(getdata[1]==undefined)
                     {
                     var path=window.location.origin+rootPath;
                     var rest=fullpath.split(path);
                     //rest[1].split;
                     var langPath=path+current+"/"+rest[1];
                     
                     }
                     else
                     {
                      var langPath=getdata[0]+"/"+current+"/"+getdata[1];
                       
                     }
                     // langPath=langPath.replace('#',"");
                    langPath+=window.location.hash;
                     //alert(langPath);
                     return langPath;
       }
       var xhr;
function getOffer(id,slug,text){
   //text= unifuedSearchText(text);
	$('.overly').remove();
	$('#ca-container').append('<div class="overly"><div class="ajax_loader" style="margin: 25px auto;"></div></div>');
        if(xhr && xhr.readystate != 4){
            xhr.abort();
        }
  xhr=$.post(rootPath+lang+'/homes/getoffers',{'id':id,'text':text},function(r){
	//console.log(r);

	r=r.trim();
	if(r.length>0)
	{
		
		$('.ca-wrapper').html(r);
		$('.ca-nav').remove();
		$('#ca-container').contentcarousel();
		myonloadefunc();
		$('.overly').remove();
		
		
	}
	else
	{
		$('.ca-wrapper').html("");
		$('.overly').remove();
		$('#ca-container').append('<div class="overly"><div class="noresfound" style="">No Offers Found.</div>');
	}
})
}

function getSearchHints(id,text){
	//alert('dd');
  text=unifuedSearchText(text)
	if(text!="")
    {
            $.post(rootPath+lang+'/homes/getSearchHints',{'id':id,'text':text},function(r){
            
            r=r.trim();
            if(r.length>0)
            {
                var searchHint=JSON.parse(r);
               
                if(searchHint.names!="")
                {   
                    $('.search_hints').slideDown();

                    var hint=$('<ul class="search_hint">');
                   hint.append("<li class='heading'>Search Suggestions</li>")
                    for(var x in searchHint.names)
                    {
                        var clas=""
                       
                        if(x==0)
                        {
                            var clas="selected move";
                        }
                        else
                        {
                            var clas="move";
                        }
                        
                      var changed_text=searchHint.names[x].toLowerCase().replace($.trim(text.toLowerCase()),'<b>'+$.trim(text.toLowerCase())+'</b>')
                     
                        hint.append("<li class='"+clas+"'><a  href='"+rootPath+lang+"/search-for-"+searchHint.slugs[x]+"-"+id+"'>"+capitalize(changed_text)+"</a></li>")
                       
                    }
                   
                    
                    $('.total_hints').html(hint);
                        setTimeout(function() {
                            $(".nano").nanoScroller();
                        }, 100);
                }else
                {
                	
                    $('.search_hints').slideUp();
                }
            }
            else
                {
                	 
                    $('.search_hints').slideUp();
                }


            
        })

    }
    else
    {
      $('.search_hints').slideUp();
    }
}
function unifuedSearchText(text){
  string = text.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '-');
  return string
}
	function onSearch(){
	 var id=$("#showlistdata").attr('data-id');
	 if(id!=0)
	 {
	 	 var slug=unifuedSearchText($.trim($('#searchbar').val()));
	 	 if(slug!="")
	 	 {
		 slug=slug.replace(/ /g,'-');
		 window.location.assign(rootPath+lang+'/search-for-'+slug+'-'+id);
		 }
		 else
		 {
		 	var slug=$("#showlistdata").attr('data-slug');
		 	window.location.assign(rootPath+lang+'/products/category-'+slug);
		 }
	 }
	 else
	 {
	 	var slug=unifuedSearchText($.trim($('#searchbar').val()));
	 	 if(slug!="")
	 	 {
			 slug=slug.replace(/ /g,'-');
			 window.location.assign(rootPath+lang+'/search-for-'+slug+'-'+id);
		 }
	 }
	
}
var timer1 = setInterval( 
  function(){ 
    var el1 = jQuery('.ca-nav-next'); 
    el1.click(); 
  }, 
5000);
