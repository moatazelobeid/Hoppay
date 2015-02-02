<style type="text/css">
body {
background: #ff7000;
background-size: 100%;
font-family: 'open_sanslight';
font-size: 100%;
background-repeat: no-repeat;
background-attachment: fixed;
background-size: cover;
background: #ff7000; /* Old browsers */
background: -moz-linear-gradient(top,  #ff7000 0%, #fc8600 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff7000), color-stop(100%,#fc8600)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ff7000 0%,#fc8600 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ff7000 0%,#fc8600 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ff7000 0%,#fc8600 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ff7000 0%,#fc8600 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff7000', endColorstr='#fc8600',GradientType=0 ); /* IE6-9 */

}
@font-face {
 font-family: 'open_sanslight';
 src: url('<?=$this->webroot?>css/fonts/OpenSans-Light.ttf');
 src: local('?'), url('<?=$this->webroot?>css/fonts/OpenSans-Light.ttf') format('truetype'),;
 font-weight: normal;
 font-style: normal;
}
@font-face {
 font-family: 'open_sansregular';
 src: url('<?=$this->webroot?>css/fonts/OpenSans-Regular.ttf');
 src: local('?'), url('<?=$this->webroot?>fonts/OpenSans-Regular.ttf') format('truetype'),;
 font-weight: normal;
 font-style: normal;
}
.wrap {
width: 70%;
margin: 3.2% auto 4% auto;
}
.logo h1 {
display: block;
padding: 0em;
}
.logo span {
font-size: 2em;
color: #fff;
}
.buttom {
background: url(<?=$this->webroot?>images/errorpage/bg2.png) no-repeat 100% 0%;
background-size: 100%;
text-align: center;
vertical-align: middle;
margin: 0 auto;
width: 556px;
}
.seach_bar {
padding: 2em;
}
.seach_bar p {
font-size: 1.5em;
color: #fff;
font-weight: 300;
margin: 2.6em 0em 0.9em 0em;
}
.search_box {
background: #F1F3F6;
-webkit-transition: all 0.3s ease;
-moz-transition: all 0.3s ease;
-o-transition: all 0.3s ease;
transition: all 0.3s ease;
padding: 6px 10px;
position: relative;
cursor: pointer;
width: 75%;
margin: 0 auto;
border-radius: 5px;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
-o-border-radius: 5px;
box-shadow: inset 0 0 5px rgba(156, 156, 156, 0.75);
-moz-box-shadow: inset 0 0 5px rgba(156, 156, 156, 0.75);
-webkit-box-shadow: inset 0px 0px 5px rgba(156, 156, 156, 0.75);
}
.search_box form input[type="text"] {
border: none;
outline: none;
background: none;
font-size: 1em;
color: #999;
width: 100%;
font-family: 'open_sansregular';
-webkit-apperance: none;
}
.search_box form input[type="button"] {
border: none;
cursor: pointer;
background: url(<?=$this->webroot?>images/errorpage/search.png) no-repeat 0px 1px;
position: absolute;
right: 0;
width: 34px;
height: 25px;
outline: none;
-webkit-appearance: none;
}
.logo {
padding: 1em;
text-align: center;
padding: 1% 1% 5% 1%;
}
.seach_bar span a {
font-size: 1em;
color: #fff;
text-decoration: underline;
font-weight: 300;
}
.search_box form{margin: 0; padding: 0;}
.logo span img{position: relative; top: 8px;}
.content{
	text-align: center;
}
.logo_img{
	margin-top: 50px;
	border: 2px solid #FFF;
	border-radius: 5px;
	padding: 2px 8px;
}
.search_hints {
	width: 90%;
text-align: left;
position: absolute!important;
top: 52px;
overflow: auto;
background: #fff;
color: #666;
border-radius: 0 0 5px 5px;
box-shadow: 2px 1px 2px #666;
display: none;


}
ul {
list-style: none;
padding: 0;
}
.search_hint {
padding: 5px 10px 10px;
}
.search_hint li.heading {
padding: 5px;
font-weight: 700;
text-transform: capitalize;
border-color: #666;
font-size: 15px;
cursor: default;
}
.search_hint li {
padding: 5px;
font-size: 14px;
}
.search_hint li.selected {
background: #f6f6f6;
}
.search_hint li a {
color: #666;
text-decoration: none;
display: block;
}
</style>
<script src="<?php echo $this->webroot;?>js/front-end/jquery.min.js"></script> 
<script src="<?php echo $this->webroot;?>js/front-end/jquery.nouislider.min.js"></script>
<script>
$(document).mouseup(function (e){
    var container = $("#innersample");
    
    
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $("#active1").attr('class', 'department');
        $('.recent_visit').removeClass('active');
        //$('#dept').val(1);
    }
    
   

});
function getSearchHints(id,text){
    //alert('dd');
    if(text!="")
    {
            $.post('<?=$this->webroot?>homes/getSearchHints',{'id':id,'text':text},function(r){
            console.log(r);
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
                        //console.log(x);
                        if(x==0)
                        {
                             var clas="selected move";
                        }
                        else
                        {
                            var clas="move";
                        }
                        //var filter = new RegExp(text + "gi");
                       var changed_text=searchHint.names[x].toLowerCase().replace($.trim(text.toLowerCase()),'<b>'+$.trim(text.toLowerCase())+'</b>')
                        hint.append("<li class='"+clas+"'><a  href='<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-"+searchHint.slugs[x]+"-"+id+"'>"+capitalize(changed_text)+"</a></li>")
                       
                    }
                    /*if(searchHint.barands!="")
                    {
                       hint.append("<li class='heading'>Brand Matches</li>")
                        for(var x in searchHint.barands)
                        {
                            hint.append("<li class='move'><a  href='<?=$this->webroot?>brand-"+searchHint.barands[x]+"'>"+$.trim(searchHint.barands[x].replace(/[-]+/, " ")).toLowerCase()+"</a></li>")
                        }
                    }*/
                    
                    $('.total_hints').html(hint);
                        setTimeout(function() {
                            $(".nano").nanoScroller();
                        }, 100);
                }else
                {
                    $('.search_hints').slideUp();
                }
            }
            


            
        })

    }
    else
    {
      $('.search_hints').slideUp();
    }
}
$(function(){
   
    $('.search-bar-text').keyup(function(e){
        var keyup=0;
        
        switch (e.keyCode) {
            case 40:
                $('.search_hint .move:not(:last-child).selected').removeClass('selected').next('.move').addClass('selected').focus();
                var searchtext=$('.search_hint li.selected a').text();
                 $('.search-bar-text').val(searchtext);
                 keyup=1;
                break;
            case 38:
                $('.search_hint .move:not(:nth-child(2)).selected').removeClass('selected').prev('.move').addClass('selected').focus();
                var searchtext=$('.search_hint li.selected a').text();
                 $('.search-bar-text').val(searchtext);
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
                      $('.search-bar-text').val(searchtext);
                      window.location.assign($('.search_hint li.selected a').attr('href')+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                    }
                     else if($.trim($('.search-bar-text').val())!="")
                    {
                          var id=$(".search-bar-text").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($('.search-bar-text').val());
                         slug=slug.replace(/ /g,'-');
                         window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-'+slug+'-'+id+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                    }else
                    {
                        
                         var id=$(".search-bar-text").attr('data-id');
                         if(id!=0)
                         {
                            var slug=$("#showlistdata").attr('data-slug');
                            window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/products/category-'+slug+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                         }
                    }
                    /*else
                    {
                         var id=$("#fk-top-search-box").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($('.search-bar-text').val());
                         slug=slug.replace(/ /g,'-').toLowerCase();
                         window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-'+slug+'-'+id);
                    }*/
            break;
            default:
            if($(this).val().length>3)
               {
                var id=$(".search-bar-text").data('id');
                console.log
                if(id==undefined)
                {
                    id=0;
                }
                console.log($(this).val());
               // getOffer(id,$(this).val());
                getSearchHints(id,$(this).val());
            }
            else
               {
                 $('.search_hints').slideUp();
               }
            break;
        }
         
    })

    
})
function onSearch(){
    var id=$(".search-bar-text").attr('data-id');
                            if(id=='')
                            {
                                id=0;
                            }
                         var slug=$.trim($('.search-bar-text').val());
                         slug=slug.replace(/ /g,'-').toLowerCase();
                         //console.log(slug);
                         if($.trim(slug)!="")
                         {
                            window.location.assign('<?=$this->webroot?><?=$this->Template->getLang()?>/search-for-'+slug+'-'+id+'<?=(isset($dtype) and ($dtype=="list"))?"-".$dtype:""?>');
                         }
                         
}
function capitalize (text) {
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
}
</script>
<div class="error_page">
<div class="wrap">
	
		<div class="content">
			
			<div class="logo">
				<h1><a href="#"><img src="<?=$this->webroot?>images/errorpage/404.png" alt="hoppay"></a></h1>
				<span><img src="<?=$this->webroot?>images/errorpage/signal.png" alt="hoppay">Oops! The Page you requested was not found!</span>
			</div>
		
			
			<div class="buttom">
				<div class="seach_bar">
					<p>you can go to <span><a href="<?=$this->webroot?>">home</a></span> page or search here</p>
					
					<div class="search_box">
					<form action="javascript:void(0)">
					   <input type="text" value="Search" class="search-bar-text" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" data-id="0"><input type="button" value="" onclick="onSearch()">
					    <style>
                        .search_hints{
                            max-height: 144px !important;
                            overflow: hidden;
                        }
                        </style>
                        <div class="nano search_hints" style="top: 39px;left: 15px;box-shadow: 0px 1px 4px #666;z-index: 1;">
                                <div class="nano-content total_hints">
                                   <!---Here the suggesion will riflect -->
                               </div>
                          </div>
				    </form>
					 </div>
				</div>
			</div>
            <?php echo $this->Html->image('../'.$setting['Setting']['logo'], array('alt' => '','width'=>'200','style'=>"margin-top:50px"));?>
			<!-- <img src="<?=$this->webroot?>img/logo.png" width="200" class="logo_img" style="margin-top:50px"> -->
			
		</div>
		
	
	</div>
</div>
