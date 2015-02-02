 
<script>
$(function(){
  $('.check_all').change(function(){
  //alert('sdfsd');

  if($(this).is(':checked')){
    $('.check_all').attr('checked','checked');
    $('.user_checked').attr('checked','checked');
  }
  else
  {
     $('.check_all').removeAttr('checked');
     $('.user_checked').removeAttr('checked');
  }

});

$('#action_option').change(function(){
    var data=new Array();
    $('.user_checked:checked').each(function(){
         data.push($(this).data('id'));
     });
   
    var jsonArray = JSON.parse(JSON.stringify(data));
if(data.length<=0){
  //alert('no data');
}
else{
    if($(this).val()=='1')
    {
        $.post('<?=$this->webroot?>offers/bulk_active',{'ids':JSON.stringify(jsonArray),'model':'Offer'},function(r){
          console.log(r);
          if(r=='1')
          {
             window.location.assign($('#actived').val());
            
          }
        })
        
    }
    else if( $(this).val()=='0')
    {
      $.post('<?=$this->webroot?>offers/bulk_inactive',{'ids':JSON.stringify(jsonArray),'model':'Offer'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#inactive').val());
            
          }
        })
    }
    else if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>offers/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Offer'},function(r){
          console.log(r);
          if(r=='1')
          {
            window.location.assign($('#delete').val());
            
          }
        })
    }
 }
})

})
  
</script>
  

              <?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';?>
              <?php $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:'1'; ?>
               <?php $cat_id=isset($_GET['cat_id'])?$_GET['cat_id']:''; ?>
              <?php    // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'offer',
           'action' => 'index'
        );
  ?>
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'ordered')?>" id="order">
 
 
 
<?php 
extract($merchant);
extract($condition);
?>

<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
<div class="prof_data_bg" style="width: 776px;margin: 0px 0px 0px 25px;">
						<h1 class="font25"><?=$text_data['title']?></h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="<?=$this->Template->CreateParamLink1(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'index'))?>"> Home </a> 
							
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						<div style="float: right;margin-right: 5px;position: relative;top: 8px;">
                        	<a href="<?php echo $this->webroot;?>en/merchant/offers/add_offer">
                            	<input type="button" class="btn21" style="height: 30px !important;margin-bottom: 10px;" value="Add Offer">
                            </a>
                            
                        </div>
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
                        
                       <!-- <div class="errorpanel">Error message goes here...</div>
                    
                      <div class="successpanel">Success message goes here...</div>-->
						<?=$this->Session->flash('bad')?> 
                        <?=$this->Session->flash('msg')?>
						
                        <div class="prof_data1">
                            <div class="CSSTableGenerator">
                                <table style="width: 30%;float:left">
                                    <tbody>
                                        <tr></tr>
                                        <tr>
                                            <td> 
                                                <select id="action_option" style="width:auto !important">
                                                    <option value="">Bulk Action</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                    <option value="D">Delete</option>            
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form method="get" action="<?php echo $this->webroot;?>en/merchant/offers" novalidate="novalidate"> 
                                    <table style="width:65%;float:right">
                                        <tbody>
                                        	<tr></tr>
                                            <tr>
                                                <td width="100">
                                                	<input type="text" name="text_search" value="<?php if(isset($text_search))echo $text_search;?>" placeholder="Search Here"> 
                                                </td>
                                                <td width="2%">
                                                <select name="offer_type" onchange="this.form.submit();" style="width: 105px;">
                                                    <option value="">--Offer Type--</option>
                                                    <option value="discount" <?php if(isset($offer_type) && $offer_type == 'discount'){?>selected="selected" <?php }?>>Discount</option>
                                                    <option value="coupon_code" <?php if(isset($offer_type) && $offer_type == 'coupon_code'){?>selected="selected" <?php }?>>Coupon Code</option>
                                                </select>
                                                
                                                </td>
                                               
                                                <td width="2%">
                                                <select name="status" onchange="this.form.submit();" style="width: 85px!important;">
                                                <option value="">-- Status --</option>
                                                <option value="1" <?php if(isset($status) && $status == '1'){?>selected="selected" <?php }?>> Active </option>
                                                <option value="0" <?php if(isset($status) && $status == '0'){?>selected="selected" <?php }?>> Inctive </option>
                                                </select> 
                                                </td>
                                                
                                                <td width="7%">
                                                <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
                                                </td>
                                                <td width="1%">
                                                <input type="reset" value="Reset" onclick="window.location.assign('<?php echo $this->webroot;?>/en/merchant/offers')">
                                                
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form> 
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><input class="check_all" type="checkbox"></td>
                                            <td><a href="<?php echo $this->webroot;?>merchant/products/index/sort:id/direction:asc">Sl.</a></td>
                                            <td>Offer Title</td>
                                            <td>Image</td>
                                            <td>Offer Details</td>
                                            <td>Action</td>
                                        </tr>
                                        <?php if(!empty($offerlist))
										{
											foreach($offerlist as $key => $offer)
											{?>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" data-id="<?=$offer['Offer']['id']?>" class="user_checked <?=$offer['Offer']['id']?>">
                                                    </td>
                                                    <td style="text-align: center;"><b><?=($key+1)?></b></td>
                                                    <td style="text-align: left;">
														<span style="font-size: 12px; font-weight:bold;"><?=htmlspecialchars_decode($offer['Offer']['offer_title'])?></span>
                                                    	<br>
                                                        <?=htmlspecialchars_decode($offer['Offer']['offer_desc'])?>
                                                    </td>
                                                    <td style="text-align: center;">
													<?php if(!empty($offer['Offer']['offer_image']))
														{
															echo $this->Html->image('../'.$offer['Offer']['offer_image'],array('width'=>'100')).'<br>';
														}
														else
														{
															echo 'N/A';	
														}?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                    	
														<table>
                                                        	<tr></tr>
                                                        	<tr>
                                                            	<td style="width: 65px !important;">Offer Type</td>
                                                                <td>
																	<?php if($offer['Offer']['offer_type']==1)echo 'Discount';
                                                                    	if($offer['Offer']['offer_type']==2) echo 'Coupon Code';
																		if($offer['Offer']['offer_type']==3){ echo stripslashes($offer['Offer']['other_offer_type']);}?>
                                                               </td>
                                                            </tr>
                                                            <?php 
															if($offer['Offer']['offer_type']==2)
															{?>
                                                                <tr>
                                                                    <td>Coupon Code</td>
                                                                    <td>
                                                                        <?php echo $offer['Offer']['ccode'];?>
                                                                   </td>
                                                                </tr>
                                                            <?php }?>
                                                        	<tr>
                                                            	<td>Discount</td>
                                                                <td>
																	<?php echo $offer['Offer']['discount'];?>%
                                                               </td>
                                                            </tr>
                                                        	<tr>
                                                            	<td>Offer Time</td>
                                                                <td>
																	<?php
                                                                    echo date('d-m-Y',strtotime($offer['Offer']['start_date'])).' To '.date('d-m-Y',strtotime($offer['Offer']['end_date']));?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            	<td>Status</td>
                                                                <td>
																	<?php 
																	if($offer['Offer']['end_date'] > date('Y-m-d'))
																	{
																		if($offer['Offer']['status']==1)
																			echo 'Active';
																		else 
																			echo 'Inactive';
																	}
																	else
																	{
																		echo 'Expired';
																	}?>
                                                    			</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    
                                                    <td style="text-align: center;">
                                                        <a class="various10" href="<?php echo $this->webroot;?>en/merchant/offers/update/<?php echo $offer['Offer']['id']?>" style="text-decoration: none;">
                                                        	<input type="image" src="<?php echo $this->webroot;?>images/dashbord/icn_edit.png" title="Edit">
                                                        </a>
                                                        <a onClick="return confirm('Are you sure to delete this offer?');" href="<?php echo $this->webroot;?>en/merchant/offers/delete/<?php echo $offer['Offer']['id']?>" style="text-decoration: none;">   
                                                        	<input type="image" src="<?php echo $this->webroot;?>images/dashbord/icn_trash.png" title="Trash">
                                                        </a>
                                                        <a href="<?php echo $this->webroot;?>en/merchant/offers/set_product/<?php echo $offer['Offer']['id']?>" style="text-decoration: none;" class="various" title="Assign Products">   
                                                        	<input type="image" src="<?php echo $this->webroot;?>images/dashbord/product.png" title="Assign Products">
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php }?>
                                        	<tr>
                                                <td colspan="8">
                                                <div class="pagination-holder clearfix">
                                                    <div id="light-pagination" class="pagination">
                                                        <?php     
                                                        echo $this->Paginator->prev(
                                                            ' Previous',
                                                            null,
                                                            null,
                                                            array('class' => 'disabled')
                                                            );
                                                        
                                                        echo $this->Paginator->numbers(array('separator' => ''));
                                                        
                                                        echo $this->Paginator->next(
                                                            'Next ',
                                                            null,
                                                            null,
                                                            array('class' => 'disabled')
                                                        ); ?>
      
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                        <?php 
										}
										else
										{
											?>
                                            	<tr>
                                                	<td colspan="8" style="text-align:center;">No Record Found!</td>
                                                </tr>
                                            <?php 
										}?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
						<div class="mask" style="height:10px;"></div>
						<div class="mask" style="height:10px;"></div>
					</div>
						<?php //echo $this->element('merchant/dashbord_right_sidebar')?>
				</div>
				
				<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        