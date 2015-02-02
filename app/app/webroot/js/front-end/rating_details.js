(function($){

	$.fn.ratingDetails = function(options) {

           // Here we put the default settings.
           
           	  
           	 
          
           
	        var settings = $.extend({	            
	            color: "#000000",
	            backgroundColor: "#fff",
	            progrssColor:"#5f92da",
	            action:"hover",
	            ajaxUrl:"http://192.168.1.47/menacompare/products/ajaxGetRatings",
	            lang: "en",
	            text: "out of 5 Stars",
	           
	        }, options );
	        var datas=[];
	        var rItemDetails=null;
	        this.filter( "div" ).each(function() {
		            var link = $( this );	
		           debug(settings.ajaxUrl);
		            var type=link.data('type');	
		            var id=link.data('id');	
		            var rot=link.data('rot');
		           //
		            if(rot==undefined)
		            {
		            	rot="right";
		            }
		          // debug(rot);
		           //Handel Actions you can add multiple actions in her like('click','hover','dbclick');
		         var template='<div id="seller-rating-hover" class="sellerRatingHover seller-rating-hover-show" style="right: 0px; top: 0px;"><div class="reviews-summary-column"><div class="reviews-summary-graph"><h3>{{avg}} out of 5 Stars</h3><div class="reviews-summary-graph"><ol>{{#counts}}<li>{{#.}}<div class="star-label">{{name}}</div><div class="summary-bar"><div style="width: {{percent}}%"></div></div><div class="summary-count-container"><div class="summary-bar-count">{{tot}}</div></div>{{/.}}</li>{{/counts}}</ol></div></div></div><div id="SRhoverArrowLeft" class="seller-rating-hover-hide  {{settings.rot}}"></div><div id="SRhoverArrowRight"  class="seller-rating-hover-show  {{settings.rot}}"></div></div>';   
		            
		            datas.push({type:type},{id:id});
		            ajaxCall(settings.ajaxUrl,'POST',{type:type,id:id},function(r){
		            	if(r)
		            	{
		            		//debug(r);
		            		jdata=JSON.parse(r);
		            		jdata.settings=settings;
		            		jdata.settings.rot=rot;

		            		//debug(jdata);
		            		if(jdata.error!=1)
		            		{
		            			rItemDetails=$('<div class="rating_details"></div>');
				                var rItem=rItemDetails.appendTo(link);
				                var html = Mustache.to_html(template, jdata);
	                            rItemDetails.html(html);			                
				                rItemDetails.hide();

				                link.find('.showratings').on( settings.action, function(){
				                	showDetails(rItem,link,rot,settings);
				                });
		            		}
		            		
		            	}
		            })
		            


            		 // debug( datas );
            		 // debug( id );
            });
           

   };
   
   function showDetails(sthis,link,set,setting){
   debug(sthis.css('display'));
   	if(sthis.css('display')=="none")
   	{
   		 
   		// var position=link.position();
   		// var width=link.width();
   		//debug(set);
   		 var position=link.find('.showratings').offset();
   		 sthis.show();
   		 var width=sthis.find('.sellerRatingHover').width();
   		 if(setting.lang=="en")
   		 {
	   		 if(set=="right")
	   		 {
	   		 	 sthis.find('.sellerRatingHover').css({top: (position.top-26-58-28),left: (position.left-width-35)});
	   		 }
	   		 else
	   		 {
	   		 	 sthis.find('.sellerRatingHover').css({top: (position.top-26-58-28),left: (position.left+width-35)});
	   		 }
   		}
   		else
   		{
   			var wwidth=$(document).width();
   			if(set=="right")
	   		 {
	   		 	 sthis.find('#SRhoverArrowLeft').show();
	   		 	 sthis.find('#SRhoverArrowRight').hide();
	   		 	 sthis.find('.sellerRatingHover').css({top: (position.top-26-58-28),right: ((wwidth-position.left)-width-120)});
	   		 }
	   		 else
	   		 {
	   		 	sthis.find('#SRhoverArrowLeft').hide();
	   		 	 sthis.find('#SRhoverArrowRight').show();
	   		 	 sthis.find('.sellerRatingHover').css({top: (position.top-26-58-28),right: ((wwidth-position.left)+width-190)});
	   		 }
   		}
   		
   		 //sthis.find('.sellerRatingHover').animate(position);
   		 //debug(position);
   		  //debug(width);

   	}
   	else
   	{
   		sthis.hide();
   		
   	}
   }
 
  /*--- Ajax Call function---*/
var ajaxCall=function(url,type,params,callback){
	      var response={};
	      var error={};
	      $.ajax({
	        type: type,
	        url: url,
	        cache: false,       
	        data:params,
	        success: function(res){
	          //console.log(res);
	          response=res;
	          if(typeof callback == "function") 
	          callback(response,error);
	        },
	        error: function(){            
	          error={'error':'We found some problem plz try letter'}
	         if(typeof callback == "function") 
	          callback(response,error);
	        }
	      });       
	    
	    }

   function debug( obj ) {
        if ( window.console && window.console.log ) {
            window.console.log(obj);
        }
    };
})(jQuery);
/*<li>
											<div class="star-label">5 star</div>
											<div class="summary-bar">
											  <div style="width: 30%"></div>
											</div>
											<div class="summary-count-container">
												<div class="summary-bar-count">118(6)</div>
											</div>
										  </li>
										  
										  <li>
											<div class="star-label">5 star</div>
											<div class="summary-bar">
											  <div style="width: 20%"></div>
											</div>
											<div class="summary-count-container">
												<div class="summary-bar-count">18(6)</div>
											</div>
										  </li>
										  
										  <li>
											<div class="star-label">5 star</div>
											<div class="summary-bar">
											  <div style="width: 18%"></div>
											</div>
											<div class="summary-count-container">
												<div class="summary-bar-count">18(2)</div>
											</div>
										  </li>
										  
										  <li>
											<div class="star-label">5 star</div>
											<div class="summary-bar">
											  <div style="width: 6%"></div>
											</div>
											<div class="summary-count-container">
												<div class="summary-bar-count">5(1)</div>
											</div>
										  </li>*/