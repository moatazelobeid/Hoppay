              <?php extract($merchant)?>
              <style>
              .validate label.error {
				color: #f00;
				float:right;
				}

              </style>
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
							<p style="text-align:justify;"> Data Feeds are mostly being used within the affiliate marketing. This way it is a lot easier to load thousands of product to the website. XLS and CSV file format can easily be created and loaded with any spreadsheet program .Here you can find our datafeed format, now download it and easily upload your product.</p> <br>
						
							 <center><a class="btn21" style="font-weight:normal;width:50%;float:none" href="<?=$this->webroot?>uploads/products/datafeed/BaseFeed.xls">Download the Data Feed format</a></center>

							 <hr style="clear:both;margin-top:20px;">
							 <p style="text-align:justify">If you are going to be setting up new data feed on an ongoing basis, a best practice is to develop a standard requirements specification template for new feeds and a package of support materials for partners. The package should minimally include a description of your preferred standard format for sending or receiving data, a sample, a list of fields and business rules for populating them, and a sample data file. Here you find our specifications, Please click on the below link.</p> <br>
							 <center><a class="btn21" style="font-weight:normal;width:30%;float:none" href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'DataFeedSpecification'))?>">Data Feed Specs</a></center>
                                             <hr style="clear:both;margin-top:55px;">
                           <form class="dashboardpanform validate" action="" enctype='multipart/form-data' method="POST">
                           		<fieldset>
                                    <label class="loginaddtion" >Import Your Data Feed
                                    	<small >Upload .xls or .csv only</small>
                                    </label>
                                    
                                    <input size="30" type="file" name="data_feed" required id="old_pass" class="form-text hasPlaceholder anpHintable" data-hint-num="0">
                                   
                                   
                                </fieldset>
                                
                              
                                <div class="mask" style="height:10px;"></div>
                                
                                <fieldset style="float:left;">
                                    <input type="reset" class="btn21" value="Reset" onclick="#" style="width:100px;">
                                    <input type="submit" class="btn21" value="Import" onclick="#" style="width:100px;margin:0px 5px;">
                                </fieldset>
                           </form>
							
							
							
						</div>
						
						
					
						
						
						<div class="mask" style="height:10px;"></div>
					</div>
					
					<?=$this->element('merchant/dashbord_right_sidebar')?>
				</div>
				
				<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
