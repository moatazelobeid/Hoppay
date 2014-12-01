<script type="text/javascript">
function displayShippingPrice()
{
	var ship_type = $('input[name=shipping_details]:checked').val();
	
	//alert(ship_type);
	if(ship_type == 'Free Shipping')
	{
		$('.shipping_price_div').hide(1000);	
		$('#shipping_price').val('');	
		$('#shipping_time').val('');	
	}
	else
	{
		$('.shipping_price_div').show(1000);	
	}
}
</script>             
			 
			 
			 <?php  $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1; ?>
				<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg">
						<h1 class="font25"><?=$text_data['title']?></h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'index'))?>"> Home </a> 
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
						<?=$this->Session->flash('bad')?> 
            <?=$this->Session->flash('msg')?>
						<div class="prof_data1">
          			  <div data-role="fieldcontain" class="form-btns">
                            <fieldset>
                            <label for="returnuser" class="inline newlable1">
                           Store information
                            </label>
                            </fieldset>
                        </div>
                    
        <form>
           <table style="margin: 15px 0 0 0">
                  <tr>
                    <td style="width:152px;">
                   <label style="font-size:12px;" >Choose language
                    
                   </label>
                    </td>
                    <td>
                          
                                       
                              <?php if(!empty($store_info['Product_store']['id'])){ ?>
                                          <select name="lang_id" class="selectbox anpHintable" onchange="this.form.submit();" style="width: 375px;">
                                            <?php 
                                            foreach($lang as $val){ ?>
                                            <option value="<?=$val['Language']['id']?>"
                                             <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?> ><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>) </option>
                                           <?php } 
                                            ?>
                                          </select>
                                          <?php }else{ ?>
                                          
                                          <select name="lang_id" required disabled="disabled" class="selectbox anpHintable"  style="width: 357px;">
                                            <option value="1" >English</option>
                                         </select>
                                         <?php } ?>
                      </td>
                  </tr>
                </table>
              </form>
        
							<form class="dashboardpanform mystyle validate" action="" method="post">
                            <fieldset>
                            
                               <table>
                               <input type="hidden" value="<?=!empty($_GET['lang_id'])?$_GET['lang_id']:1?>" name="lang_id">

                                   
                                      <tr>
                                        <td>
                                       <label>Enter store name
                                       </label>
                                        </td>
                                        <td>
                                        <input type="text" required name="title" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="<?=isset($store_info['Product_store_lang']['title'])?$store_info['Product_store_lang']['title']:""?>">
                                        <input type="hidden" required name="id" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="<?=isset($store_info['Product_store']['id'])?$store_info['Product_store']['id']:""?>">
                                        <input type="hidden" required name="lange_id" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="<?=isset($store_info['Product_store_lang']['id'])?$store_info['Product_store_lang']['id']:""?>">
                                      </td>
                                     </tr>
                                     
                                     <tr>
                                        <td>
                                       <label>
                                         Enter store details
                                       </label>
                                        </td>
                                        <td>
                                     <textarea id="description" required name="description" class="form-text hasPlaceholder anpHintable valid"><?=isset($store_info['Product_store_lang']['description'])?$store_info['Product_store_lang']['description']:""?></textarea>   
                                      </td>
                                     </tr>.
                                      <tr>
                                        <td>
                                       <label>Shipping details
                                       </label>
                                        </td>
                                        <td class="chek_redio">
                                          <?php $data_ship=isset($store_info['Product_store']['shipping_details'])?$store_info['Product_store']['shipping_details']:""?>
                                          <span >

                                          <input type="radio" <?php echo $this->Template->Select($data_ship,'Free Shipping','checked')?> name="shipping_details" value="Free Shipping" onclick="displayShippingPrice();" >
                                          <label>Free Shipping</label></span>
                                          <span >
                                          <input type="radio" <?php echo $this->Template->Select($data_ship,'Fedex','checked')?> name="shipping_details" value="Fedex" onclick="displayShippingPrice();" >
                                          <label>Fedex</label></span>
                                          <span >
                                          <input type="radio" <?php echo $this->Template->Select($data_ship,'Aramex','checked')?>  name="shipping_details" value="Aramex" onclick="displayShippingPrice();" >
                                          <label >Aramex</label></span>
                                          <span>
                                            <input type="radio" <?php echo $this->Template->Select($data_ship,'Saudi Post-DHL','checked')?> name="shipping_details" value="Saudi Post-DHL" onclick="displayShippingPrice();" >
                                          <label >Saudi Post-DHL</label></span>
                                                                                 

                                      <!--  <input type="text" required name="shipping_details" placeholder="Enter Shipping Details" class="form-text hasPlaceholder anpHintable valid" value="<-?=isset($store_info['Product_store']['shipping_details'])?$store_info['Product_store']['shipping_details']:""?>">-->
                                        
                                      </td>
                                     </tr>
                                    <?php 
									$display_shipping_price = 'style="display:none;"';
									
									$shipping_details = $store_info['Product_store']['shipping_details'];
									
									if(!empty($shipping_details) && ($shipping_details != 'Free Shipping'))
									{
										$display_shipping_price = '';
									}?>
                                      <tr>
                                        <td class="shipping_price_div" <?php echo $display_shipping_price;?>>
                                       <label>Enter Shipping Price
                                       </label>
                                        </td>
                                        <td class="shipping_price_div" <?php echo $display_shipping_price;?>>
                                        <input type="text" name="shipping_price" id="shipping_price" placeholder="Enter Shipping Price." class="form-text hasPlaceholder anpHintable" value="<?=isset($store_info['Product_store']['shipping_price'])?$store_info['Product_store']['shipping_price']:""?>">
                                      </td>
                                     </tr>
                                     
                                      <tr>
                                        <td class="shipping_price_div" <?php echo $display_shipping_price;?>>
                                       <label>Enter Shipping Time
                                       </label>
                                        </td>
                                        <td class="shipping_price_div" <?php echo $display_shipping_price;?>>
                                        <input type="text" name="shipping_time" id="shipping_time" placeholder="Enter Shipping Time." class="form-text hasPlaceholder anpHintable" value="<?=isset($store_info['Product_store']['shipping_time'])?$store_info['Product_store']['shipping_time']:""?>">
                                      </td>
                                     </tr>
                                     
                          <?php //if(!empty($store_info['Product_store']['social_links']))
            									// {
                        $links_social=isset($store_info['Product_store']['social_links'])?$store_info['Product_store']['social_links']:"";
            					
                        	$sociallinkss = json_decode($links_social);
            										 //$cntt=0;
            										 
            										// foreach($sociallinkss as $social)
            										// {
										          ?>
                                      <!--<tr>
                                        <td>
                                      
                                       <label>
                                    	 <-?php echo $social_icons[$cntt]['Social_setting']['title']; ?>
                                       
                                       </label>
                                        </td>
                                       
                                        <td>
                                     <input type="url" required name="social_link[]" placeholder="Enter url." class="form-text hasPlaceholder anpHintable valid" value="<-?=!empty($social)?json_decode($social):''?>">
                                      </td>
                                     </tr>-->
                                     <?php
              									// $cntt++;
              										// }}else{ ?>
                                       <?php foreach($social_icons as $key=>$social_links): ?>
                                     <tr>
                                        <td>
                                      
                                       <label>
                                       <?php echo $social_links['Social_setting']['title']; ?>
                                       <img src="<?=$this->webroot?><?=isset($social_links['Social_setting']['image'])?$social_links['Social_setting']['image']:""?>" style="padding-left:5px;float: left;margin-right: 6px;" height="20px" alt="">
                                       </label>
                                        </td>
                                       <?php $keys=strtolower($social_links['Social_setting']['title']); ?>
                                        <td>
                                     <input type="url" name="social_link[<?=$keys?>]" placeholder="Enter url." class="form-text hasPlaceholder anpHintable valid" value="<?=!empty($sociallinkss->{$keys})?$sociallinkss->{$keys}:''?>">
                                     <!--?=isset($store['title'])?$store['title']:""?-->
                                      </td>
                                     </tr>
                                       <?php endforeach; ?>
                                       <?php 

                                        $payment_details=isset($store_info['Product_store']['payment_details'])?$store_info['Product_store']['payment_details']:"";
                      
                                        $payment = json_decode($payment_details);
                                        ?>
                                        <tr>
                                        <td>
                                       <label>Select payment option
                                       </label>
                                        </td>
                                        <td class="chek_redio">
                                        <span><input type="checkbox"  name="payment_details[visa]" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" <?php echo $this->Template->Select( isset($payment->visa)?$payment->visa:0,1,'checked')?> value="1">
                                        <label>VISA</label></span>
                                        <span><input type="checkbox"  name="payment_details[mastercard]" <?php echo $this->Template->Select( isset($payment->mastercard)?$payment->mastercard:0,1,'checked')?> placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="1">
                                        <label>Mastercard</label></span>
                                       <span> <input type="checkbox"  <?php echo $this->Template->Select(  isset($payment->cod)?$payment->cod:0,1,'checked')?>  name="payment_details[cod]" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="1">
                                        <label>Cash on Delivery</label></span>
                                      <span>  <input type="checkbox" <?php echo $this->Template->Select(  isset($payment->paypal)?$payment->paypal:0,1,'checked')?>  name="payment_details[paypal]" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="1">
                                        <label>paypal</label></span>

                                        <span>  
                                          <input type="checkbox" <?php echo $this->Template->Select(  isset($payment->SADAD)?$payment->SADAD:0,1,'checked')?>  name="payment_details[SADAD]" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="1">
                                        <label>SADAD</label></span>
                                         <span>  
                                          <input type="checkbox" <?php echo $this->Template->Select(  isset($payment->wire_transfer)?$payment->wire_transfer:0,1,'checked')?>  name="payment_details[wire_transfer]" placeholder="Enter Title." class="form-text hasPlaceholder anpHintable valid" value="1">
                                        <label>Wire Transfer</label></span>

                                      </td>
                                     </tr>
                                      <tr>
                                        <td>
                                       <label>Status
                                         <span class="small"></span>
                                       </label>
                                        </td>
                                        <td>
                                          <?php $status=$store_info['Product_store']['status'];?>
                                        <select required name="status" class="selectbox anpHintable"  style="width: 375px;">
                                            <option value="1" <?php if(isset($status) && $status==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($status) && $status==0){ echo "selected='selected'";} ?>>Inactive</option>
                                        </select>
                                      </td>
                                     </tr>
                                      
                                </table>
                               </fieldset>
                               <fieldset style="float:left;">
                                   <!-- <input type="submit" class="btn21" value="Reset" onclick="#" style="width: 100px;float: left;margin-right: 15px;">-->
                                    <input type="submit" class="btn21" value="Save" onclick="#" style="width:100px;">
                                </fieldset>
              				</form>
							
						</div>
						
						
						<div class="mask" style="height:10px;"></div>
						
						
						<div class="mask" style="height:10px;"></div>
					</div>
					
					<?=$this->element('merchant/dashbord_right_sidebar')?>
				</div>
				
				<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
