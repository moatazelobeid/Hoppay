
<?php
@extract($this->params['named']);
@extract($this->params->query);
?>

<script type="text/javascript" src="<?=$this->webroot?>rating/rating.js"></script>
 <link rel="stylesheet" type="text/css" href="<?=$this->webroot?>rating/rating.css" />
 <style>
.showratings {
overflow: visible;
padding: 5px 0px;
position: relative;
width: 75px;
height: 20px;
display: inline;
float: right;
}

#plist
{
	position: absolute;
	right: 304px;
	width: 150px;
	background: rgb(226, 225, 225);
	max-height: 120px;
	overflow-x: hidden;
	z-index: 5;
}
#plist ul
{
	margin-top: -3px;
	border: 1px solid rgb(226, 225, 225);
	border-top: 0;
}
#plist ul, #plist ul li
{
	width:100%;
}
#plist ul li
{
	cursor:pointer;
	padding: 5px;
}
#plist ul li:hover
{
	background: #fff;
}
 </style>
 <script type="text/javascript">
function getPslug(pslg)
{
	$('#product').val(pslg);
	$('#plist').html('');
}

function getProducts(prod)
{
	if(prod!='')
	{
		var url = '<?php echo $this->webroot;?>/merchant/getReviewProducts/'+prod+'/<?=$merchantid?>';	
		//alert(url);
		$.get(url, function(data)
		{
			//alert(data);
			$('#plist').html(data);
		});
	}
	else
	{
		$('#plist').html('');	
	}
}


$(function() {
	
	$( ".date_picker" ).datepicker({dateFormat: 'dd-mm-yy'});
	
});
 
function resetSearch()
{
	var url = '<?php echo $this->webroot.$this->Template->getLang();?>/merchant/reviewRatings<?php if(!empty($page)){echo '/page:'.$page;}?>';	
	window.location.href = url;
} 
 
/* function filterReviews(pslug)
 {
 	var url = '<?php echo $this->webroot;?>merchant/reviewRatings';
	
	var page = '<?php echo $page;?>';
	
	if(page != '')
	{
		url+='/page:'+page;
	}
	
	if(pslug!='')
	{
		url+='/product:'+pslug;
	}
	
	window.location.href = url;
 }*/
 
 
 
 	$(function(){
 		$('.sn_status').click(function(){

 			var cla=$(this).attr('class');
 			var p=cla.split(' ');
 			$('#sn_status'+p[1]).css('display','block');
 			$.post('<?=$this->webroot?>en/merchant/active/<?=$type?>/'+p[2]+'/'+p[1],function(r){
 				
 				
 				if(r==1)
 				{
 					//alert('sghsgs');
 					$('#sn_reviews_section'+p[1]).toggleClass('sn_section_active');
 					$('#sn_reviews_section'+p[1]).toggleClass('sn_section_inactive');
					$('#sn_status'+p[1]).toggleClass('sn_active');
					$('#sn_status'+p[1]).toggleClass('sn_inactive');
					$('#sn_status'+p[1]+'.sn_active').text('Activated');
					$('#sn_status'+p[1]+'.sn_inactive').text('Inactivated');
					//$('#sn_status'+p[1]).toggleText('Active');
					setTimeout(function(){
						$('#sn_status'+p[1]).fadeOut();
						$('#sn_status'+p[1]+'.sn_active').text('Inactive');
					    $('#sn_status'+p[1]+'.sn_inactive').text('Active');
					},2000)
 				}
 					
 				
 			})
 		})

 	})
 </script>
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
						<div class="tabContanet">
							<div class="tabMenues">
								<a href="<?=$this->webroot?>merchant/reviewRatings/product" class="<?=($type=="product")?'active':''?>">Product Reviews</a>
								<a href="<?=$this->webroot?>merchant/reviewRatings/my" class="<?=($type=="my")?'active':''?>">My Reviews</a>
								
							</div>
							
						<div class="borderdash"></div>
						<?php if($type=="product"){ ?>
                        <form name="review_form" method="get" action="<?php echo $this->webroot.$this->Template->getLang();?>/merchant/reviewRatings">
                        <input type="text" placeholder="From Date" class="date_picker" name="from_date" id="from_date" autocomplete="off" value="<?php if(isset($from_date)){echo $from_date;}?>" style="width: 62px;" />
                        
                        <input type="text" placeholder="To Date" name="to_date" id="to_date" autocomplete="off" class="date_picker" value="<?php if(isset($to_date)){echo $to_date;}?>" style="width: 62px;" />
                        
                        <input type="text" placeholder="Search Here" name="search" autocomplete="off" id="search" value="<?php if(isset($search)){echo $search;}?>" />
                        <input type="text" placeholder="Product Name" name="product" autocomplete="off" id="product" value="<?php if(isset($product)){echo $product;}?>" onkeyup="getProducts(this.value);" />
                       <div id="plist"></div>
                        <select name="status" style="width: 85px!important;">
                          <option value="">- Status -</option>
                          <option value="1" <?php if(isset($status) && ($status == 1)){echo 'selected';}?>> Active </option>
                          <option value="0" <?php if(isset($status) && ($status == 0) && ($status != '')){echo 'selected';}?>> Inactive </option>
                        </select>
                         <div class="clear" style="height:10px;"></div>
                        <input type="submit" class="search_button" value="Search">
                         
                        <input type="button" class="search_button" value="Reset" onclick="resetSearch();">
						</form>
						<div class="clear" style="height:5px;"></div>
						
						<div class="prof_data1">
						<?php 
						//echo"<pre>";print_r($product_review);echo"</pre>"; exit;
						if(!empty($product_review))
						{
							if(empty($product_list))
							{}
						
						foreach ($product_review as $key => $value) 
						{ 
							?>
							<div class="sn_sideBar">
								<div class="sn_product_info">
										<!--<span class="sn_prod_img">
											<img src="">
										</span>-->
										<span class="sn_heading">
												<?=$value['Product_review']['title'] ?>
										</span>
										<a onclick="deleteAction('<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/reviewDelete/product/<?=$value['Product_review']['id'] ?>/<?=@$this->params['named']['page']?>','Ratings and Reviews','<?=$value['Product_review']['title'] ?>',false,'Are you want to delete this Review?')"
										 href="javascript:void(0);" style="text-decoration: none;">   
                                         <input type="image" class="trush_in_review" src="<?=$this->webroot?>images/icn_trash.png" title="Trash">
                                                        </a>
							    </div>
								<div class="sn_reviews">
                                <?php
										$product_title = $this->Template->getProductTitle($value['Product_review']['product_id']);
										$user = $this->Template->getRivewUserDetails($value['Product_review']['user_id']);
										$ruser = $user['Reviewed_user'];?>
										<div class="sn_reviews_section <?=$value['Product_review']['id']?> <?=($value['Product_review']['status']!=0)?'sn_section_active':'sn_section_inactive'?>" id="sn_reviews_section<?=$value['Product_review']['id']?>">
											<div class="sn_heading">
												<?=$product_title?>
												
												 <div id="ratingss_<?=$key.$key?>" class="showratings">
															<div class="star_1 ratings_stars"></div>
															<div class="star_2 ratings_stars"></div>
															<div class="star_3 ratings_stars"></div>
															<div class="star_4 ratings_stars"></div>
															<div class="star_5 ratings_stars"></div>
															<!--<div class="total_votes">vote data</div>-->
														</div>
														<script>
														  $(function(){
															 $('#ratingss_<?=$key.$key?> div').each(function(k,v){
																 var select= <?=$value['Product_review']['rating']?>;
																 if(select!=undefined)
																  if(k<select)
																  {
																		$(this).prevAll().andSelf().addClass('ratings_over');
																  }

															  })
														  })
	
														</script>
											</div>
											<div style="padding:5px;color: rgb(155, 152, 152);font-size: 11px;"><b><?=$ruser['name'] ?></b>
											<div class="clearfix" style="height:5px;"></div>
											<?=$ruser['email_id'] ?>
											<div class="clearfix" style="height:5px;"></div>
											<b><?php if(!empty($value['Product_review']['review_date']) && ($value['Product_review']['review_date']!='0000-00-00 00:00:00'))echo date('d-m-Y H:i',strtotime($value['Product_review']['review_date']));?></b>
											</div>
											<div class="sn_description">
												<?=htmlspecialchars_decode(nl2br($value['Product_review']['comment']))?>
												<div class="sn_status <?=$value['Product_review']['id']?> <?=($value['Product_review']['status']!=0)?'sn_active':'sn_inactive'?>" id="sn_status<?=$value['Product_review']['id']?>"><?=($value['Product_review']['status']!=0)?'Inactive':'Active'?></div>
											</div>
										 </div>
									
							    </div>
							</div>
						<?php } ?>
							<div class="pagination-holder clearfix">
								<div id="light-pagination" class="pagination">
								
								<?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
								<!-- Shows the page numbers -->
								<?php echo $this->Paginator->numbers(array('separator' => '')); ?>
								<!-- Shows the next and previous links -->
								
								<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>
								<!-- prints X of Y, where X is current page and Y is number of pages -->
								<?php //echo $this->Paginator->counter(); ?>
								</div>
							</div>
						<?php 

					}
					else{
						echo "<center><h1>No Reviews and Ratings Available.</h1></center>";
					}?>
					   </div>
					<?php } elseif($type=="my") {
						?>
                <form name="review_form" method="get" action="<?php echo $this->webroot.$this->Template->getLang();?>/merchant/reviewRatings/my">
                        <input type="text" placeholder="From Date" class="date_picker" name="from_date" id="from_date" autocomplete="off" value="<?php if(isset($from_date)){echo $from_date;}?>" style="width: 62px;" />
                        
                        <input type="text" placeholder="To Date" name="to_date" id="to_date" autocomplete="off" class="date_picker" value="<?php if(isset($to_date)){echo $to_date;}?>" style="width: 62px;" />
                        
                        <input type="text" placeholder="Search Here" name="search" autocomplete="off" id="search" value="<?php if(isset($search)){echo $search;}?>" />
                       
                       <div id="plist"></div>
                        <select name="status" style="width: 85px!important;">
                          <option value="">- Status -</option>
                          <option value="1" <?php if(isset($status) && ($status == 1)){echo 'selected';}?>> Active </option>
                          <option value="0" <?php if(isset($status) && ($status == 0) && ($status != '')){echo 'selected';}?>> Inactive </option>
                        </select>
                         <div class="clear" style="height:10px;"></div>
                        <input type="submit" class="search_button" value="Search">
                         
                        <input type="button" class="search_button" value="Reset" 
                        onclick="window.location.assign('<?=$this->webroot?>merchant/reviewRatings/my')">
						</form>
						<div class="clear" style="height:5px;"></div>
						<hr>
						<div class="Merchant_total_ratings">
							<div style="display:inline-block">Total Ratings: </div>
							<div id="merchant-ratingss" style="display:inline-block;position: relative;top: 12px;left: 5px;" >
															<div class="star_1 ratings_stars"></div>
															<div class="star_2 ratings_stars"></div>
															<div class="star_3 ratings_stars"></div>
															<div class="star_4 ratings_stars"></div>
															<div class="star_5 ratings_stars"></div>
															<!--<div class="total_votes">vote data</div>-->
														</div>
														<script>
														  $(function(){
															 $('#merchant-ratingss div').each(function(k,v){
																 var select= <?=$totalRating?>;
																 if(select!=undefined)
																  if(k<select)
																  {
																		$(this).prevAll().andSelf().addClass('ratings_over');
																  }

															  })
														  })
	
														</script>
						</div>
						<div class="prof_data1">
						<?php 
						//echo"<pre>";print_r($product_review);echo"</pre>"; exit;
						if(!empty($merchant_review))
						{
							if(empty($merchant_list))
							{}
						
						foreach ($merchant_review as $key => $value) 
						{ 
							?>
							<div class="sn_sideBar">
								<div class="sn_product_info">
										<!--<span class="sn_prod_img">
											<img src="">
										</span>-->
										<span class="sn_heading">
												<?=$value['Merchant_rating']['title'] ?>
										</span>
										<a onclick="deleteAction('<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/reviewDelete/my/<?=$value['Merchant_rating']['id'] ?>/<?=@$this->params['named']['page']?>','Ratings and Reviews','<?=$value['Merchant_rating']['title'] ?>',false,'Are you want to delete this Review?')"
										 href="javascript:void(0);" style="text-decoration: none;">   
                                         <input type="image" class="trush_in_review" src="<?=$this->webroot?>images/icn_trash.png" title="Delete">
                                                        </a>
							    </div>
								<div class="sn_reviews">
                                <?php
										
										$user = $this->Template->getRivewUserDetails($value['Merchant_rating']['user_id']);
										$ruser = $user['Reviewed_user'];?>
										<div class="sn_reviews_section <?=$value['Merchant_rating']['id']?> <?=($value['Merchant_rating']['status']!=0)?'sn_section_active':'sn_section_inactive'?>" id="sn_reviews_section<?=$value['Merchant_rating']['id']?>">
											<div class="sn_heading">
												
												
												 <div id="ratingss_<?=$key.$key?>" class="showratings">
															<div class="star_1 ratings_stars"></div>
															<div class="star_2 ratings_stars"></div>
															<div class="star_3 ratings_stars"></div>
															<div class="star_4 ratings_stars"></div>
															<div class="star_5 ratings_stars"></div>
															<!--<div class="total_votes">vote data</div>-->
														</div>
														<script>
														  $(function(){
															 $('#ratingss_<?=$key.$key?> div').each(function(k,v){
																 var select= <?=$value['Merchant_rating']['rating']?>;
																 if(select!=undefined)
																  if(k<select)
																  {
																		$(this).prevAll().andSelf().addClass('ratings_over');
																  }

															  })
														  })
	
														</script>
											</div>
											<div style="padding:5px;color: rgb(155, 152, 152);font-size: 11px;"><b><?=$ruser['name'] ?></b>
											<div class="clearfix" style="height:5px;"></div>
											<?=$ruser['email_id'] ?>
											<div class="clearfix" style="height:5px;"></div>
											<b><?php if(!empty($value['Merchant_rating']['review_date']) && ($value['Merchant_rating']['review_date']!='0000-00-00 00:00:00'))echo date('d-m-Y H:i',strtotime($value['Merchant_rating']['review_date']));?></b>
											</div>
											<div class="sn_description">
												<?=htmlspecialchars_decode(nl2br($value['Merchant_rating']['comment']))?>
												<div class="sn_status <?=$value['Merchant_rating']['id']?> <?=($value['Merchant_rating']['status']!=0)?'sn_active':'sn_inactive'?>" id="sn_status<?=$value['Merchant_rating']['id']?>"><?=($value['Merchant_rating']['status']!=0)?'Inactive':'Active'?></div>
											</div>
										 </div>
									
							    </div>
							</div>
						<?php } ?>
							<div class="pagination-holder clearfix">
								<div id="light-pagination" class="pagination">
								
								<?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
								<!-- Shows the page numbers -->
								<?php echo $this->Paginator->numbers(array('separator' => '')); ?>
								<!-- Shows the next and previous links -->
								
								<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>
								<!-- prints X of Y, where X is current page and Y is number of pages -->
								<?php //echo $this->Paginator->counter(); ?>
								</div>
							</div>
						<?php 

					}
					else{
						echo "<center><h1>No Reviews and Ratings Available.</h1></center>";
					}?>
					   </div>
						<?php } ?>
					</div>
				</div>
					<?=$this->element('merchant/dashbord_right_sidebar')?>
				</div>
				
				
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>