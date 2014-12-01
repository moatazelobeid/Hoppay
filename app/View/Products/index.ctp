
              <?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';?>
              <?php $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:'1'; ?>
               <?php $cat_id=isset($_GET['cat_id'])?$_GET['cat_id']:''; ?>
              <?php    // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'Products',
           'action' => 'index'
        );
  ?>
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'ordered')?>" id="order">
       <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
    <?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
       <h4 class="alert_success">FAQ <?=$this->request['url']['msg']?> successfully</h4>
    <?php } ?>
				<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg" style="width: 776px;margin: 0px 0px 0px 25px;">
						<h1 class="font25"><?=$text_data['title']?></h1>
						
						<div class="breadcrumbs fs12 l-hght26" style="float: left;position: relative;">
							<a class="fs12 c777 f-bold l-hght14" href="index"> Home </a> 
							<span class="breeadset">›</span>
							<span class="crm_active"><?=$text_data['title']?></span>
							<section class="clear"> </section>
						</div>
						
						<div class="borderdash"></div>
						
						<div class="clear" style="height:5px;"></div>
						
						<div class="prof_data1">

									<div class="CSSTableGenerator" >
		 <table style="width: 13%;float:left">
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
        </table>
	<form method="get" action="<?=$this->webroot?><?=$this->params['lang']?>/merchant/my-products"> 
        <table style="width:50%;float:right">
        	<tr></tr>
          <tr>
            <td width="2%">
        <input type="text" name="text_search" 
        value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Search Here"> 
           </td>
             <td width="2%">
         <?php $category=array_unique($category)?>
                     <select name="cat_id" onchange="this.form.submit();" style="width: 105px;">
                     	<option value="">--Choose Category--</option>
                        <?php 
                        foreach($category as $val){ ?>
                        <option value="<?=$val['id']?>" <?php echo $this->Template->Select($val['id'],empty($lang_id)?1:$cat_id);?>><?=$val['name']?></option>
                       <?php } 
                        ?>
                      </select>
                    
        </td>
	        <td width="2%">
	        	<select name="lang_id" onchange="this.form.submit();" style="width: 105px;">
                        <?php 
                        foreach($lang as $val){ ?>
                        <option value="<?=$val['Language']['id']?>" <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?>><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>)</option>
                       <?php } 
                        ?>
                      </select>
	        </td>
	      <td width="2%">
	        <select name="status" onchange="this.form.submit();"  style="width: 85px!important;">
	          <option value="" >-- Choose Status --</option>
	          <option value="1"  <?=$this->Template->Select($status,'1')?> > Active </option>
	          <option value="0"  <?=$this->Template->Select($status,'0')?>> Inctive </option>
	        </select> 
	       </td>
          
            <td width="7%">
        <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
            	<input type="reset" value="Reset" onclick="window.location.assign('<?=$this->webroot?>/en/merchant/my-products')">
               
           </td>
         </tr>
      </table>
  </form> 
                <table >
                    <tr>
                        <td>
                            <input class="check_all" type="checkbox">
                        </td>
                        <td >
                            <?php echo $this->Paginator->sort('id', 'Sl.'); ?> 
                        </td>
                        <td>
                           Product Info
                        </td>
                        <td>
                            Image
                        </td>
                         <td width="150">
                            Details
                        </td>
                        <td>
                            Action
                        </td>
                    </tr>
                    <?php 
                    if(!empty($product_info))
                    {
                    foreach ($product_info as $key => $value) { ?>

                    <tr>
                        <td >
                            <input type="checkbox" data-id="<?=$value['Product']['id']?>" class="user_checked <?=$value['Product']['id']?>">
                        </td>
                        <td>
                            <b><?=($key+1)?></b>
                        </td>
                        <td>
                            <h2><?=htmlspecialchars_decode($value['Product_lang']['title'])?></h2>
                            <p><?=$this->Template->summary($value['Product_lang']['description'],300)?></p>
                        </td>
                        <td>
                           <?php
                         
                           $images=json_decode($value['Product']['image_url']);
                           
                           ?>
                           <img src="<?=$images[0]?>" width="150px" alt="">
                        </td>
                        <td>
                        	<table>
                        		<tr>
                        			
                        		</tr>
                    		<tr>
	                    		<td width="60">Price</td>
	                    		<td><?=$value['Product']['price']?> <?=$value['Product']['price_type']?></td>
                        	</tr>
                        	<?php if($value['Product']['category_id']!=""){ ?>
	                        	<tr>
		                    		<td width="60">Category</td>
		                    		<td><?=htmlspecialchars_decode($value['Product']['category_id'])?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['brand']!=""){ ?>
	                        	<tr>
		                    		<td width="60">Brand</td>
		                    		<td><?=htmlspecialchars_decode($value['Product']['brand'])?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['condition']!=""){ ?>
	                        	<tr>
		                    		<td width="60">Condition</td>
		                    		<td><?=$value['Product']['condition']?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['weight']!=""){ ?>
	                        	<tr>
		                    		<td width="60">Weight</td>
		                    		<td><?=$value['Product']['weight']?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['height']!=""){ ?>
	                        	<tr>
		                    		<td width="60">Height</td>
		                    		<td><?=$value['Product']['height']?></td>
	                        	</tr>
                        	<?php } ?>

                        	<?php if($value['Product']['width']!=""){ ?>
	                        	<tr>
		                    		<td width="60">Width</td>
		                    		<td><?=$value['Product']['width']?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['isbn']!=""){ ?>
	                        	<tr>
		                    		<td width="60">isbn</td>
		                    		<td><?=$value['Product']['isbn']?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['mpn']!=""){ ?>
	                        	<tr>
		                    		<td width="60">mpn</td>
		                    		<td><?=$value['Product']['mpn']?></td>
	                        	</tr>
                        	<?php } ?>
                        	<?php if($value['Product']['upc']!=""){ ?>
	                        	<tr>
		                    		<td width="60">upc</td>
		                    		<td><?=$value['Product']['upc']?></td>
	                        	</tr>
                        	<?php } ?>
                        	</table>	


                        </td>
                        <td>
                          <a class="various10" href="<?=$this->webroot?>Products/update/<?=$value['Product']['id']?>"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"></a>
                        	<a href="<?=$this->webroot?>Products/delete/<?=$value['Product']['id']?>">   <input type="image" src="/menacompare/images/dashbord/icn_trash.png" title="Trash"></a>
                        </td>
                    </tr>

                    <?php } ?>
                     <tr>
                    	<td colspan="6">
                    		 <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">
           <?php     
             echo $this->Paginator->prev(
              '« Previous',
              null,
              null,
              array('class' => 'disabled')
            );

           echo $this->Paginator->numbers(array('separator' => ''));
            // prints X of Y, where X is current page and Y is number of pages

            echo $this->Paginator->next(
              'Next »',
              null,
              null,
              array('class' => 'disabled')
            ); ?>
                </div>
              </div>
                    	</td>
                    </tr>
               
                <?php } else{ ?>
                	<tr>
                		<td colspan="6"><span><h1>No Product Found</h1>
                      <p>Please <a href="<?=$this->Template->CreateParamLink(array(                                        
                                             'controller' => 'merchant',
                                             'action' => 'data_feed_setup'))?>">click here</a> to add your products with us.</p>
                    </span></td>
                	</tr>
               <?php }?>
                 </table>
            </div>
            
								
								
						</div>
					
				<hr style="clear:both;margin-top:55px;">
              <p style="text-align:justify;"> Data Feeds are mostly being used within the affiliate marketing. This way it is a lot easier to load thousands of product to the website. XLS and CSV file format can easily be created and loaded with any spreadsheet program .Here you can find our datafeed format, now download it and easily upload your product.</p> <br>
              <?php if(!empty($product_info))
                    { ?>
               <span><a class="btn21" style="font-weight:normal;width:50%;float:none" href="<?=$this->webroot?>merchant/my-products/download">Export your product as feed format</a></span>
               <?php }else{ ?>
                <span><a class="btn21" style="font-weight:normal;width:50%;float:none;background: #E0E0E0;
color: #000 !important;" href="javascript:void(0)">Export your product as feed format</a></span>
              <?php } ?>
				</div>
				
		<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
