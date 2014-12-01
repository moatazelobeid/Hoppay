function filter(cattegory,brand,merchant,sear_type,slug,search_id,baseUrl,listtype,top_filter_type,attr_filter,lang_data){
    this.baseUrl=baseUrl;
    this.filter_category=cattegory;
    this.brand_filter=brand;
    this.merchant_filter=merchant;
    this.type=sear_type;
    this.top_filter_type=top_filter_type;
    this.search_id=search_id;
    this.attr_filter=attr_filter;
    this.lang=lang_data;
    this.bedcrom="";
    this.selectedCat=0;
  //this.listtype=listtype;
  /*-- Hashing Function --*/
  this.addRootHash=function(hashval,callback){
     window.location.hash = '#'+hashval;
       if(typeof callback == "function") 
            callback(hashval);
  }

  this.addHassesToMeltivews=function(){
    var hashdata= window.location.hash;
    var grid=$('.gridview').attr('href');
    var list=$('.listview').attr('href');
    var grid_data=grid.split('#');
    var list_data=list.split('#');
    $('.gridview').attr('href',grid_data[0]+hashdata)
    $('.listview').attr('href',list_data[0]+hashdata)
  }

  this.addHash=function(hashval,callback,type,clType){
     hash=this.getHash();    
    console.log(hashval);  
    switch(type){
      case 'attr':
        var attr=hash.attr;
        if(attr!=undefined)
        {
           hashval=hashval.replace(/["]+/g,'');
           hashval=hashval.replace(/["]+/g,'');
          console.log(clType);
           if(clType=="clear")
           {
           console.log(hashval);
            
              hashval='attr:"'+hashval+'"';
              
           }else
           {
            hashval='attr:"'+attr+'@'+hashval+'"';
           }
           
        }
        else
        {
           hashval='attr:'+hashval;
        }
        console.log(hashval);
       if(hashval=='attr:')
       {
        hashval='';
       }
      break;
       case 'brand':
        var brand=hash.brand;
        if(brand!=undefined)
        {
           //hashval=hashval.replace(/["]+/g,'');
           //hashval=hashval.replace(/["]+/g,'');
           hashval='brand:"'+brand+'_'+hashval+'"';
        }
        else
        {
           hashval='brand:'+hashval;
        }
      break;
      case 'merchant':
      var merchant=hash.merchant;
        if(merchant!=undefined)
        {
           //hashval=hashval.replace(/["]+/g,'');
           //hashval=hashval.replace(/["]+/g,'');
           hashval='merchant:"'+merchant+'_'+hashval+'"';
        }
        else
        {
           hashval='merchant:'+hashval;
        }
      break;
     
     }  
    console.log(hashval);  
    // hashval=JSON.stringify("{"+hashval+"}");
    // obj=JSON.parse(hashval);
    hashval=hashval.replace(/[/]+/g,'');
     hash1=eval("var obj="+"{"+hashval+"}");     
     hash=jQuery.extend(hash,obj);
     hash=JSON.stringify(hash);
     hash=hash.replace(/["]+/g,'');
      hash=hash.replace(/["]+/g,'');
     hash=hash.replace(/{/g,'');
     hash=hash.replace(/}/g,'');
    // console.log(hash);

     window.location.hash = '#'+hash;
     if(typeof callback == "function") 
          callback(hash);
  }

  this.getHash=function(type){
    var hash=window.location.hash;
    hash=hash.replace('#','');
    hash=hash.replace(/ /,'%20');
    //hash=JSON.stringify(hash);
    //console.log(hash);
     var count=hash.split('@');

//console.log(count.length)
         var price=hash.match( /(price\:\d+(\_\d+)*)/i );
         if(count.length>1)
         {
        var attr=hash.match( /(attr\:([\w]*)+_([\w]*)+([@\w]*)+([\w]*)+_([\w]*)+)/g );
         }
         else
         {
          var attr=hash.match( /(attr\:([\w]*)+_([\w]*)+)/g );
         }
        //var attr=hash.match( /(attr\:([\w]*)+_([\w]*)+([@]*)+([\w]*)+_([\w]*)+)/g );
         var brand=hash.match( /(brand\:\d+(\_\d+)*)/i );
          var merchant=hash.match( /(merchant\:\d+(\_\d+)*)/i );
      
      console.log(attr);
       if(price !== null)
       {
           var hash=hash.replace(price[0],'');
           var lat=price[0].split(':');
            var pricehash='"'+lat[1]+'"';
           hash=hash+',price:"'+lat[1]+'"';
          
          // hash=hash.replace(/"/i,'');
           //hash=hash.replace(/"/i,'');
       // console.log(hash);
        // hash1=eval("var obj="+"{"+hash+"}"); 
       }
       if(brand !== null)
       {
           var hash=hash.replace(brand[0],'');
           var lat=brand[0].split(':');
            var brandhash='"'+lat[1]+'"';
           hash=hash+',brand:"'+lat[1]+'"';
          
          // hash=hash.replace(/"/i,'');
           //hash=hash.replace(/"/i,'');
       // console.log(hash);
        // hash1=eval("var obj="+"{"+hash+"}"); 
       }
       if(merchant !== null)
       {
           var hash=hash.replace(merchant[0],'');
           var lat=merchant[0].split(':');
            var merchanthash='"'+lat[1]+'"';
           hash=hash+',merchant:"'+lat[1]+'"';
          
          // hash=hash.replace(/"/i,'');
           //hash=hash.replace(/"/i,'');
       // console.log(hash);
        // hash1=eval("var obj="+"{"+hash+"}"); 
       }

      if(attr !== null)
       {
        //console.log(attr);
           var hash=hash.replace(attr[0],'');
           var lat=attr[0].split(':');
           //console.log(lat[1]);
            var attrhash='"'+lat[1]+'"';
           hash=hash+',attr:"'+lat[1]+'"';
           console.log(hash);
       }
       else
       {
        console.log(attr);
         var attr=hash.match( /(attr\:([\w]*)+_([\w]*)+)/g );
        // console.log(attr);
         if(attr !== null)
         {
          var hash=hash.replace(attr[0],'');
           var lat=attr[0].split(':');
         //  console.log(lat[1]);
            var attrhash='"'+lat[1]+'"';

           hash=hash+',attr:"'+lat[1]+'"';
         }
        /* else
         {
          var hash=hash.replace(attr,'');
           var lat=attr.split(':');
         //  console.log(lat[1]);
            var attrhash='"'+lat[1]+'"';

           hash=hash+',attr:"'+lat[1]+'"';
         }*/
          
       }

     console.log(hash);
           hash= hash.replace(/[,]+/g,',');
           hash= hash.replace(/^,/g,'');
           hash= hash.replace(/,$/g,'');
           hash= hash.replace(/[,]+/g,',');
          
         //   console.log(hash);
       hash1=eval("var obj="+"{"+hash+"}"); 
    
    if(type=='cat')
    {    
       obj=obj.cat;
    }  
    else if(type=='brand')
    {    
       obj=brandhash;
    } 
    else if(type=='merchant')
    {    
       obj=merchanthash;
    }  
     else if(type=='discount')
    {    
       obj=obj.discount;
    }  
     else if(type=='price')
    {   
       //obj=hash.match( /(price\:\d+(\_\d+)*)/i );
       obj=pricehash;
    }
    else if(type=='attr')
    {
     
          obj=attrhash;
     
    }
    else
    {
    if(this.type=="category")
      {
       // console.log(obj);
        if(obj==undefined)
        {
          obj={};
          obj.cat=this.search_id;
          this.selectedCat=1;
        }
        else
        {
          if(obj.cat==undefined)
          {
             obj.cat=this.search_id;
             this.selectedCat=1;
          }
        }
      }
    }
  // console.log(obj);
     return obj;
   
   }

  this.removeHash=function(type,callback,checkreplace){
   var hash=window.location.hash;
    hash=hash.replace('#','');
     var price=hash.match( /(price\:\d+(\_\d+)*)/i );
       var attr=hash.match( /(attr\:([\w]*)+_([\w]*)+([@\w]*)+([\w]*)+_([\w]*)+)/g );
         var brand=hash.match( /(brand\:\d+(\_\d+)*)/i );
         var merchant=hash.match( /(merchant\:\d+(\_\d+)*)/i );
      // console.log(brand);
        hashnew=hash;
       if(price !== null)
       {
         var hash=hash.replace(price[0],'');
          var hashnew=hashnew.replace(price[0],'');
         var lat=price[0].split(':');
        
          hashnew=hashnew+',price:"'+lat[1]+'"';
          hash=hash+',price:'+lat[1];
          //  hash=hash.replace(/"/g,'');
          // hash=hash.replace(/"/g,'');
          // console.log(hash);
          
       }
        if(brand !== null)
       {
           var hash=hash.replace(brand[0],'');
            var hashnew=hashnew.replace(brand[0],'');
           var lat=brand[0].split(':');
            var brandhash='"'+lat[1]+'"';

           hashnew=hashnew+',brand:"'+lat[1]+'"';
           hash=hash+',brand:'+lat[1];
          // hash=hash.replace(/"/i,'');
           //hash=hash.replace(/"/i,'');
       // console.log(hash);
        // hash1=eval("var obj="+"{"+hash+"}"); 
       }
        if(merchant !== null)
       {
           var hash=hash.replace(merchant[0],'');
            var hashnew=hashnew.replace(merchant[0],'');
           var lat=merchant[0].split(':');
            var merchanthash='"'+lat[1]+'"';

           hashnew=hashnew+',merchant:"'+lat[1]+'"';
           hash=hash+',merchant:'+lat[1];
          // hash=hash.replace(/"/i,'');
           //hash=hash.replace(/"/i,'');
       // console.log(hash);
        // hash1=eval("var obj="+"{"+hash+"}"); 
       }
       if(attr !== null)
       {
          var hash=hash.replace(attr[0],'');
          var hashnew=hashnew.replace(attr[0],'');
          var lat=attr[0].split(':');
          hashnew=hashnew+',attr:"'+lat[1]+'"';
          var attrhash='"'+lat[1]+'"';
          var attrhash1=lat[1];
          hash=hash+',attr:'+lat[1];
       }
       else
       {
         var attr=hash.match( /(attr\:([\w]*)+_([\w]*)+)/g );
         if(attr !== null)
         {
          var hash=hash.replace(attr[0],'');
           var hashnew=hashnew.replace(attr[0],'');
           var lat=attr[0].split(':');
          // console.log(lat[1]);
            hashnew=hashnew+',attr:"'+lat[1]+'"';
            var attrhash='"'+lat[1]+'"';
            var attrhash1=lat[1];
           hash=hash+',attr:'+lat[1];
         }
          
       }
//console.log(hash);
          
           hashnew= hashnew.replace(/[,]+/g,',');
           hashnew= hashnew.replace(/^,/,'');
           hashnew= hashnew.replace(/,$/,'');
           hashnew= hashnew.replace(/[,]+/g,',');
          
//console.log(hashnew);
          hash= hash.replace(/[,]+/g,',');
           hash= hash.replace(/^,/,'');
           hash= hash.replace(/,$/,'');
           hash= hash.replace(/[,]+/g,',');
          
           hash1=eval("var obj="+"{"+hashnew+"}"); 
     if(type=='cat')
    {    
       //obj.cat;
      hash= hash.replace('cat:'+obj.cat,"");
      
    }
    else  if(type=='brand')
    {
       hash= hash.replace('brand:'+obj.brand,"");
      if(checkreplace!=undefined)
      {
        // console.log(hash);
        var newBra=obj.brand.replace(checkreplace,"");
       
         newBra=this.removeLastChar(newBra,'_');
         newBra=this.removeFirstChar(newBra,'_');
         //newBra=$.trim(''newBra);
         newBra=newBra.replace(/[_]+/g,'_');
        if(newBra)
        {
          hash= hash+',brand:'+newBra;
        }
         
         //console.log(hash);
      }
     
     
      //console.log('brand:'+obj.brand);
      //console.log(hash);
    }
    else  if(type=='merchant')
    {
       hash= hash.replace('merchant:'+obj.merchant,"");
      if(checkreplace!=undefined)
      {
        // console.log(hash);
        var newBra=obj.merchant.replace(checkreplace,"");
       
         newBra=this.removeLastChar(newBra,'_');
         newBra=this.removeFirstChar(newBra,'_');
         //newBra=$.trim(''newBra);
         newBra=newBra.replace(/[_]+/g,'_');
        if(newBra)
        {
          hash= hash+',merchant:'+newBra;
        }
         
        // console.log(hash);
      }
     // hash= hash.replace('merchant:'+obj.merchant,"");
     // console.log('merchant:'+obj.brand);
      //console.log(hash);
    }
    else  if(type=='discount')
    {
      hash= hash.replace('discount:'+obj.discount,"");
     // console.log('merchant:'+obj.brand);
      //console.log(hash);
    }
     else if(type=='price')
    {   
           price=hash.match( /(price\:\d+(\_\d+)*)/i );
            if(price!=null)
            {
               hash=hash.replace(price[0],'');
            }
                 
          
    }
    else if(type=='attr')
    {
      //console.log(attrhash1);
      //console.log(checkreplace);
      if(checkreplace!=undefined)
      {
         hash= hash.replace('attr:'+attrhash1,'');
        // console.log(hash);
         retattr=attrhash.replace(checkreplace,'');
         retattr= retattr.replace(/^"/,'');
         retattr= retattr.replace(/"$/,'');
         retattr= retattr.replace(/^@/,'');
         retattr= retattr.replace(/@$/,'');
         retattr= retattr.replace(/[@]+/g,'@');

         if(retattr.length>2)
         {
            hash=hash+',attr:'+retattr;
         }  
      }
      else
      {
        hash= hash.replace('attr:'+attrhash1,'');
      }
    
     
    }
    hash= hash.replace(/[,]+/g,',');
     hash= hash.replace(/^,/,'');
     hash= hash.replace(/,$/,'');
     hash= hash.replace(/[,]+/g,',');
     window.location.hash = '#'+hash;
    // console.log(hash);
    if(hash=="")
    {
      var loc=window.location.href;
    //  console.log(loc);
      window.location.assign(loc.replace('#',''));
    }
    else
    {
      var loc=window.location.href;
      window.location.assign(loc);
    }
    if(typeof callback == "function") 
          callback(hash);
  }
/*-- End Hashing function --*/
 
  this.removeLastChar=function(str,chars){

      var lastChar = str.slice(-1);
      if(lastChar == chars) {
        str = str.slice(0, -1);
      }
      return str;
  };
   this.removeFirstChar=function(str,chars){

     if (str.indexOf('_')==0) {
             str = str.slice(1, str.length);
           console.log(chars);
        }
        return str;
  };
  this.init=function(){    
   // console.log(this.getHash());
    if(this.getHash()!="")
    {
      this.addHassesToMeltivews();
      this.setLoaderfilter();
      this.selectedCat=0;
     // this.setLoaderfilter();
      this.setCategory(search_id,this.type);
      this.getCateData();
      this.getCatBedcrom();
      this.getBrandData(); 
      this.getMerchantData(); 
      this.getAttrData();
      this.setDiscount(); 
      this.priceSet();
     
      this.getFilterResult(function(r){
        if(r==1)
        {
          filters.removeLoaderfilter(); 
          jQuery('html, body').animate({
                   scrollTop: $('.right-content').offset().top-170
                }, 1000);
          scrollerActive=1;
        }
      });
    
      
     
    }
    else
    {
      
        this.removeLoader();  
        scrollerActive=1;
    }
  }
  this.varInit=function(params){
   //console.log(params);
   for(var x in params)
   {
   
    switch(x){
      case'brand':
     // console.log(params[x]);
            if(Object.keys(params[x]).length>0)
            {
              filters.brand_filter={'brand':params[x]};
             
            }
        
      break;
      case'price':
    // console.log(params[x]);

            if(params[x]!=null)
            {
              var price=filters.getHash('price')
            // console.log(price);
             if(price!=undefined)
             {
              price=price.replace(/["]+/g,'').split('_');
              // console.log(price);
                var min=parseInt(price[0]);
                var max=parseInt(price[1]);
             }
             else
             {
               var min=params[x].min;
               var max=params[x].max;

             }
              $("#price_range").noUiSlider({
                  start: [ min, max],
                  range: {'min':[params[x].min],'max':[params[x].max]}
                },true);
             
            }
        
      break;
      case'category':   

        if(Object.keys(params[x]).length>0)   
        {
          filters.filter_category={'category':params[x]};        
        }
        
      break;
       case'merchant':   

        if(Object.keys(params[x]).length>0)   
        {
          filters.merchant_filter={'merchant':params[x]};        
        }
        
      break;
      case'discount':   

        if(Object.keys(params[x]).length>0)   
        {
          var distype=this.getHash('discount');
          if(params[x].count==0 && distype=="2")
          {
            this.removeHash('discount',function(){
                 //filters.getMerchantData();
             });
          }
          if(params[x].noncount==0 && distype=="1")
          {
            this.removeHash('discount',function(){
                 //filters.getMerchantData();
             });
          }
           $('#discount1').text('('+params[x].noncount+')');  
           $('#discount2').text('('+params[x].count+')');
        }
        
      break;
      case 'attr':
        if(Object.keys(params[x]).length>0)   
        {
          filters.attr_filter=params[x];        
        }
        else
        {
          //console.log(filters.getHash());
          if(!filters.getHash('attr') && filters.getHash()!="")
             filters.attr_filter=[];
        }
      break;
    }
      
   }
    //console.log(filters.filter_category);
     filters.loadTemplate(function(r){              
              if(r==1){
                // console.log(r);
                $('.stickyFilter>.filteroverly').fadeOut('slow');
              }
           });
  }
  this.getFilterResult=function(callback){
     this.setLoaderfilter();
     var hash=this.getHash('');
      //console.log();
     if(Object.keys(hash).length>0)
     {      
      if(this.selectedCat==0)
      {
      limit=12;
      nextpage=1;
      var url=this.baseUrl+this.lang+"/products/GetAutoLoadProduct/"+sear_type+"/"+limit+"/"+nextpage;
      var type="POST";
      var data={'params':hash,'slug':search_id,'type':this.type,'short':this.top_filter_type,'ftype':true};
      //console.log(sear_type);
      this.ajaxCall(url,type,data,function(res,err){
      console.log(res);
        var obj = JSON.parse(res);
        var str = '';
        var items=[];   
        //console.log(obj.params);
        //It shows set the filter according to the first choosen
        filters.varInit(obj.params);
        //console.log(listtype);
        if(listtype=="block")
        {
          var template = $('#ProductBlocktemplate1').html();
          allp=filters.getblocktemp(obj);
          var select=$('.p-list');
        }
        else
        {
          var template = $('#ProductBlocktemplate').html();
          allp=filters.getlisttemp(obj);
          var select=$('.listitempan');
        }
           
        var nodj=obj.allproduct
       //console.log(obj.allproduct);
          
          
           //console.log(allp);
           //console.log(obj);
            var html = Mustache.to_html(template, allp);
                  
            select.html(html);
            filters.removeLoaderfilter();
            total_count=0;
            if(filters.lang=="en")
            {
              $('.ProductCounter').text(Object.keys(nodj).length+' products found');
            }
            else
            {
              $('.ProductCounter').text(Object.keys(nodj).length+' منتوجات');
            }
            
            //nextpage=nextpage+1;
          
           if(total_count<(nextpage*limit))
            {
              // console.log(total_count);
              $('.loadingmore').fadeOut();
            }else
            {
              //restdata=obj.rproduct;
            }
             if(typeof callback == "function") 
                 callback(1);
       })
    }
    else
    {
       this.removeLoader();  
      filters.removeLoaderfilter(); 
    }
  }
  }
  this.getblocktemp=function(obj){
    var nodj=obj.allproduct
    var ii=0;
          var j=0;
          var allp=[];
           allp[j]=[];
          for(var x in  nodj)
          {             
            if(ii<4)
            {
              var rat= nodj[x].Product.reate_count
               obj.allproduct[x].Product.rating=[]
                 for(var i=0;i<5;i++){             
                  obj.allproduct[x].Product.rating[i]={};
                  //console.log(rat);
                    if(i<rat)
                    {
                         obj.allproduct[x].Product.rating[i]['rate']=true;
                    }
                    else
                    {
                        obj.allproduct[x].Product.rating[i]['rate']=false;
                    }
                    if(obj.allproduct[x].Product.discount==0)
                    {
                      obj.allproduct[x].Product.discount="false";
                    }
                 }
                 allp[j].push(obj.allproduct[x]);
                 ii++;
             }
             if(ii==4)
             {
              ii=0;
              j++;
              allp[j]=[];
             }
          }
           //
           allp={'allp':allp};
           //console.log(allp);
           return allp;
  }
  this.getlisttemp=function(obj){
    var nodj=obj.allproduct
     for(var x in  nodj)
          {
              var rat= nodj[x].Product.reate_count;
               obj.allproduct[x].Product.rating=[];
               obj.allproduct[x].Product.merchantCountlesthen=false;
              // console.log(obj.allproduct[x].Product.merchant_count);
               if(obj.allproduct[x].Product.merchant_count>1)
               {
                 obj.allproduct[x].Product.merchantCountlesthen=true;
               }
             for(var i=0;i<5;i++){
             
              obj.allproduct[x].Product.rating[i]={};
              //console.log(rat);
                if(i<rat)
                {
                     obj.allproduct[x].Product.rating[i]['rate']=true;
                }
                else
                {
                    obj.allproduct[x].Product.rating[i]['rate']=false;
                }
                if(obj.allproduct[x].Product.discount==0)
                {
                  obj.allproduct[x].Product.discount="false";
                }
             }
          }
          return obj;
  }

  /*-- Adition nal inner function--*/
  this.setLoader=function(){
    $('.stickyFilter>.filteroverly').show();
  }
  this.removeLoader=function(){

    $('.stickyFilter>.filteroverly').fadeOut('slow');
          
  }
  this.setLoaderfilter=function(){
    $('.overly_main_section .filteroverly').show();
  }
  this.removeLoaderfilter=function(){
    $('.overly_main_section .filteroverly').fadeOut('slow');
  }
  this.clear=function(types){
  //  console.log(filters.getHash());
    if(Object.keys(filters.getHash()).length!=0)
      this.removeHash(types);
  }
  this.clearAttr=function(slugs){
 if(Object.keys(filters.getHash()).length!=0)
 {
      var attr=filters.getHash('attr');

      attr=attr.replace(/["]+/g,'').split('@');     
      var attr1=attr;
      for(var x = attr.length; x--;){
        var data=attr[x].split('_');       
        if(data[0]==slugs)
        {
          attr.splice(x,1);
        }
        //console.log(attr);
      }
      attr=attr.join('@');
 
      if(attr=="")
      {
        filters.removeHash('attr');        
      }
      else
      {
        this.addHash(attr,function(){                
           filters.getAttrData();
        },'attr','clear');
      }
    }
  }
  this.setCategory=function(id,type){
    //console.log(id);
    //console.log(type);
    switch(type){
      case 'category':
      var cat=this.getHash('cat')
      //console.log(cat);
      //console.log(id);
      if(cat==undefined)
      {
        //hash='cat:'+id;
         //this.addHash(hash,function(){
             filters.getCateData(id);
         //});
      }
         
      break;
       case 'brand':
         hash='brand:'+id;
         this.addHash(hash,function(){
             filters.getCateData();
         });
      break;
    }
   
  }
  this.priceSet=function(){
    var pricecomp=this.getHash('price');
    //console.log(pricecomp);
    if(pricecomp!=undefined)
    {
      //var p=pricecomp[0].split(':');
      pricecomp=pricecomp.replace(/["]+/g,'');
      pricecomp=pricecomp.replace(/["]+/g,'');
      var pp=pricecomp.split('_');
      $('#qa-catalogPrice').val(pp[0].replace(/"/,"")).change();
      $('#qa-catalogPriceTo').val(pp[1].replace(/"/,"")).change();

      $("#price_range").noUiSlider({
                  start: [ pp[0], pp[1]],
                },true);
    }
    

  }
    this.setDiscount=function(){
      var disid=this.getHash('discount');
      if(disid==undefined)
      {
        $('.non_disc_check').removeAttr('checked').attr('data-select','0');
      }
      else
      {
        $('#non_disc'+disid).attr('checked','checked').attr('data-select','1');
      }
      
    }
    this.getParentCatId=function(){
      var arr=[];
      for(var x in this.filter_category.category)
      {
         arr.push(this.filter_category.category[x]['id']);
      }
      return arr;
    }
    this.getBrandIds=function(){
      var arr=[];
      for(var x in this.brand_filter.brand)
      {
         arr.push(this.brand_filter.brand[x]['id']);
      }
      return arr;
    }
    this.getMerchantIds=function(){
      
       var arr=[];
      for(var x in this.merchant_filter.merchant)
      {
         arr.push(this.merchant_filter.merchant[x]['id']);
      }
      return arr;
    }
  /*----End Aditional inner function --*/
  /*-- Get filter Tamplates--*/
  this.getCateData=function(id){
    this.setLoader();
    var catid=this.getHash('cat');
    if(catid==undefined)
    {
      catid=id;
    }

      //console.log(catid);
    if(catid!=undefined)
    {
    var url=this.baseUrl+this.lang+"/products/getfilterCategory";
    var type="POST";
    if(this.type=="category" || this.type=="brand")
    {
       var data={'catid':catid,'slug':slug,'select_id':search_id,'type':this.type,'parents':this.getParentCatId(),'sort':this.top_filter_type};  
    }else
    {
       var data={'catid':catid,'slug':slug,'type':this.type,'parents':this.getParentCatId(),'sort':this.top_filter_type};  
    } 
    this.ajaxCall(url,type,data,function(res,err){
         //console.log(res);
           // var fil=new filter(res);//
            filters.filter_category=JSON.parse(res);
            //filters.init();
            filters.loadTemplate(function(r){              
              if(r==1){

              }
           });
            //console.log(err);
         })
    }
  }
   this.getCatBedcrom=function(){
     var catid=this.getHash('cat');
      if(catid!=undefined)
    {
    var url=this.baseUrl+this.lang+"/products/getBreadcroms/"+catid;
    var type="POST";
   if(this.type=="category" || this.type=="brand")
    {
       var data={'catid':catid,'slug':slug,'select_id':search_id,'type':this.type};  
    }else
    {
       var data={'catid':catid,'slug':slug,'type':this.type};  
    } 
    this.ajaxCall(url,type,data,function(res,err){
        // console.log(res);
           // var fil=new filter(res);//
           
            filters.bedcrom=JSON.parse(res);
            var template1 = $('#breadcron_change').html();   
            var html1 = Mustache.to_html(template1,filters.bedcrom);
            //console.log(html1);    
            $('.breadcrumbs_pan').html(html1); 
            //console.log( );
            var last=filters.bedcrom[filters.bedcrom.length-1];
          // console.log(last);
            $('.category_title_in_plist').text(last.Product_category.title.replace(/[-]+/g,' '));
            $('.search-bar-text').val(last.Product_category.title.replace(/[-]+/g,' '));
           });
            //console.log(err);
         
    }
  }

  this.getBrandData=function(){
      this.setLoader();
    var brandid=this.getHash('brand');
   // console.log(brandid);
    if(brandid!=undefined)
    {
      brandid=brandid.replace(/["]+/,"");
      brandid=brandid.replace(/["]+/,"");
      brandid=brandid.split('_');
      //brandid=JSON.parse(brandid);
       //brandid=JSON.stringify(brandid);
      //console.log(brandid);
    var hash=this.getHash('');
    var url=this.baseUrl+this.lang+"/products/getfilterBrand";
    var type="POST";
    if(this.type=="category" || this.type=="brand")
    {
       var data={'brandid':brandid,'params':hash,'slug':search_id,'type':this.type,'parents':this.getBrandIds(),'short':this.top_filter_type};  
    }else
    {
       var data={'brandid':brandid,'params':hash,'slug':search_id,'type':this.type,'parents':this.getBrandIds(),'short':this.top_filter_type};  
    } 
    this.ajaxCall(url,type,data,function(res,err){
         //  console.log(res);
            // var fil=new filter(res);
            filters.brand_filter=JSON.parse(res);
            //console.log(filters.brand_filter.brand);
            for(var x in brandid)
            {
              var i=0;
               for(var y in filters.brand_filter.brand)
               {

                if(filters.brand_filter.brand[y].id==brandid[x])
                {
                  i++;
                }
                  
               }
               if(i<=0)
               {
                if(filters.type!='brand')
                {
                   filters.removeHash('brand',function(){
                     filters.removeHash('merchant');
                     filters.removeHash('discount');
                     //filters.removeHash('price');
                     filters.removeHash('attr');
                     filters.getBrandData();
                    },brandid[x]);
                   }
                }
            }
           
             filters.loadTemplate(function(r){    
             // console.log(r);          
              if(r==1){
              
                //filters.removeLoader();
              }
           });
            //console.log(err);
         })
    }
  }
  this.getMerchantData=function(){
     this.setLoader();
    var merchant_id=this.getHash('merchant');
    // console.log(brandid);
    if(merchant_id!=undefined)
    {

      merchant_id=merchant_id.replace(/["]+/,"");
      merchant_id=merchant_id.replace(/["]+/,"");
      merchant_id=merchant_id.split('_');
    var url=this.baseUrl+this.lang+"/products/getfilterMerchant";
    var type="POST";
    if(this.type=="category" || this.type=="brand")
    {
       var data={'merchant_id':merchant_id,'slug':slug,'type':this.type,'parents':this.getMerchantIds()};  
    }else
    {
       var data={'merchant_id':merchant_id,'slug':slug,'type':this.type,'parents':this.getMerchantIds()};  
    } 
    this.ajaxCall(url,type,data,function(res,err){
           // console.log(res);
            // var fil=new filter(res);
            filters.merchant_filter=JSON.parse(res);
            filters.loadTemplate(function(r){              
              if(r==1){
                // console.log(r);
                 //filters.removeLoader();
              }
           });
            //console.log(err);
         })
    }
  }

  this.getAttrData=function(){
     this.setLoader();
    var attr=this.getHash('attr');
     //console.log(attr);
    if(attr!=undefined)
    {
/*var url=this.baseUrl+this.lang+"/products/getAttrsValus";
       var type="POST";    
       var data={'filter_data':filters.attr_filter,'filter':attr};  
    
    this.ajaxCall(url,type,data,function(res,err){
           // console.log(res);
            // var fil=new filter(res);
            filters.attr_filter=JSON.parse(res);
            filters.loadTemplate(function(r){              
              if(r==1){
                //console.log(r);
                 filters.removeLoader();
              }
           });
            //console.log(err);
         })*/
           // console.log(attr);
           // console.log(filters.attr_filter);
          var atsplit=attr.split('@');
            for (var x in filters.attr_filter)
                  {
                    for(var xx in filters.attr_filter[x]['children'])
                      {
                        filters.attr_filter[x]['children'][xx]['checked']=false; 
                      }
                  }
            for(var i in atsplit)
            {
              atsplit[i]=atsplit[i].replace(/["]+/g,'');
              atsplit[i]=atsplit[i].replace(/["]+/g,'');
              var atdata=atsplit[i].split('_');
             //console.log(atdata);
                for (var x in filters.attr_filter)
                  {
                   
                   
                   if(filters.attr_filter[x]['title']===atdata[0])
                   {
                    //console.log(atdata[0]);
                      for(var xx in filters.attr_filter[x]['children'])
                      {
                        
                         //console.log(atdata[1]);
                        // 
                        if(filters.attr_filter[x]['children'][xx]['slug']===atdata[1])
                        {
                         // console.log(atdata[1]);
                            filters.attr_filter[x]['children'][xx]['checked']=true;
                        }
                     
                      }
                   }
               
                  }
            }
         // filters.attr_filter={'attr':filters.attr_filter}
           // console.log(filters.attr_filter);
            // var fil=new filter(res);
           // filters.attr_filter=JSON.parse(res);
            filters.loadTemplate(function(r){              
             if(r==1){
                // console.log(r);
                // console.log(filters.attr_filter);
                filters.removeLoader();
             }
             });
           
        
   }
  }
  /*-- End Get filter Tamplates--*/
 /*-- Filter clicks --*/
   this.check_category=function(id,cthis,checked){
     this.setLoader();
      $('.category_check').removeAttr('checked')
      if(checked==false)
      {
           $(cthis).attr('checked','checked')
           var hash='cat:'+id;       
           this.addRootHash(hash,function(){
             filters.removeHash('attr');
               filters.getCateData();
           });
           
      }
      else
      {
          this.removeHash('cat',function(){
               filters.getCateData();
               filters.removeHash('price');
           });
      }
    
    }  
 this.check_brand=function(id,cthis,checked){
    this.setLoader();
     //$('.brand_check').removeAttr('checked')
      if(checked==false)
      {
           $(cthis).attr('checked','checked');
                var hash=id; 
              
               this.addHash(hash,function(){
                   filters.removeHash('merchant');
                   filters.removeHash('discount');
                   //filters.removeHash('price');
                   filters.removeHash('attr');
                   filters.getBrandData();
               },'brand');   
      }
      else
      {
        
          this.removeHash('brand',function(){
                filters.removeHash('merchant');
               filters.removeHash('discount');
               //filters.removeHash('price');
               filters.removeHash('attr');
               filters.getBrandData();
           },id);
      }
    
    };
  this.check_merchant=function(id,cthis,checked){
     this.setLoader();
       //$('.merchant_check').removeAttr('checked')
        if(checked==false)
        {
             $(cthis).attr('checked','checked');
            // var hash='merchant:'+id;   
           var hash=id; 
             this.addHash(hash,function(){
                //filters.removeHash('price');
                filters.removeHash('discount');  
                 filters.removeHash('attr');  
                 filters.getMerchantData();
             },'merchant');
        }
        else
        {
            this.removeHash('merchant',function(){
                 filters.getMerchantData();
             },id);
        }
      
      };
      this.check_discount=function(id,cthis,checked){
         this.setLoader();
          //console.log($(cthis).attr('data-select'));
          if($(cthis).attr('data-select')==0)
          {
            $('.non_disc_check').removeAttr('checked').attr('data-select','0') ;     
             $(cthis).attr('checked','checked');
             $(cthis).attr('data-select','1')
             var hash='discount:'+id;       
             this.addHash(hash,function(){
                // filters.removeHash('price');
                 filters.removeHash('attr');
                 //filters.getDData();
             });
          }
          else
          {
            $(cthis).attr('data-select','0')
             this.removeHash('discount',function(){
                 //filters.getMerchantData();
             });
          }
       };
       this.check_price=function(id,cthis,checked){
         //this.setLoader();
          //console.log($(cthis).attr('data-select'));
         var pricefrom= $('#qa-catalogPrice').val();
         var priceto= $('#qa-catalogPriceTo').val();
         pricefrom=pricefrom.replace(',','');
         priceto=priceto.replace(',','');
         //console.log(pricefrom);
         //console.log(priceto);
         var hash='price:"'+Math.round(pricefrom)+'_'+Math.round(priceto)+'"';
         //console.log(hash);
         this.addHash(hash,function(){
           filters.removeHash('attr');
                 //filters.getDData();
             });
       };
       this.check_attr=function(id,slug,cthis,checked){
          //this.setLoader();
          if(checked==false)
        {
             $(cthis).attr('checked','checked');
             var hash='"'+slug+'_'+id+'"';              
             this.addHash(hash,function(){                
                 filters.getAttrData();
             },'attr');
        }
        else
        {
           var hash=slug+'_'+id;
            this.removeHash('attr',function(){
                 filters.getAttrData();
             },hash);
        }
       }
/*-- End Filter clicks --*/
/*----- Template Section ------ */
this.categoryTemplate=function(){
    var template1 = $('#category_filter').html();
    var recorsive = $('#childcat').html();    
    var html1 = Mustache.to_html(template1,this.filter_category,{'childcat':recorsive});
    //console.log(this.filter_category);
    $('#filter_category').html(html1);   
}
this.brandTemplate=function(){
    //console.log(this.brand_filter);
    var template1 = $('#brand_filter').html();   
    var html1 = Mustache.to_html(template1,this.brand_filter);
    console.log(this.brand_filter);
    console.log(html1);    
    $('.brand_filter').html(html1);   
}
this.merchantTemplate=function(){
  //console.log(this.brand_filter);
    var template1 = $('#merchant_filter').html();   
    var html1 = Mustache.to_html(template1,this.merchant_filter);
   // console.log(html1);    
    $('.merchant_filter').html(html1);   
}
this.attrTemplate=function(){
   var template1 = $('#attr_filter').html();   
    var html1 = Mustache.to_html(template1,{'attr':this.attr_filter});
   // console.log(html1);    
    $('.attr_filter').html(html1);   
}
/*----- End Template Section ------ */
// window.onload call
 this.loadTemplate=function(callback){     
     $('#filter-nav').show(); 
     this.categoryTemplate();
     this.brandTemplate(); 
     this.merchantTemplate();
     this.attrTemplate();
  if(typeof callback == "function") 
  {
    callback(1); 
    $('.nano').nanoScroller({
   preventPageScrolling: true
 });
  }
            
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

 this.in_array=function(needle, haystack, argStrict) {
  //  discuss at: http://phpjs.org/functions/in_array/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: vlado houba
  // improved by: Jonas Sciangula Street (Joni2Back)
  //    input by: Billy
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
  //   returns 1: true
  //   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
  //   returns 2: false
  //   example 3: in_array(1, ['1', '2', '3']);
  //   example 3: in_array(1, ['1', '2', '3'], false);
  //   returns 3: true
  //   returns 3: true
  //   example 4: in_array(1, ['1', '2', '3'], true);
  //   returns 4: false

  var key = '',
    strict = !! argStrict;

  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
  //in just one for, in order to improve the performance 
  //deciding wich type of comparation will do before walk array
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}
}

