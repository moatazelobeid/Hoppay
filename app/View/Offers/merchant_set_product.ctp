 <?php extract($merchant)?>
 
<script>
function setOffer(val)
{
	if(val == 1)
	{
		$('#ccode_section').hide();
	}
	if(val == 2)
	{
		$('#ccode').val('');
		$('#ccode_section').show();
	}
}
jQuery(document).ready(function() 
{
	
	var timer = setInterval( showDiv, 5000);
	
	function showDiv()
	{
		$aa = jQuery('#msgMessage').slideUp();
	}
	
	//disable the save btn
	$('.save_btn').attr('disabled','disabled');

});


function getSubcat(val,slno)
{
	if(val!='')
	{
		var id = $('#cat_level').val();
		
		if(id>1)
		{
			var iid = parseInt(id)-1;
			$('#cat_'+iid).attr('disabled','disabled');	
		}
		
		var slno2 = parseInt(slno)+1;
		
		if(document.getElementById('cat_lvl_'+slno2))
		{
			$('#cat_lvl_'+slno2).remove();	
			$('#cat_level').val(slno);		
		}
		
		var id = $('#cat_level').val();
		
        $.get('<?=$this->webroot?>offers/get_subcat/<?php echo $offer['Offer']['id'];?>/'+val+'/'+id,function(data){
          console.log(data);
          //alert(data);
		  
		  	  var result_data = data.split('~*~');
			  
			  var data1 = result_data[0];
			  
			  var data2 = result_data[1];
			  
			  if(id == 1)
			  {
				 $('#product_div').addClass('product_div'); 
			  }
			  $('.save_btn').removeAttr('disabled');  
			  
			  //alert(result_data[0]); alert(result_data[1]);
		  
		  	  if(data1!='')
			  {
				  $('#cat_lvl_'+id).after(data1);
				  
				  var nid = parseInt(id)+1;
				  
				  $('#cat_level').val(nid);
			  }
			  
			  if(data2!='')
			  {
				  $('#product_div').html(data2);
			  }
        });
	}	
	else
	{
		getAllProducts();
	}
}

function getAllProducts()
{
	var id = $('#cat_level').val();
	for(var i =2; i<=id; i++)
	{
		$('#cat_lvl_'+i).remove();		
	}
	$.get('<?=$this->webroot?>offers/get_allproducts/<?php echo $offer['Offer']['id'];?>',function(data){
		console.log(data);
		
		$('#product_div').html(data);
		
		
	});
}

function resetCat()
{
	$('#cat_1').removeAttr('disabled');
	var id = $('#cat_level').val();
	for(var i=2; i<=id; i++)
	{
		$('#cat_lvl_'+i).remove();	
	}
	
	if ($("#product_list").length !== 0)
	{
		$("#product_list").remove();	
	}
	
	$('#cat_level').val(1);
	$(".no_msg").remove();	
	$('.save_btn').attr('disabled','disabled');
	$('#product_div').removeClass('product_div'); 
}


function validPform()
{
	if ($("#product_list").length !== 0)
	{
		if (!jQuery("input:checkbox").is(":checked")) {
			
			//jQuery('#perr_msg').html('Please select atleast one product');
			//alert("none checked");
			//return false;
		}
		else
		{
			jQuery('#perr_msg').html('');	
		}
	}
	else
	{
		//return false;
	}
}

function checkAllProducts()
{
	if(!jQuery("#chkall").is(":checked")) 
	{
		$('.pid_chk').removeAttr('checked');		
	}
	else
	{
		$('.pid_chk').attr('checked','checked');
	}
}

function removeCat(slno)
{
	var id = $('#cat_level').val();	
	
	if(slno < id)
	{
		for(var i =slno; i<=id; i++)
		{
			$('#cat_lvl_'+i).remove();		
		}	
	}
	else
	{
		$('#cat_lvl_'+slno).remove();			
	}
	
	var cid = parseInt(slno)-1;
	var cat_id = $('#cat_'+cid).val();	
	
	$('#cat_level').val(cid);
	
	getMaincat(cat_id);
	
}

function getMaincat(val)
{
	if(val!='')
	{
		var id = $('#cat_level').val();
		$('#cat_'+id).removeAttr('disabled');	
		
        $.get('<?=$this->webroot?>offers/get_subcat/<?php echo $offer['Offer']['id'];?>/'+val+'/'+id,function(data){
          console.log(data);
          //alert(data);
		  
		  	  var result_data = data.split('~*~');
			  
			  var data1 = result_data[0];
			  
			  var data2 = result_data[1];
			  
			  if(id == 1)
			  {
				 $('#product_div').addClass('product_div'); 
			  }
			  $('.save_btn').removeAttr('disabled');  
			  
			  if(data2!='')
			  {
				  $('#product_div').html(data2);
			  }
        });
	}	
}


</script>
<style>
.save_btn:disabled
{
	cursor:default !important;
}
#perr_msg
{
	color:#FF0000;
}
.dashboardpanform fieldset label.offr_cat_lvl
{
	width: 100% !important;
	margin-bottom: 10px	;
}
div.set_offer_form
{
	width: 48%;
	float: left;
}
#product_div
{
	width: 50%;
	float: right;
	padding: 5px;
}
.product_div
{
	border: 1px solid #B2B2B2;
	min-height: 95px;
}
.dashboardpanform fieldset select
{
	width:200px;
}
#product_list
{
	padding:0px 0px 10px 0px;
	max-height:600px;
	overflow-x:hidden;
}
#product_list h3
{
	border-bottom: 1px solid #B2B2B2;
	margin-bottom: 5px;
	padding-bottom: 5px;
}
</style>
<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
<div class="prof_data_bg" style="width: 776px;margin: 0px 0px 0px 25px;">
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
							
                           <form class="dashboardpanform validate" action="" method="POST">
                           		
                                <div class="set_offer_form">
                                    <fieldset style="margin-top: 5px;">Offer: <b><?php echo stripslashes($offer['Offer']['offer_title']);?></b></fieldset> 
                                    
                                    <fieldset id="cat_lvl_1">
                                        <label class="loginaddtion offr_cat_lvl">Select Category: <span class="errorfield" style="display:none;">Select Category</span></label>
                                        <input type="hidden" id="cat_level" value="1" />
                                        <select id="cat_1" class="valid catlist_box" onchange="getSubcat(this.value,1);" name="category_id[]">
                                            <option value="">Select Category</option>
                                            <?php if(!empty($catlist))
                                            {
                                                foreach($catlist as $cat)
                                                {?>
                                                    <option value="<?php echo $cat['Product_category']['id'];?>"><?php echo stripslashes($cat['Product_category_lang']['category_name']);?></option>
                                                <?php }	
                                            }?>
                                        </select>
                                    </fieldset>
                                    
                                    <div id="subcat_div"></div>
    
                                    <div class="mask" style="height:10px;"></div>
                                    
                                    <fieldset style="float:left;">
                                        <input type="reset" class="btn21" value="Reset" onclick="resetCat();" style="width: 90px;float: left;margin-right: 15px;">
                                        <input type="submit" class="btn21 save_btn" value="Save" onclick="return validPform();" style="width:90px;">
                                    </fieldset>
                                </div>
                                <div id="product_div">
                                <?php $product_result='';
								$this->Offer = ClassRegistry::init('Offer');
								$offer_id = $offer['Offer']['id'];
								if(!empty($products))
								{
									$product_result.= '<div id="product_list" class="product_div">
														<h3><input type="checkbox" onclick="checkAllProducts();" id="chkall" /> Select Product</h3><div id="perr_msg"></div>';
									foreach($products as $product)
									{
										$pid = $product['Product']['id'];	
										$pname = stripslashes($product['Product_lang']['title']);	
										
										$checked='';
										
										if($offer_id == $product['Product']['offer_id'])
											$checked='checked="checked"';
											
										if(!empty($product['Product']['offer_id']))
										{
											$pofferid = $product['Product']['offer_id'];
											$offer_data = $this->Offer->find('first',array('conditions'=>array('Offer.id'=>$pofferid)));	
											$offer_name = stripslashes($offer_data['Offer']['offer_title']);
											
											if($offer_data['Offer']['offer_type']==3)
												$offer_name = stripslashes($offer_data['Offer']['other_offer_type']);
											
											if(!empty($offer_name))
											{
												$pname = '<b>'.$pname.'</b> ('.$offer_name.')';
											}	 
										}
										else
										{
											$offer_name = '';	
										}
										
										$product_result.= '<input type="checkbox" class="pid_chk" name="product[]" value="'.$pid.'" '.$checked.' />'.$pname.'<br>';
									}	
									
									
									$product_result.= '</div>';
								}	
								else
								{
									$product_result.= '<div class="no_msg">No Product Found</div>';	
								}	
								echo $product_result;
								?>
                                </div>
                                
                           </form>
							
						</div>
						
						
						<div class="mask" style="height:10px;"></div>
						
						
						<div class="mask" style="height:10px;"></div>
					</div>
						
				</div>
				
				<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        