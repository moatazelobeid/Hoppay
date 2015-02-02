
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
right: 391px;
width: 150px;
background: rgb(226, 225, 225);
max-height: 144px;
overflow-x: hidden;
z-index: 5;
margin-top: 29px;
}
#plist ul
{
  margin-top: -3px;
  border: 1px solid rgb(226, 225, 225);
  border-top: 0;
  padding: 0px;
}
#plist ul, #plist ul li
{
  width:100%;
  list-style: none;
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
       <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Merchant <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<!--<h4 class="alert_warning">A Warning Alert</h4>    
<h4 class="alert_error">An Error Message</h4>-->
     <?php $status=isset($this->request['url']['status'])?$this->request['url']['status']:'';
  
     // implode(":",$this->request->params['named']));
    $url = array(
           'controller' => 'admin',
           'action' => 'ratingReviews'
        );
  ?>
       
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Activated')?>" id="actived">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Inactivated')?>" id="inactive">
   <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Deleted')?>" id="delete">
    <input type="hidden" value="<?=$this->Template->CreateParamJs($url ,$this->request->params['named'],$this->request['url'],'Add to slider')?>" id="add_slider">
    
  
   
<article class="module width_full">
    <header><h3 class="tabs_involved"><?=$inner_section_name?></h3>
  <!--  <a href="<?=$this->webroot?>admin/add_merchant" class="heading_link">Add Merchant</a> -->
    </header>

     <div class="module_content listing_containt">
       <div id="stylized" class="myform search" style="width:100%">
         
 <form method="get" action="<?=$this->webroot?>admin/ratingReviews"> 
        <table style="width:50%;float:right">
          <tr>
            <td width="1%">
               <input type="text" placeholder="From Date" class="date_picker" name="from_date" id="from_date" autocomplete="off" value="<?php if(isset($this->request['url']['from_date'])){echo $this->request['url']['from_date'];}?>" style="width: 100px !important;" />
            </td>
            <td width="1%">
                <input type="text" placeholder="To Date" name="to_date" id="to_date" autocomplete="off" class="date_picker" value="<?php if(isset($this->request['url']['to_date'])){echo $this->request['url']['to_date'];}?>" style="width: 100px !important;"  />
            </td>
            <td width="2%">
              <input type="text" name="text_search" 
              value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Search Here" style="width: 120px !important;"> 
           </td>
           <td width="2%">
               <input type="text" placeholder="Product Name" name="product" autocomplete="off" id="product" value="<?php if(isset($this->request['url']['product'])){echo $this->request['url']['product'];}?>" style="width: 100px !important;" onkeyup="getProducts(this.value);"/>
               <div id="plist"></div>
           </td>
            <td width="2%">
            <select name="merchantid" style="width: 90px !important;">
              <option value="" >-- Merchant --</option>      
              <?php foreach ($merchantdetails as $key => $value) { ?> 
                 <option value="<?=$value['Merchant_login']['id']?>"  <?=$this->Template->Select(isset($this->request['url']['merchantid'])?$this->request['url']['merchantid']:"",$value['Merchant_login']['id'])?> > <?=$value['Profile']['website_name']?> </option>
              <?php } ?>
            </select> 
           </td>
            <td width="2%">
            <select name="status" style="width: 90px !important;">
              <option value="" >-- Status --</option>
              <option value="1"  <?=$this->Template->Select($status,'1')?> > Active </option>
              <option value="0"  <?=$this->Template->Select($status,'0')?>> Inactive </option>
            </select> 
           </td>
          
            <td width="12%">
        <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
               <a class="reset_button" href="<?=$this->webroot?>admin/ratingReviews" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter" id="table1" style="font-size: 12px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th width="20px"><input class="check_all" type="checkbox"></th> 
            <th width="250px">Reviews</th>
            <th width="100px"><?php echo $this->Paginator->sort('visitors', 'Ratings'); ?></th> 
            <th width="200px">Reviewer Info</th> 
            <th width="100px"><?php echo $this->Paginator->sort('product_id', 'Product Info'); ?></th>
            <th  width="100px">Merchant</th>
            <th width="100px"><?php echo $this->Paginator->sort('review_date', 'date'); ?></th>
            <th width="80px" align="center">Status</th>                      
            <th width="50px">Actions</th>
        </tr> 
      </thead> 
      <tbody> 
        <pre>
        <?php //print_r($product_review); ?>
           </pre>
         <?php if(count($product_review)<=0){ ?>
        <tr><td colspan="4"><center>No record found.</center></td><tr>
        <?php } else {?>
       <?php foreach($product_review as $key=>$val) { 

        ?>
        <tr> 
            <td>
         <?php  //print_r($val); ?>
           <input type="checkbox" data-id="<?=$val['Product_review']['id']?>" class="user_checked <?=$val['Product_review']['id']?>">
     
            </td> 

            <td>
              <b><?=strip_tags(stripslashes($val['Product_review']['title']))?></b><br>
              <?php echo strip_tags(stripslashes(nl2br($val['Product_review']['comment'])));?>

            </td> 
            <td>
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
                                 var select=  <?=strip_tags(stripslashes($val['Product_review']['rating']))?>;
                                 if(select!=undefined)
                                  if(k<select)
                                  {
                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                  }

                                })
                              })
  
                            </script>

             </td> 
            
            <td>
              <b>Name:</b> <?=strip_tags(stripslashes($val['Reviewed_user']['name']))?><br>
              <b>Email Id:</b> <?=strip_tags(stripslashes($val['Reviewed_user']['email_id']))?>

            </td>
            <td><?=ucwords(str_replace('-',' ',strip_tags(stripslashes($val['Product']['slug']))))?></td> 
            <td><?=ucwords(str_replace('-',' ',strip_tags(stripslashes(@$val['Product']['Merchant']['website_name']))))?></td> 
            <td><?=strip_tags(stripslashes($val['Product_review']['review_date']))?></td> 
            
            <td><center><?=$val['Product_review']['status']?'<p style="color:#408080">Active<p>':'<p style="color:#f01">Inactive<p>'?></center></td>
            
            <td>
            
            <a onclick="deleteAction('<?=$this->webroot?>admin/delete_reviewRatings/<?=$val['Product_review']['id']?>','<?=$menu_title?>','<?=strip_tags(stripslashes($val['Product_review']['title']))?>',false,'Are you want to delete this Reviews and Ratings?')" href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Delete"></a> 
             </td>
        </tr> 
        <?php } }?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input class="check_all" type="checkbox"><lable for="check_all">Select All</lable></td>
          <td colspan="2">
            
           </td>
            <td colspan="5">
              <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">
                    <?php 

              // Shows the next and previous links
           echo $this->Paginator->first(__('First', true), array('class' => ''));
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
              );
              echo $this->Paginator->last(__('Last', true), array('class' => ''));
              //echo $this->Paginator->counter();
              //debug($this->Paginator->params()); 
?>
                </div>
              </div>
            </td>
        </tr>
      </tfoot>
      </table>
      </div><!-- end of #tab1 -->      
      
    </div><!-- end of .tab_container -->
    
    </article>



  
 
    

 