

<?php 
echo $this->Html->css('front-end/faq');
//echo $this->Html->css('front-end/jquery-ui-1.8.24.custom');
//echo $this->Html->script('front-end/jquery-ui-1.8.24.custom.min.js');?>
<style>
/*.ui-accordion .ui-accordion-header .ui-accordion-header-icon {
position: absolute;
left: .5em;
top: 44%;
margin-top: -8px;
}*/
.ui-state-default .ui-icon {
background-image: url("<?=$this->webroot?>img/icon+.png");
background-repeat: no-repeat;
background-position: 1px -3px;

}
.ui-state-active .ui-icon {
background-image: url("<?=$this->webroot?>img/icon-.png");
background-repeat: no-repeat;
background-position: 1px -3px;

}
.ui-state-hover .ui-icon {
background-image: url("<?=$this->webroot?>img/icon-.png");
background-repeat: no-repeat;
background-position: 1px -3px;

}

</style>
<script type="text/javascript">

$(document).ready(function(){
//$(".ui-accordion-content-active").css('height','300px');
});
		/*$(function(){

			// Accordion
			//$("#accordion").accordion({ header: "h3", autoHeight: false });
			$( "#accordion" ).accordion({
				 autoHeight: false,
				navigation: false,
				collapsible: false,
				active: false
			});
			
		});*/
	</script>	


<div class="wrapper" style="min-height: 500px;margin-top: 4em;">
					<div class="rowpanel3 leftpatern_MrT new_tag3" style="text-align:center;">
               		<h1><?=$page_data['Page_lang'][0]['pg_title']?></h1>
					<p>
						<?=htmlspecialchars_decode($page_data['Page_lang'][0]['pg_descriptions'])?>
					</p>
					
					
					<div class="clear" style="height:15px;"></div>
                    <div class="shadow2">&nbsp;</div>
					<div class="clear" style="height:15px;"></div>
					
					
					<div class="leftfaqpan">
                        <div id="accordion">
                        	<?php if(!empty($faqs))
							{
								foreach($faqs as $faq)
								{
									if(!empty($faq['Faq_lang']))
									{?>
										<h3>
											<a href="#" id="four">
											<div class="tableHead" id="techSpec">
											   <?php echo stripslashes($faq['Faq_lang'][0]['question']);?>
											</div>
											  <div class="clear"></div>
											</a>
										</h3>
										<div>
											<div class="talign">
												<?php echo htmlspecialchars_decode(stripslashes($faq['Faq_lang'][0]['answer']));?>
											</div>
										</div>
								<?php }
									}
								}
								else
								{
									echo 'No FAQ found!';
								}?>
                        </div>
					</div>
                    
                    
                    <div class="leftfaqpan2">
                    	<?php if(!empty($faq_categories))
						{?>
                            <div class="leftfaqpan2_inner">
                                <h1>FAQ Catagories</h1>
                                <ul>
                                <?php foreach($faq_categories as $faq_category)
								{?>
                                    <li>
										<?php 
										$fqcatname = stripslashes($faq_category['Faq_category_lang'][0]['category_name']);
										$fqcatid = $faq_category['Faq_category']['slug'];
										if($faqcatid == $faq_category['Faq_category']['slug'])
										{
											echo $this->Html->link($fqcatname,array('controller' => 'merchant','action' => 'faq/'.$fqcatid,'full_base' => true), array('style'=>'color:#227EE2'));
										}
										else
										{
											echo $this->Html->link($fqcatname,array('controller' => 'merchant','action' => 'faq/'.$fqcatid,'full_base' => true));
										}?>
									</li>
                                <?php }?>
                                </ul>
                            </div>
                            
                            <div class="clear" style="height:15px;"></div>
                        <?php }?>
                        
                        <!--<div class="leftfaqpan2_inner">
                        	<h1>Help Center</h1>
                        	<ul>
                                <li><a href="#">Hints &amp; Tips</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>-->
                    </div>			
                    
                    
                    
                    </div>	
                    		
                    </div>			
                    
               
               
                
            </div>
        </div>
        
        </div>
        
        <!--  Main Body Panel End  -->
        
        <div class="clear" style="height:0px;">&nbsp;</div>
					

               
				