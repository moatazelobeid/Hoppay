<?php ini_set('max_execution_time', 600);?>
<script>
    /*$( document ).ready(function(){
        $('.storesSpotBox li.has_child').click(function(){
        
            var child=$(this).children( ".hidepanel" )	
            console.log(child);								
            child.slideToggle('down');
        })
    })*/
	
	$(document).ready(function(){
       $('.storesSpotBox li.has_child').click(function(event){
         event.stopPropagation();
         $(this).children("ul").slideToggle(function(){
          createlist();
         });
         
       });
       var item=4;
       function changeHeight(){
          var data=[];
          var length1=$('.bannerBox').length;
          console.log(length1);
             for(var i=0;i<item;i++ ){
                var k=i;
                data[i]=0;
              for(var j=0;j<length1;j++){
                
               
                if(k<length1){
                   console.log(k);
                   console.log($('#item'+k).height());
                   data[i]=parseInt(data[i]+parseInt($('#item'+k).height())+20);
                   console.log(data[i]);
                   k=item+k 
                 }
                 else
                 {
                  break;
                 }
              }  
             }
          
         //data=0;
         // $('.bannerBox').each(function(k,v){
              //data=data+$('#item'+k).height()

          //});
           
       var maxdata= Math.max.apply(Math, data);
         console.log(maxdata);
          $('.storesSpotBoxTop').css('height',maxdata+'px');
       }
       function createlist(){
        //alert('hjdhd');
         $('.bannerBox').each(function(k,v){
              $(this).attr('id','item'+k);
             // console.log(k);
              if(k!=0)
              {
                
              var position=$('#item'+(k-1)).position();
               var width=$('#item'+(k-1)).width();
             
              //console.log(position);
              if(k<item)
              {
              $('#item'+k).css({'left':(position.left+width+20)+'px',});
              }
              else
              {
                // console.log('#item'+k);
                 //console.log('#item'+(k-item));
                 var position1=$('#item'+(k-item)).position();
                // console.log(position1)
                 var height=$('#item'+(k-item)).height();
                // console.log(height)
                // console.log(position1.top+height+20);
                $('#item'+k).css({'left':(position.left+width+20)+'px','top':(position1.top+height+20)+'px' });
              }
              }
           })
         changeHeight();
       }
       $('.bannerBox').resize(function(){
        alert('hii');
         createlist();
       })
   createlist();
});
    
</script>
<div class="storesSpotBoxTop">
						<?php 
						//echo '<pre>'; print_r($catlist); echo '<pre>';
						if(!empty($catlist))
						{
							$i = 0;
							// $this->Product_category = ClassRegistry::init('Product_category');
							
							foreach($catlist as $product_category)
							{
								$i++;
								if($i%4 == 0)
								{
									$class = '';	
								}
								else
								{
									$class = 'bannerBoxmargin';	
								}
								$catname = stripslashes($product_category['Product_category_lang'][0]['category_name']);
								$catslug = $product_category['Product_category']['slug'];
								
								if(!empty($product_category['children']))
								{?>
                                
                                <div id="Cameras_Store2" class="bannerBox storesSpotBox storesSpot2 <?php echo $class;?>">
                                    <div class="storesSpotTitle">
                                        <h5>
                                            <?php
                                          //  echo strlen($catname);
											if(strlen($catname) > 10) 
											{
												$dcatname = substr($catname,0,10).'..';
											}
											else
											{
												$dcatname = $catname;
											}

          //  $allChildren = $this->Product_Category->children($product_category['Product_category']['id']); 
	            //  $totchld=Hash::nest($catlist, array('root' => $product_category['Product_category']['id']));
									//print_r($allChildren);
												
                      ?>
			                       <a href="<?=$this->webroot?>products/category-<?=$catslug?>" >
			                            <?=$dcatname?> ( <?php 
                                 echo $this->Template->GetProductCountBycategory($product_category['Product_category']['id']);
                          ?>)
			                       </a>
                                                           <?php
											//echo $this->Html->link($dcatname,array('controller' => 'homes','action' => 'productlist','type'=>$catslug,'full_base' => true));?>
                                            <span class="ctgicon">
												<?php  //echo $this->Html->image('tv.png', array('alt' => ''));?>
                                                <?php 
												if(!empty($product_category['Product_category']['image_url']))
												{
													echo $this->Html->image('../'.$product_category['Product_category']['image_url'], array('alt' => ''));
												}
												else
												{
													echo $this->Html->image('no-image.png', array('alt' => ''));	
												}?>
                                            </span>
                                        </h5>
                                        <span class="dot31"></span>
                                    </div>
                                    <?php if(!empty($product_category['children']))
									{?>
                                        <ul class="storesSpotLink">
                                        	<?php echo $this->Template->getChidren($product_category['children']);?>
                                        </ul>
                                    <?php }?>
                                    <div class="shadow_plate"></div>
                                </div>
                                
						<?php } }
						}?>
					</div>

          <h1>Compare Prices by Category</h1>
          <p>
            Menacompare help of an approved partner, you can manage your products, making it easier to drive traffic and sales to your online store.
          </p>