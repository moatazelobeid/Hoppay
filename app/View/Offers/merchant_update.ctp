 <?php extract($merchant)?>
 
<script>
function setOffer(val)
{
	if(val == 1)
	{
		$('#ccode_section').hide();
		$('#other_section').hide();
	}
	if(val == 2)
	{
		$('#ccode_section').show();
		$('#other_section').hide();
	}
	if(val == 3)
	{
		$('#other_section').show();
		$('#ccode_section').hide();
	}
	$('#ccode').val('');
	$('#other_offer_type').val('');
}
jQuery(document).ready(function() 
{
	
	var timer = setInterval( showDiv, 5000);
	
	function showDiv()
	{
		$aa = jQuery('#msgMessage').slideUp();
	}

});

</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function() {
	$( ".datepicker" ).datepicker({
		
		dateFormat: 'dd-mm-yy',
    	changeMonth: true,
		minDate:0
		});
});
</script>

<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
<div class="prof_data_bg">
						<h1 class="font25"><?=$text_data['title']?></h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'index'))?>"> Home </a> 
							
                            <span class="breeadset">›</span>
                            <a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant/offers','action' => ''))?>"> Offers & Deals </a> 
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
                        
                       <!-- <div class="errorpanel">Error message goes here...</div>
                    
                      <div class="successpanel">Success message goes here...</div>-->
						<?=$this->Session->flash('bad')?> 
                        <?=$this->Session->flash('msg')?>
						<div class="prof_data1">
							<?php //echo '<pre>'; print_r($offer); echo '</pre>'; exit;?>
                           <form class="dashboardpanform validate" action="" method="POST" enctype="multipart/form-data">
                           		<fieldset>
                                    <label class="loginaddtion">Offer Title: <span class="errorfield" style="display:none;">Enter Offer Title</span></label>
                                    <input size="30" type="text" value="<?=htmlspecialchars_decode($offer['Offer']['offer_title'])?>" name="offer_title" required id="offer_title" class="form-text hasPlaceholder anpHintable" data-hint-num="0" style="width: 345px;">
                                </fieldset>
                                
                           		<fieldset>
                                    <label class="loginaddtion">Offer Image: <span class="errorfield" style="display:none;">Enter Offer Title</span></label>
                                    <div style="margin-left:150px;">
										<?php if(!empty($offer['Offer']['offer_image']))
                                        {
                                            echo $this->Html->image('../'.$offer['Offer']['offer_image'],array('width'=>'100')).'<br>';
                                        }?>
                                        <input size="30" type="file" name="offer_image">
                                    </div>
                                </fieldset>
                                
                           		<fieldset>
                                    <label class="loginaddtion">Offer Description: <span class="errorfield" style="display:none;">Enter Offer Title</span></label>
                                    <textarea name="offer_desc" id="offer_desc" class="form-text" style="width: 345px; resize:none;"><?=htmlspecialchars_decode($offer['Offer']['offer_desc'])?></textarea>
                                </fieldset>
                                
                                <fieldset>
                                    <label class="loginaddtion">Offer Type:</label>
                                    <select name="offer_type" id="offer_type" onchange="setOffer(this.value);">
                                      <option value="1" <?php if($offer['Offer']['offer_type']==1){?> selected="selected"<?php }?>>Discount</option>
                                      <option value="2" <?php if($offer['Offer']['offer_type']==2){?> selected="selected"<?php }?>>Coupon code</option>
                                      <option value="3" <?php if($offer['Offer']['offer_type']==3){?> selected="selected"<?php }?>>Other</option>
                                    </select>
                                </fieldset>
                           		<fieldset>
                                    <label class="loginaddtion">Discount (%): <span class="errorfield" style="display:none;">Enter Offer Title</span></label>
                                    <input size="10" type="text" value="<?=$offer['Offer']['discount']?>" name="discount" required id="discount" class="form-text hasPlaceholder anpHintable" data-hint-num="0" style="width: 345px;">
                                </fieldset>
                           		<fieldset <?php if($offer['Offer']['offer_type']==2){}else{?> style="display:none;"<?php }?> id="ccode_section">
                                    <label class="loginaddtion">Coupon Code: <span class="errorfield" style="display:none;">Enter Offer Title</span></label>
                                    <input size="10" type="text" value="<?=$offer['Offer']['ccode']?>" name="ccode" required id="ccode" class="form-text hasPlaceholder anpHintable" data-hint-num="0" style="width: 345px;">
                                </fieldset>
                           		<fieldset <?php if($offer['Offer']['offer_type']==3){}else{?> style="display:none;"<?php }?> id="other_section">
                                    <label class="loginaddtion">Other Offer Type: <span class="errorfield" style="display:none;">Enter Offer Type</span></label>
                                    <input size="10" type="text" name="other_offer_type" value="<?php echo $offer['Offer']['other_offer_type']?>" required id="other_offer_type" class="form-text hasPlaceholder anpHintable" data-hint-num="0" style="width: 345px;">
                                </fieldset>
                           		<fieldset>
                                    <label class="loginaddtion">Offer Time: <span class="errorfield" style="display:none;">Enter Offer Title</span></label>
                                    <input size="10" type="text" value="<?php echo date('d-m-Y',strtotime($offer['Offer']['start_date']));?>" name="start_date" id="start_date" class="form-text datepicker" autocomplete="off" style="width: 100px;">
                                    &nbsp;To&nbsp;
                                    <input size="10" type="text" value="<?php echo date('d-m-Y',strtotime($offer['Offer']['end_date']));?>" name="end_date" id="end_date" class="form-text datepicker" autocomplete="off" style="width: 100px;">
                                </fieldset>
                                <fieldset>
                                    <label class="loginaddtion">Status: </label>
                                    <select name="status" requred="" class="valid">
                                      <option value="1" <?php if($offer['Offer']['status']==1){?> selected="selected"<?php }?>>Active</option>
                                      <option value="0" <?php if($offer['Offer']['status']==0){?> selected="selected"<?php }?>>Inactive</option>
                                    </select>
                                </fieldset>
							
                                <div class="mask" style="height:10px;"></div>
                                
                                <fieldset style="float:left;">
                                    <input type="reset" class="btn21" value="Reset" onclick="#" style="width: 100px;float: left;margin-right: 15px;">
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
        