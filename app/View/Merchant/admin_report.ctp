
<script type="text/javascript">
function print(){
$('#PrintCLass').print();
}
</script>
<article class="module width_full">
      <header><h3>Merchant Reports</h3> <a href="<?=$this->webroot?>admin/merchants" class="heading_link heading_link top_backup_button" >View all Merchants</a></header>
      <div class="module_content">
       
        
        <article class="stats_overview">
          <div class="overview_today">
            <p class="overview_day">Merchants</p>
            <p class="overview_count"><a href="<?=$this->webroot?>admin/merchants?status=1&search=Search"><?=$activeMerchant?></a></p>
            <p class="overview_type">Active</p>
            <p class="overview_count"><a href="<?=$this->webroot?>admin/merchants?status=0&search=Search"><?=$inactiveMerchant?></a></p>
            <p class="overview_type">Inactive</p>
            <p class="overview_count"><a href="<?=$this->webroot?>admin/merchants"><?=$totalMerchant?></a></p>
            <p class="overview_type">Total</p>

          </div>
          <?php 
               $star5Merchnat=isset($star5Merchnat)?$star5Merchnat:0; 
               $star4Merchnat=isset($star4Merchnat)?$star4Merchnat:0;
          ?>
          <div class="overview_previous">
            <p class="overview_day">Popular Merchant</p>
            <p class="overview_count"><?=$star5Merchnat?></p>
            <p class="overview_type">5 Star</p>
            <p class="overview_count"><?=$star4Merchnat?></p>
            <p class="overview_type">4 Star</p>
            <p class="overview_count"><?=($star5Merchnat+$star4Merchnat)?></p>
            <p class="overview_type">Total</p>
          </div>
           
        </article>
         <article class="stats_overview">
          <h3>Top 5 Merchants</h3>
            <table class="tablesorter" cellspacing="0"> 
      <thead> 
        <tr> 
            
            <th width="100">Merchant Name</th> 
            <th>Image</th>  
            <th>Total Product</th>           
            <th>View Details</th> 
        </tr> 
      </thead> 
      <tbody> 
        <?php foreach ($top5 as $key => $value) { 
          if($key>5)
          {
            break;
          }
          ?>

        <tr> 
            
            <td><?=$value['Merchant']['website_name']?></td> 
            <td>
              <?php if($value['Merchant']['image_url']!="") {?>
               <img src="<?=$this->webroot?><?=$value['Merchant']['image_url']?>" alt="<?=$value['Merchant']['website_name']?>" height ="30" />
              <?php } ?>    
              </td>
              <td align="center"><?=$value[0]['productCount']?></td>    
          <td align="center">
            <a href="<?=$this->webroot?>admin/merchant/report/view/<?=$value['Merchant']['id']?>">
            <input type="image" src="<?=$this->webroot?>images/dashbord/icn_categories.png" 
                title="View Details">
            </a>
          </td> 
        </tr> 
        <?php }?>
         
       
      </tbody> 
      </table>
        </article>
        <div class="clear"></div>
      </div>
    </article>
    <?php if(isset($indvMerchantReport) and !empty($indvMerchantReport)){?>
    <div id="PrintCLass">
      <style type="text/css">
  .showratings {
overflow: visible;
padding: 5px 0px;
position: relative;
width: 75px;
height: 20px;
display: inline;
float: left;
margin-top: -6px;
}
</style>
      <link rel="stylesheet" type="text/css" href="<?=$this->webroot?>css/layout.css">
      <link rel="stylesheet" type="text/css" href="<?=$this->webroot?>rating/rating.css">
    <article class="module width_full"> 
      <header><h3>Individual Merchant Details</h3>
        <a href="javascript:void(0)" class="heading_link heading_link top_backup_button" onclick="print()">Print</a>
      </header>
      <div class="module_content">
        <?php if($indvMerchantReport['User']['status']==0){ ?>
            <h4 class="alert_warning">This Merchant is not activate till now. <a class="right report_link" href="">[Report to Merchant]</a></h4>
        <?php } ?>
        <article class="module width_half">
           <header><h3>Porsional Info</h3></header>
            <div class="details_info">
              <p><b>Website Url:</b> <?=$indvMerchantReport['Merchant']['url']?></p>
              <p><b>Website Name:</b> <?=ucwords($indvMerchantReport['Merchant']['website_name'])?></p>
              <hr>
              <p><b>Name:</b> <?=$indvMerchantReport['Merchant']['first_name']?> <?=$indvMerchantReport['Merchant']['last_name']?></p>
              <p><b>Email Id:</b> <?=$indvMerchantReport['User']['email_id']?></p>
              <p><b>Phone Number:</b> <?=$indvMerchantReport['Merchant']['phone']?></p>
            </div>
        </article>
        <article class="module width_half">
           <header><h3>Contact Info</h3></header>
           <div class="details_info">
              <p><b>Address:</b> <?=$indvMerchantReport['Merchant']['adress']?></p>
              <p><b>City:</b> <?=$indvMerchantReport['Merchant']['city']?></p>             
              <p><b>State/Province:</b> <?=$indvMerchantReport['Merchant']['state']?> </p>
              <p><b>Zip code:</b> <?=$indvMerchantReport['Merchant']['zip_code']?></p>
              <p><b>Country:</b> <?=$indvMerchantReport['Merchant']['country']?></p>
            </div>
        </article>
        <div class="clear"></div>
        <article class="module width_half">
           <header><h3>Login Info</h3></header>
           <div class="details_info">
              <p><b>User id:</b> <?=$indvMerchantReport['User']['username']?></p>
              <p><b>Join Date:</b> <?=date('l jS \of F Y',strtotime($indvMerchantReport['User']['created_date']))?></p>             
              <p><b>Last login:</b> <?=date('l jS \of F Y h:i:s A',strtotime($indvMerchantReport['User']['last_login']))?> </p>
             
            </div>
        </article>

        <article class="module width_half">
           <header><h3>Store Info</h3></header>
            <?php if(!empty($indvMerchantReport['Product_store'])){ ?>
           <div class="details_info">
              <p><b>Contact Name:</b> <?=ucwords($indvMerchantReport['Product_store']['contact_name'])?></p>
              <p><b>Contact email:</b> <?=$indvMerchantReport['Product_store']['contact_email']?></p>             
              <p><b>Contact Ph.:</b> <?=$indvMerchantReport['Product_store']['contact_phone']?> </p>
              <p>
                <b>Shipping Details:</b> <?=$indvMerchantReport['Product_store']['shipping_details']?>
              </p>
               <?php $payment=json_decode($indvMerchantReport['Product_store']['payment_details'],true)?>
               <?php if(!empty($payment)){?>
              
              <p>
               

                <b>Payment Details:</b>  <?=ucwords(implode(', ',array_keys($payment)))?>
              </p>
               <?php }?>
               <?php $social_links=json_decode(stripslashes($indvMerchantReport['Product_store']['social_links']),true);
               $sdata=array_values($social_links);
               $sdata=array_filter($sdata);
                
               ?>
               <?php if(!empty($sdata)){?>
              <p>
                <b>Social links:</b> <?=trim(implode(', ',array_values($social_links)))?>
              </p>
               <?php }?>
            </div>
             <?php }else{
              echo "<center>No store Information is Available</center>";
             }?>
        </article>

 <div class="clear"></div>
      <article class="module width_half">
        <header><h3>Product Info</h3></header>
          <div class="module_content">
              
                  <div class="details_info">
                    <p><b>Total:</b> <?=$indvMerchantReport[0]['prodTotCount']?></p>
                    <p><b>Active Products:</b> <?=$indvMerchantReport[0]['activeProd']?></p>
                    <p><b>Inactive Products:</b> <?=$indvMerchantReport[0]['inactiveProd']?></p>
                    <p><b>Ratings:</b> 
                    
                     <div id="ratingss" class="showratings">
                        <div class="star_1 ratings_stars"></div>
                        <div class="star_2 ratings_stars"></div>
                        <div class="star_3 ratings_stars"></div>
                        <div class="star_4 ratings_stars"></div>
                        <div class="star_5 ratings_stars"></div>    
                     </div>
                            <script>
                              $(function(){
                               $('#ratingss div').each(function(k,v){
                                 var select=<?=$indvMerchantReport[0]['ratings']?>;
                                 if(select!=undefined)
                                  if(k<select)
                                  {
                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                  }

                                })
                              })
  
                            </script>
                   (<?=$indvMerchantReport[0]['totRev']?> Review/s)</p>
                  </div> 
            
        
        </div>
      </article>
     <article class="module width_half">
        <header><h3>Top 5 Product</h3></header>
          <div class="module_content">
            <table class="tablesorter" cellspacing="0"> 
      <thead> 
        <tr>             
            <th width="100">Product Name</th> 
            <th>Image</th>  
            <th>Ratings</th>           
            <th>View Details</th> 
        </tr> 
      </thead> 
      <tbody> 

        <?php 
        if(!empty($indvMerchantprod))
        {
        foreach ($indvMerchantprod as $key => $value) { 
          if($key>5)
          {
            break;
          }
          if($value[0]['ratings']<3)
          {
            break;
          }
          ?>

        <tr> 
           
            <td><?=ucwords($value['Product_lang'][0]['title'])?></td> 
            <td>

              <?php 
             $prodimg= json_decode(stripslashes($value['Product']['image_url']));
              if(!empty($prodimg)) {?>
               <img src="<?=$prodimg[0]?>" alt="<?=ucwords($value['Product_lang'][0]['title'])?>" height ="30" />
              <?php } ?>    
              </td>
              <td align="center">  <div id="ratingss_<?=$key.$key?>" class="showratings">
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
                                 var select=  <?=strip_tags(stripslashes($value[0]['ratings']))?>;
                                 if(select!=undefined)
                                  if(k<select)
                                  {
                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                  }

                                })
                              })
  
                            </script></td>    
          <td align="center">
            <a href="<?=$this->webroot?>admin/products/report/view/<?=$value['Product']['id']?>">
            <input type="image" src="<?=$this->webroot?>images/dashbord/icn_categories.png" 
                title="View Details">

            </a>
          </td> 
        </tr> 
        <?php }}
        else
        { ?>
            <tr><td colspan="4"><center>No Product Found</center></td> </tr>
        <?php }
        ?>
         
       
      </tbody> 
      </table>
    </div>
        </article>
    <div class="clear"></div>
      </div>
    </article>
    <div>
    <?php } else if(isset($indvMerchantReport) and empty($indvMerchantReport)  ){?>
    <article class="module width_full">
      <header><h3>Individual Merchant Details</h3></header>
        <div class="not_active_message"> This Merchant is not activate till now.</a>
      <div class="clear"></div>
      </div>
    </article>

    <?php }?>

