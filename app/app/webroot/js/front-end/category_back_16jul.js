function category(){
	this.slug=null;	
	var t=this;
	this.catArray={};
	this.addHash=function(hashval,callback){
     window.location.hash = '#'+hashval;
     if(typeof callback == "function") 
          callback(hashval);
    }
     this.getHash=function(){
	    var hash=window.location.hash;
	    return hash;
     }
     this.init=function(){
     	 this.selectedData();
     	 this.getDataActive();
     }

     this.getDataActive=function(){
     	$('.cat_tabs .cat_tab.active').each(function(k,v){
     		console.log(v);
     		$(v).find('.sub_clcik').click();
        });

     };
     this.selectedData=function(){
     	var hash=t.getHash();
     	if(hash!=undefined)
     	{
     		t.changeDOM('#cat_tab'+hash);
     	}
     }
     this.setOverly=function(select){
     	$(select).parents('.cat_tab_content_area').find('.filteroverly').show();
     }
     this.closeOverly=function(select){
     	$(select).parents('.cat_tab_content_area').find('.filteroverly').fadeOut();
     }
	this.checkTabs=function(select,slug){
		this.setOverly(select);
		this.slug=slug;	
		//console.log(t.catArray);
			if(!(slug in t.catArray))
			{		
				this.changeDOM(select,function(res){
					//console.log(res);
					if(res!=0)
					{
						t.doCall(slug,function(r){
							//console.log(r);
							if(r)
							{
								t.catArray[slug]=r;
							    t.changeInnerDOM(res,JSON.parse(r),function(e){
								  	if(e==1)
								  	t.closeOverly(select);
							    });
							  
							}
							
						})
					}
				   })
			}
			 else
			 {
			 	//console.log(t.catArray[slug]);
			 	this.changeDOM(select,function(res){
			 		t.changeInnerDOM(res,JSON.parse(t.catArray[slug]),function(e){
							  	if(e==1)
							  	t.closeOverly(select);
					});
			 	});
			 }  
			
		
		
		
	};
	this.doCall=function(slug,callback){
		  var url=this.baseUrl+this.lang+"/products/getCategoriesBySlug/"+slug;
	      var type="POST";
	      var data=null;
	      var result={};
	      this.ajaxCall(url,type,data,function(res,err){
	      	      	 result=res;
	      if(typeof callback == "function") 
                 callback(result);
	      });
		
	};
	this.changeDOM=function(select,callback){
		$(select).parents('.cat_tabs').find('.cat_tab').removeClass('active');
		$(select).parents('.cat_tab').addClass('active');
		var cntentArea=$(select).parents('.cat_tab_content_area').find('.cat_tab_contant');

		if(typeof callback == "function") 
          callback(cntentArea);

	};
	this.changeInnerDOM=function(select,data,callback){
		   // console.log(data);
			var template = $('#category_list').html();
			var fdata={'catlist': data};
			var html = Mustache.to_html(template,fdata);                  
            select.html(html);
            if(typeof callback == "function") 
	          callback(1);

	};
	/*--- Ajax Call function---*/
	 this.ajaxCall=function(url,type,params,callback){
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
      /*---End Ajax Call function ---*/
}
var catlist=new category();
