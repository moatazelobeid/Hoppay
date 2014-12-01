$(function(){
	jQuery('#responsive').change(function(){
	  $('#responsive_wrapper').width(jQuery(this).val());
	});
	 $('.nano').nanoScroller({
   // preventPageScrolling: true
  });
	 $("div.hover-text").hide();
		$("div.gimage").hover(function(){
		$(this).find("div.hover-text").slideToggle(500);
	});
	
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
					getOffer(id,slug,$elem.val());
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
                         var slug=$.trim($(this).val());
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
         
        }
    
	})
})
$(document).mouseup(function (e){
    var container = $("#sample");
    var container1 = $("#sample1");
    var container2 = $("#sample2");
    var container5 = $(".clt2");
    //var container6 = $(".listdatapan");
    
    if (!container.is(e.target) // if the target of the click isn't the container...
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
if (!container5.is(e.target) // if the target of the click isn't the container...
        && container5.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container5.find('.search_hints').slideUp();
        container5.find('.listdatapan').hide();
       
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
	
	if($('#offer').val() == 1)
	{
		$("#sample2").show();
		$('#offer').val(2);
		$('#dept').val(1);
		$('#brand').val(1);
		$("#active3").attr('class', 'yellow');
		$(".nano").nanoScroller();
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
	
	getOffer(id,slug,$('#searchbar').val());
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
jQuery(window).resize(function () {
var width2=0;
    var items_num=0;
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
			width2+=$(this).width();
			
			$('.ca-wrapper').css({'width':width2,'margin':'0 auto'})
		})
});
  function getLangUrl(current,priv){
                  
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
       }
       function getOffer(id,slug,text){

	$('.overly').remove();
	$('#ca-container').append('<div class="overly"><div class="ajax_loader" style="margin: 25px auto;"></div></div>');
$.post(rootPath+lang+'/homes/getoffers',{'id':id,'text':text},function(r){
	
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
	function onSearch(){
	 var id=$("#showlistdata").attr('data-id');
	 if(id!=0)
	 {
	 	 var slug=$.trim($('#searchbar').val());
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
	 	var slug=$.trim($('#searchbar').val());
	 	 if(slug!="")
	 	 {
			 slug=slug.replace(/ /g,'-');
			 window.location.assign(rootPath+lang+'/search-for-'+slug+'-'+id);
		 }
	 }
	
}

