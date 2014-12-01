 
<?php @extract($this->params->query);?>

<script>

$(function() {
	
	$( ".date_picker" ).datepicker({dateFormat: 'dd-mm-yy'});
	
});
 

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
    if( $(this).val()=='D')
    {
      $.post('<?=$this->webroot?>products/bulk_delete',{'ids':JSON.stringify(jsonArray),'model':'Click_track'},function(r){
          console.log(r);
		  
		  //alert(r);
          if(r==1)
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
           'controller' => 'merchant',
           'action' => 'reports'
        );
  ?>
  
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
       <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
    <?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
       <div id="msgMessage">Report <?=$this->request['url']['msg']?> successfully</div>
    <?php } ?>
				<div style="margin-top:20px;"> 
				<?=$this->element('merchant/dashbord_left_sidebar')?>
					
					<div class="prof_data_bg" style="width: 776px;margin: 0px 0px 0px 25px;">
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

									<div class="CSSTableGenerator" >
		 <table style="width: 13%;float:left">
		 	<tr></tr>
          <?php /*?><tr>
            <td> 
	            <select id="action_option" style="width:auto !important">
	            <option value="">Bulk Action</option>
	            <!--<option value="1">Active</option>
	            <option value="0">Inactive</option>-->
	            <option value="D">Delete</option>            
          </select>
        </td>
          </tr><?php */?>
        </table>
	<form method="get" action="<?=$this->webroot?><?=$this->params['lang']?>/merchant/reports"> 
        <table style="width:50%;float:right">
        	<tr></tr>
          <tr>
            <?php /*?><td width="2%">
        <input type="text" name="search" 
        value="<?=(isset($this->request['url']['search']) and ($this->request['url']['search']!=""))?$this->request['url']['search']:''?>" placeholder="Search Here"> 
           </td><?php */?>
             <td width="2%">
        		<input type="text" name="from_date" value="<?php if(isset($from_date) && ($from_date!=''))echo $from_date;?>" autocomplete="off" class="date_picker" style="width:80px;" placeholder="From Date">
        </td>
	        <td width="2%">
	        	<input type="text" name="to_date" value="<?php if(isset($to_date) && ($to_date!=''))echo $to_date;?>" autocomplete="off" class="date_picker" style="width:80px;" placeholder="To Date">
	        </td>
	      
            <td width="7%">
        <input type="submit" class="search_button" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
            	<input type="reset" value="Reset" onclick="window.location.assign('<?=$this->webroot?>/en/merchant/reports')">
               
           </td>
         </tr>
      </table>
  </form> 
                <table >
                    <tr>
                        <!--<td width="20">
                            <input class="check_all" type="checkbox">
                        </td>-->
                        <td width="21" >
                            <?php echo $this->Paginator->sort('id', 'Sl.'); ?> 
                        </td>
                        <td width="128">
                           Product Name
                        </td>
                        <td width="67">
                            Click Count
                        </td>
                         <td width="83">
                           Last Visit
                        </td>
                        <?php /*?><td width="44">
                            Action
                        </td><?php */?>
                    </tr>
                    <?php 
                    if(!empty($reports))
                    {
                    foreach ($reports as $key => $value) 
					{ 
						$ptitle = $this->template->getProductTitle($value['Click_track']['product_id']);?>

                    <tr>
                        <?php /*?><td >
                            <input type="checkbox" data-id="<?=$value['Click_track']['id']?>" class="user_checked <?=$value['Click_track']['id']?>">
                        </td><?php */?>
                        <td style="text-align:center;">
                            <b><?=($key+1)+((isset($this->params['named']['page'])?$this->params['named']['page']:1)-1)*20?></b>
                        </td>
                        <td>
                            <h2><?=htmlspecialchars_decode($ptitle)?></h2>
                        </td>
                        <td style="text-align:center;">
                           <?php
                           	echo $value[0]['click_count'];
                           ?>
                        </td>
                        <td style="text-align:center;">
                        	<?php
							if(!empty($value['Click_track']['click_time']))
							{
								echo date('Y-m-d H:i', strtotime($value['Click_track']['click_time']));	
							}
							else
							{
								echo 'N/A';	
							}
							?>		
                        </td>
                       <?php /*?> <td style="text-align:center;">
                        	<a href="<?=$this->webroot?><?=$this->Template->getLang()?>/merchant/delete_report/<?=$value['Click_track']['id']?>">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></a>
                        </td><?php */?>
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
               
                <?php } else{ }?>
                 </table>
            </div>
            
								
								
						</div>
              
				</div>
				
		<div class="clear" style="height:50px;"></div>
            </div>
			
			<div class="clear" style="height:1px;"></div>
        </div>
        
