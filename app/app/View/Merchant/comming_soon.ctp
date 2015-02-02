              <?php extract($merchant)?>
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
						
						<div class="prof_data1">
							<center><h1>Coming Soon</h1></center>
						</div>
						<div class="mask" style="height:10px;"></div>
					</div>
					
					<?=$this->element('merchant/dashbord_right_sidebar')?>
				</div>
			
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
