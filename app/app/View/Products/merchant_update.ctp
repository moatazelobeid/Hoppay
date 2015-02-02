
 <?php $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:'1'; ?>
 <script>
 $(function(){
    
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


 })

 function validater(){
   var images= $('#mySingleField').val();
   var category= $('#autocomplete2-value').val();
   if(images=="")
   {
    $('#shoeimg_error').css('display','block !important').text('This field should not be blank, Put your product image link here.');
     $('#shoeimg_error').show();
    return false;
   }
   else
   {
        return true;
   }
   if(category=="")
   {
    $('#shoeimg_error1').css('display','block !important').text('You have to select a category from drop down');
     $('#shoeimg_error').show();
    return false;
   }
 }
    
    var sampleTags = <?=$prod_data['Product']['image_url']?>
    
 </script>
 <style type="text/css">
.validate label.error {
    color: #f00;
    float: right;
}
#shoeimg_error{
     display: none;
     color: #f00;
     width: 363px;
     float: left;
     margin-left: 150px;
}
.details_block{
    display: inline-table;
}
.details_pare{
    width: 589px;
    display: block;
    background: #fafafa;
    padding: 10px;
    position: relative;
    margin-bottom: 5px;
}
.details_pare input{
    width:200px !important;
    display: block
}
.details_pare textarea{
    width:483px !important;
    display: block;
    height:50px !important;
    margin-top:5px !important;
}
.details_pare .devider{
    padding:0px 5px;
    font-weight: bold;
    color:#666;
    font-size: 14px;
}
.add_more_link{
    float: right;
margin-right: 19px;
}
.details_pare:hover {
    background: #f6f6f6;
}
.details_pare span{
            display: none;
        }
        .details_pare:hover span {
            font-weight: bold;
font-family: Arial, sans-serif;
color: #fff;
font-size: 14px;
background-color: rgba(0,0,0,0.8);
width: 20px;

border-radius: 100%;
position: absolute;
display: block;

box-shadow: 0px 0px 1px #666;
right: -9px;
top: -9px;
padding: 4px 3px;
cursor: pointer;
text-align: center;

         }

.details_pare label.error{
   float: none;
   clear: both;
}


 </style>
<script type="text/javascript">

    $(function(){
    //$(".tab_content").hide(); //Hide all content
    
    var i=1;
    $('.add_more_link').click(function(){
      $('.details_block').append('<div class="details_pare" id="details_pare'+i+'"><span class="close_icon '+i+'">X</span><input type="text" placeholder="Enter title" required  id="product_key'+i+'" name="product_details[key][]" value=""><textarea name="product_details[value][]" id="product_value'+i+'" placeholder="Enter details" required ></textarea></div>');
        i++;
        $('.close_icon').click(function(){
          var p=$(this).attr('class');
          var arr=p.split(" ");
          var id='#details_pare'+arr[1];
          $(id).remove();
          i--;
        })
        $('.validate').validate();
    })
$('.close_icon').click(function(){
          var p=$(this).attr('class');
          var arr=p.split(" ");
          var id='#details_pare'+arr[1];
          $(id).remove();
          i--;
        })

    })

</script>
				<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg"  style="width: 776px;margin: 0px 0px 0px 25px;">
						<h1 class="font25"><?=$text_data['title']?> "<?=isset($prod_data['Product_lang']['title'])?$prod_data['Product_lang']['title']:""?>"</h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'dashbord'))?>"> Home </a> 
							<span class="breeadset">›</span>
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/my-products"> My Products</a> 
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
						
						<div class="prof_data1">
                            <?=$this->Session->flash('bad')?> 
                         <?=$this->Session->flash('msg')?>
                       
                           

                         
					 <form>
           <table style="margin-bottom: 11px;">
                  <tr>
                   <td style="width:146px;">
                   <label style="font-size:12px;">Choose Language
                   </label>
                    </td>
                    <td>
                          
                                       
                            
                                          <select name="lang_id" required class="selectbox anpHintable" onchange="this.form.submit();" style="width: 357px;">
                                            <?php 
                                            foreach($lang as $val){ ?>
                                            <option value="<?=$val['Language']['id']?>"
                                             <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?> ><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>) </option>
                                           <?php } 
                                            ?>
                                          </select>
                                      
                  </tr>
                </table>
              </form>
							<?php //print_r(//$prod_data[0]); ?>
                           <form class="dashboardpanform validate" action="" method="POST" onsubmit="return validater()">
                           		<fieldset>
                                    <label class="loginaddtion">Title<span class="errorfield" style="display:none;"></span></label>
                                    <input size="30" type="text" name="title" required id="title" class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product_lang']['title'])?$prod_data['Product_lang']['title']:""?>" data-hint-num="0">
                                </fieldset>
                                <input type="hidden" name="product_lang_id" value="<?=isset($prod_data['Product_lang']['id'])?$prod_data['Product_lang']['id']:""?>">
                                <fieldset>
                                    <label class="loginaddtion">Description<span class="errorfield" style="display:none;">Enter Password</span></label>
                                   <style>
			                      iframe{
			                        border-bottom: 1px solid #000 !important;
			                        border-radius:5px;
			                        margin-bottom: 5px !important;
			                        margin-top: 5px !important;
			                      }
			                    </style>
			                    <?php
			                    echo $this->Fck->fckeditor(array('description'), $this->html->base, isset($prod_data['Product_lang']['description'])?$prod_data['Product_lang']['description']:""); 
			                   
			                    ?>
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">More Details</label>
                                  <div class="details_block">
                                         <?php $product_details=htmlspecialchars_decode($prod_data['Product_lang']['product_details']);
                                            $product_details_arr=json_decode($product_details);
                                        if(!empty($product_details_arr)){
                                            $i=0;
                                            foreach ($product_details_arr as $key => $value) {
                                              
                                            
                                          ?>
                                          
                                             <div class="details_pare" id="details_pares<?=$i?>">
                                                <span class="close_icon s<?=$i?>">X</span>
                                                <input type="text" placeholder="Enter title" required name="product_details[key][]" value="<?=$key?>">
                                                <textarea name="product_details[value][]"  required placeholder="Enter details"><?=$value?></textarea>
                                            </div>
                                          
                                        <?php $i++; }}
                                        else
                                        { ?>
                                       
                                            <div class="details_pare">
                                               <!-- <span>X</span> -->
                                                <input type="text" placeholder="Enter title" required name="product_details[key][]" value="">
                                                <textarea name="product_details[value][]"  required placeholder="Enter details"></textarea>
                                            </div>
                                       
                                        
                                       <?php }
                                        ?>
                                    </div>
                                        <a href="javascript:void(0)" class="add_more_link">Add details</a>
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Category:</label>
                                    <input size="30" type="text" name="category" required="" id="autocomplete" value="<?=isset($prod_data['Product']['category'])?$prod_data['Product']['category']:""?>"  class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                    <input id="autocomplete2-value" value="<?=isset($prod_data['Product']['category_id'])?$prod_data['Product']['category_id']:""?>" type="hidden" name="category_id">
                                    <span class="loading"></span>
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Brand:</label>
                                    <select name="brand" style="width:376px" required>
                                    	<option value="">--Choose Brand--</option>.
                                    	<?php 
                                    		foreach ($brand as $key => $value) { ?>
                              <option value="<?=$value['Product_brand']['id']?>" <?=$this->Template->Select($value['Product_brand']['id'],isset($prod_data['Product']['brand'])?$prod_data['Product']['brand']:"")?>><?=$value['Product_brand_lang'][0]['brand_title']?></option>
                                    	<?php	}

                                    	?>
                                    </select>
                                    
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Price:</label>
                                    <input size="30" type="text" name="price" required="" id="price"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['price'])?$prod_data['Product']['price']:""?>"  data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Price Type:</label>
                                    <select name="price_type" required style="width:375px">
                                        <option <?=$this->Template->Select('usd',isset($prod_data['Product']['price_type'])?$prod_data['Product']['price_type']:"")?> value="usd">USD</option>
                                        <option <?=$this->Template->Select('ard',isset($prod_data['Product']['price_type'])?$prod_data['Product']['price_type']:"")?> value="ard">AED</option>
                                    </select>
                                    <!--<input size="30" type="text" name="price_type" required="" id="price_type" value="<-?=sset($prod_data['Product']['price_type'])?$prod_data['Product']['price_type']:""?>"  class="form-text hasPlaceholder anpHintable" data-hint-num="0">-->
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Product URL:</label>
                                    <input size="30" type="url" name="product_url" required="" id="product_url" value="<?=isset($prod_data['Product']['product_url'])?$prod_data['Product']['product_url']:""?>"  class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion"></label>
                                <div class="showImg_area">
                                    <?php
                               $data=json_decode(stripcslashes($prod_data['Product']['image_url']));
                               
                              // echo(stripcslashes($prod_data['Product']['image_url']));
                                    foreach ($data as $key => $value) { ?>
                                    <div class="prod_image <?=$key?>" >
                                        <span>x</span>
                                        <img src="<?=$value?>" width="100px">
                                    </div>
                                    <?php } 
                                    	$data=implode(' , ', $data);
                                    	//echo $data;
                                    ?>
                                </div>
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Images</label>
                                    <input type="hidden" name="tags" id="mySingleField" value="<?=$data?>">
                                    <ul id="singleFieldTags" class="tagit ui-widget ui-widget-content ui-corner-all" style="margin-left: 150px;margin-top: 0px;"></ul>
                                    <label for="singleFieldTags" id="shoeimg_error" style="" class="error1">This is not a valide image url</label>
                                </fieldset>
                                 <fieldset>
                                    <label class="loginaddtion">Quantity:</label>
                                    <input size="30" type="digits" name="quantity" required id="quantity" value="<?=isset($prod_data['Product']['quantity'])?$prod_data['Product']['quantity']:""?>"   class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Condition:</label>
                                    <input size="30" type="text" name="condition" required="" id="condition" value="<?=isset($prod_data['Product']['condition'])?$prod_data['Product']['condition']:""?>"   class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">isbn:</label>
                                    <input size="30" type="text" name="isbn"  id="isbn"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['isbn'])?$prod_data['Product']['isbn']:""?>" data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">mpn:</label>
                                    <input size="30" type="text" name="mpn"  id="mpn"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['mpn'])?$prod_data['Product']['mpn']:""?>"  data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">upc:</label>
                                    <input size="30" type="text" name="upc"  id="upc"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['upc'])?$prod_data['Product']['upc']:""?>"  data-hint-num="0">
                                </fieldset>
                                 <fieldset>
                                    <label class="loginaddtion">Color:</label>
                                    <input size="30" type="text" name="color" required  id="color"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['color'])?$prod_data['Product']['color']:""?>"  data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">weight:</label>
                                    <input size="30" type="text" name="weight"  id="weight"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['weight'])?$prod_data['Product']['weight']:""?>"  data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">height:</label>
                                    <input size="30" type="text" name="height"  id="height"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['height'])?$prod_data['Product']['height']:""?>"  data-hint-num="0">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">width:</label>
                                    <input size="30" type="text" name="width"  id="width"  class="form-text hasPlaceholder anpHintable" value="<?=isset($prod_data['Product']['width'])?$prod_data['Product']['width']:""?>"  data-hint-num="0">
                                </fieldset>
                                <?php 
                               $seo_details=isset($prod_data['Product_lang']['seo_details'])?$prod_data['Product_lang']['seo_details']:"";
                                  if($seo_details!="")
                                  {
                                    $seo= json_decode(stripslashes(htmlspecialchars_decode($seo_details)),true);
                                  }
                                ?>
                                <fieldset>
                                    <label class="loginaddtion">Meta Keyword:</label>
                                    <textarea name="seo_details[keyword]"><?=isset($seo['keyword'])?$seo['keyword']:""?></textarea>     
                                </fieldset>
                                 <fieldset>
                                    <label class="loginaddtion">Meta Description:</label>
                                    <textarea name="seo_details[description]"><?=isset($seo['description'])?$seo['description']:""?></textarea>
                                </fieldset>
							                   <fieldset>
                                     <label class="loginaddtion">Status</label>
                                     <select name="status" requred>
                                      <option value="1" <?php if(isset($prod_data['Product']['status']) && $prod_data['Product']['status']==1){ echo "selected='selected'";} ?>>Active</option>
                                      <option value="0" <?php if(isset($prod_data['Product']['status']) && $prod_data['Product']['status']==0){ echo "selected='selected'";} ?>>Inactive</option>
                                    </select>
                                 </fieldset>
                                <div class="mask" style="height:10px;"></div>
                                
                                <fieldset style="float:left;">
                                    <input type="reset" class="btn21" value="Reset" style="width: 100px;float: left;margin-right: 15px;">
                                    <input type="submit" class="btn21" value="Save"  style="width:100px;">
                                </fieldset>
                           </form>
							
							
				
					    </div>
					</div>
					
				</div>





                   
				<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
