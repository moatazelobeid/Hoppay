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
 </style>
				<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg"  style="width: 776px;margin: 0px 0px 0px 25px;">
						<h1 class="font25"><?=$text_data['title']?> "<?=isset($prod_data['Product_lang']['title'])?$prod_data['Product_lang']['title']:""?>"</h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink(array(                                        
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
                                    $data=json_decode($prod_data['Product']['image_url']);
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
        
