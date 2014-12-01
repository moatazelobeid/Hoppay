
<?php @extract($this->params->query);?>

<style>
#product_list
{
	height:auto;
	max-height: 200px;
	position: absolute;
	width: 206px;
	background: rgb(197, 195, 195);
	text-align: left;
	top: 37px;
	left: 4px;
	overflow-x: hidden;
	line-height: 20px;	
	/*border: 1px solid gray;*/
	border-top: 0;
}
#product_list ul
{
	padding-left:0px;
	margin: 0px;
}
#product_list ul li
{
	list-style:none;
	cursor:pointer;
	padding:3px 3px 3px 5px;
}
#product_list ul li:hover
{
	background:#FFFFFF;
	color:#000;
}
</style>

<script>

$(function() {
	
	$( ".date_picker" ).datepicker({dateFormat: 'dd-mm-yy'});
	
});
 
function getProductList(pname)
{
	//alert(pname);
	if(pname!= '')
	{
		var url = '<?=$this->webroot?>admin/getProductList/'+pname;
		$.get(url, function(data)
		{
			
			//alert(data);
			$('#product_list').html(data);	
			$('#product_list').css('border','1px solid gray');
			
		});	
	}
	else
	{
		$('#product_list').html('');
		$('#product_list').css('border','none');
		$('#product_id').val('');	
	}
}

function selectProduct(pid,pname)
{
	$('#product_id').val(pid);
	$('#product').val(pname);
	$('#product_list').html('');
	$('#product_list').css('border','none');		
	$('#search_form').submit();
}
function pdfReport()
{
	$('#todo').val('pdf');
	$('#search_form').submit();
}
function exportExcel()
{
	$('#todo').val('export');
	$('#search_form').submit();
}
</script>   
<article class="module width_full">
    <header><h3 class="tabs_involved">Click Track Report</h3>
    
    </header>

     <div class="module_content listing_containt">
       <div id="stylized" class="myform search" style="width:100%">
        <table style="width:30%;float:left">
          <tr>
            <td> 
              <!--<select id="action_option" style="width:auto !important">
              <option value="">Bulk Action</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
            <option value="D">Delete</option>            
          </select>-->
        </td>
          </tr>
        </table>
 <form method="get" action="<?=$this->webroot?>admin/click_track" name="search_form" id="search_form"> 
 		<input type="hidden" name="todo" value="" id="todo"  />
        <table style="width:50%;float:right">
          <tr>
            <td width="2%" style="position:relative;">
              <?php /*?><select name="product_id" onchange="this.form.submit();" style="width: 130px;">
                  <option value="">--Select Product--</option>
                    <?php if(!empty($products))
                    {
                        foreach($products as $key=>$val) 
                        {?> 
                            <option value="<?=$val['Product']['id']?>" <?php echo $this->Template->Select($val['Product']['id'],empty($product_id)?"":$product_id);?>><?=stripslashes($val['Product_lang']['title'])?></option>
                   <?php } 
                    }
                    ?>
              </select><?php */?>
              <input type="text" name="product" id="product" value="<?=(isset($product) and ($product!=""))?$product:''?>" placeholder="Search Product" autocomplete="off" onKeyUp="getProductList(this.value);" />
              <div id="product_list"></div>
              <input type="hidden" name="product_id" id="product_id" value="<?=(isset($product_id) and ($product_id!=""))?$product_id:''?>" />
           </td>
            <td width="2%">
         
          <select name="merchant_id" onchange="this.form.submit();" style="width: 130px;">
              <option value="">--Select Merchant--</option>
                <?php if(!empty($merchants))
				{
					foreach($merchants as $key=>$val) 
					{?> 
                		<option value="<?=$val['Merchant']['id']?>" <?php echo $this->Template->Select($val['Merchant']['id'],empty($merchant_id)?"":$merchant_id);?>><?=stripslashes($val['Merchant']['first_name']).' '.stripslashes($val['Merchant']['last_name'])?></option>
               <?php } 
				}
                ?>
          </select>
                    
        </td>
            <td width="2%">
           
        		<input type="text" name="from_date" value="<?php if(isset($from_date) && ($from_date!=''))echo $from_date;?>" autocomplete="off" class="date_picker" style="width:100px !important;" placeholder="From Date">
           </td>
           <td width="2%">
         
	        	<input type="text" name="to_date" value="<?php if(isset($to_date) && ($to_date!=''))echo $to_date;?>" autocomplete="off" class="date_picker" style="width:100px !important;" placeholder="To Date">
        </td>
            <td width="12%">
        <input type="submit" class="search_button" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
               <a class="reset_button" href="<?=$this->webroot?>admin/click_track" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter ordered" id="" style="font-size: 14px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <?php /*?><th width="20px"><input class="check_all" type="checkbox"></th> <?php */?>
            <th width="400">Product Name</th>            
           
            <th width="200">Merchant Name</th> 
            <th align="" width="100"><center><?php //echo $this->Paginator->sort('0.click_count', 'Click Count'); ?>Click Count</center></th> 
            <th align="center"><?php echo $this->Paginator->sort('Click_track.click_time', 'Last Visit'); ?></th>             
        </tr> 
      </thead> 
      <tbody> 
         <?php 
         echo "<pre>";
       //print_r($reports);
          echo "</pre>";
         if(count($reports)<=0){ ?>
        <tr><td colspan="7"><center>No record found.</center></td><tr>
        <?php } else {?>
       <?php 
	   $total_click = 0;
	   foreach($reports as $key=>$val) 
	   { 
	   	$ptitle = $this->template->getProductTitle($val['Click_track']['product_id']);
		$mname = $this->template->getMerchantName($val['Click_track']['merchant_id']);
		
		if($ptitle!='')
		{
			$total_click = $total_click+$val['0']['click_count'];?>
        <tr> 
            <?php /*?><td>
           <input type="checkbox" data-id="<?=$val['Faq']['id']?>" class="user_checked <?=$val['Faq']['id']?>">
            </td> <?php */?>
            <td><p><?=htmlspecialchars_decode($ptitle)?></p></td> 
            
            
            <td><?=htmlspecialchars_decode($mname)?></td> 
            <td><center><?=$val['0']['click_count']?></center></td>            
            <td>
            	<center>
					<?php
                    if(!empty($val['Click_track']['click_time']))
                    {
                        echo date('Y-m-d H:i', strtotime($val['Click_track']['click_time']));	
                    }
                    else
                    {
                        echo 'N/A';	
                    }
                    ?>		
            	</center>
            </td> 
            
        </tr> 
        <?php }
		} 
			if($total_click==0)
			{
				?>
                <tr><td colspan="7"><center>No record found.</center></td><tr>
                <?php 
			}
		}?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2">
              <input type="button" value="Export To Excel" onclick="exportExcel();">
              <input type="button" value="PDF Download" onclick="pdfReport();">
          </td>
          <td align="left" style="font-weight:bold;">
			<?php if(!empty($merchant_id) && !empty($reports) && ($total_click>0))
            {
            	echo 'Total clicks: '.$total_click;
            }?>
            </td>
            <td>
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
      </tfoot>
      </table>
      </div><!-- end of #tab1 -->
           
    </div><!-- end of .tab_container -->
    
    </article>



  
 
    

 