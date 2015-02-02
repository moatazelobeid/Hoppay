
<script type="text/javascript">
function print(){
$('#PrintCLass,.inner_report_content').print();
}
</script>
<article class="module width_full">
      <header><h3>Products Reports</h3></header>
      <div class="module_content">  
       <article class="stats_overview">
          <div class="overview_today">
            <p class="overview_day">Products</p>
            <p class="overview_count"><?=$activeProd?></p>
            <p class="overview_type">Active</p>
            <p class="overview_count"><?=$inactiveProd?></p>
            <p class="overview_type">Inactive</p>
            <p class="overview_count"><?=$totalProd?></p>
             <p class="overview_type">Total</p>
          </div>
         <div class="overview_previous">
            <p class="overview_day">Popular Products</p>
            <p class="overview_count"><?=$star5Prod?></p>
            <p class="overview_type">5 Star</p>
            <p class="overview_count"><?=$star4Prod?></p>
            <p class="overview_type">4 Star</p>
            <p class="overview_count"><?=($star5Prod+$star4Prod)?></p>
            <p class="overview_type">Total</p>            
          </div>         
        </article>
         <article class="stats_overview">
          <h3>Top 5 Products</h3>
             <table class="tablesorter" cellspacing="0"> 
      <thead> 
        <tr>             
            <th width="100">Product Name</th> 
            <th>Image</th>  
            <th>Ratings</th>   
            <th>Merchant</th>        
            <th>View Details</th> 
        </tr> 
      </thead> 
      <tbody> 
        <?php foreach ($top5 as $key => $value) { 
          
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
                            <td>
                              <a href="<?=$this->webroot?>admin/merchant/report/view/<?=$value['Merchant']['id']?>"><?=$value['Merchant']['website_name']?></a>
                            </td>  
          <td align="center">
            <a href="<?=$this->webroot?>admin/products/report/view/<?=$value['Product']['id']?>">
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


     <?php if(isset($indiVProdDetails) and !empty($indiVProdDetails)){?>
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
      <header><h3>Product Details</h3>
        <a href="javascript:void(0)" class="heading_link heading_link top_backup_button" onclick="print()">Print</a>
      </header>
      <div class="module_content">
        <?php if($indiVProdDetails['Product']['status']==0){ ?>
            <h4 class="alert_warning">This Product is not activate till now. <a class="right report_link" href="">[Report to Merchant]</a></h4>
        <?php }
        if($indiVProdDetails['Product']['category_id']==""){ ?>
          <h4 class="alert_warning">This Product category is not Set till now. <a class="right report_link" href="">[Report to Merchant]</a></h4>
        <?php } 
        if($indiVProdDetails['Product']['brand']==""){ ?>
          <h4 class="alert_warning">This Product Brand is not Set till now. <a class="right report_link" href="">[Report to Merchant]</a></h4>
        <?php } ?>
        <article class="module width_half">
           <header><h3>Basic Product Info</h3></header>
            <div class="details_info">
              <p><b>Title:</b> <?=$indiVProdDetails['Product_lang'][0]['title']?></p>
              <p><b>Descriptions:</b> <?=htmlspecialchars_decode($indiVProdDetails['Product_lang'][0]['description'])?></p>
              <hr>
              <p><b>Category:</b> <?=$indiVProdDetails[0]['catName']?></p>
              <p><b>Brand Name:</b> <?=$indiVProdDetails[0]['barndName']?></p>
              <p><b>Price:</b> <?=$this->Template->getPriceFormat($indiVProdDetails['Product']['price'])?></p>
              <p><b>Product URL:</b> 
                <?=stripslashes($indiVProdDetails['Product']['product_url'])?>
              </p>
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
                                 var select=<?=$indiVProdDetails[0]['ratings']?>;
                                 if(select!=undefined)
                                  if(k<select)
                                  {
                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                  }

                                })
                              })
  
                            </script>
                   (<?=$indiVProdDetails[0]['totRev']?> Review/s)
                   <?php if($indiVProdDetails[0]['totRev']!=0){ ?>
                   [<a href="<?=$this->webroot?>admin/ratingReviews?product=<?=str_replace('-','+',$indiVProdDetails['Product']['slug'])?>">View all Reviews and Ratings</a>]
                   <?php } ?>
                 </p>
              <hr>
              <p><b style="display:block;padding:5px 0;">Product Images:</b> 
                <?php $images=json_decode(stripslashes($indiVProdDetails['Product']['image_url']),true);
                  foreach ($images as $key => $value) { ?>
                    <img src="<?=$value?>" alt="<?=$indiVProdDetails['Product_lang'][0]['title']?>"  height="70"/>
                 <?php }

                ?>
              </p>
            </div>
        </article>
        <article class="module width_half">
           <header><h3>Product Details</h3></header>
           <div class="details_info">
              <p><b>UPC:</b> <?=$indiVProdDetails['Product']['upc']?$indiVProdDetails['Product']['upc']:'N/A'?></p>
              <p><b>MPN:</b> <?=$indiVProdDetails['Product']['mpn']?$indiVProdDetails['Product']['mpn']:'N/A'?></p>             
              <p><b>ISBN:</b><?=$indiVProdDetails['Product']['isbn']?$indiVProdDetails['Product']['isbn']:'N/A'?> </p>
              <hr>
              <p><b>Weight:</b> <?=$indiVProdDetails['Product']['weight']?$indiVProdDetails['Product']['weight']." Kg":'N/A'?></p>
              <p><b>Height:</b> <?=$indiVProdDetails['Product']['height']?$indiVProdDetails['Product']['height']." Cm":'N/A'?></p>
              <p><b>Width:</b> <?=$indiVProdDetails['Product']['width']?$indiVProdDetails['Product']['width']." Cm":'N/A'?></p>
              <p><b>Quantity:</b> <?=$indiVProdDetails['Product']['quantity']?$indiVProdDetails['Product']['quantity']:'N/A'?></p>
            </div>
        </article>

        <article class="module width_half">
           <header><h3>Offers For this Product</h3></header>
            <?php if(!empty($indiVProdDetails['Offer']['id'])){ ?>
              <?php if($indiVProdDetails['Offer']['status']==0){?>
                <h4 class="alert_warning">This Offer was deactivated.</h4>
            <?php } ?>
            <?php if($indiVProdDetails['Offer']['end_date'] > date('Y-m-d') and ($indiVProdDetails['Offer']['end_date']!="")){?>
                <h4 class="alert_warning">This Offer was out dated. </h4>
            <?php } ?>
           <div class="details_info">
          
              <p><b>Offer Name:</b> <?=ucwords($indiVProdDetails['Offer']['offer_title'])?></p>
              <p><b>Offer Type:</b> <?=ucwords($indiVProdDetails['Offer']['offer_type']==1?"Discount":"Promo Code")?></p> 
              <p><b>Discount (%):</b> <?=$indiVProdDetails['Offer']['discount']." %"?></p>

            
            </div>
             <?php }else{
              echo "<center>No Offer Information is Available</center>";
             }?>
        </article>
        <div class="clear"></div>
        <article class="module width_half">
           <header><h3>Additional Product Info</h3></header>
           <div class="details_info">
            <?php 
           $addData=json_decode(htmlspecialchars_decode($indiVProdDetails['Product_lang'][0]['product_details']));
           if($addData!="")
           {
            foreach ($addData as $key => $value) {
            ?>
              <p><b><?=$key?> : </b> <?=$value?></p>
            <?php } } else {?>
              No Additional Details Are Found.
            <?php } ?>
             
             
            </div>
        </article>

        <article class="module width_half">
           <header><h3>Merchant Information</h3> <a class="heading_link" href="<?=$this->webroot?>admin/merchant/report/view/<?=$indiVProdDetails['Merchant']['id']?>">View Merchant Report</a></header>
            <?php if(!empty($indiVProdDetails['Merchant']['id'])){ ?>
           <div class="details_info">
              <p><b>Merchant Name:</b> <?=ucwords($indiVProdDetails['Merchant']['website_name'])?></p>
              <p><b>Merchant URL: </b> <?=$indiVProdDetails['Merchant']['url']?></p>             
              <p><b style="float: left;margin-top: 15px;">Merchant Logo:</b> <img src="<?=$this->webroot?><?=$indiVProdDetails['Merchant']['image_url']?>" height="50" /> </p>
              <hr>
             <?php if(!empty($merchant)){ ?>
              <b style="color: #E0832C;"> <?=count($merchant)?> More Merchant with same product</b>  
              <br><br>
 <table class="tablesorter" cellspacing="0"> 
      <thead> 
        <tr> 
            
            <th width="100">Merchant Name</th> 
            <th>Image</th>  
                     
            <th width="100">View Details</th> 
        </tr> 
      </thead> 
      <tbody> 
        <?php foreach ($merchant as $key => $value) { 
         
          ?>

        <tr> 
            
            <td><?=$value['Merchant']['website_name']?></td> 
            <td>
              <?php if($value['Merchant']['image_url']!="") {?>
               <img src="<?=$this->webroot?><?=$value['Merchant']['image_url']?>" alt="<?=$value['Merchant']['website_name']?>" height ="30" />
              <?php } ?>    
              </td>
                 
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
      <br><br>
             <?php } ?>
              
            </div>
             <?php }else{
              echo "<center>No Merchant Information is Available</center>";
             }?>
        </article>

 <div class="clear"></div>
     
      </div>
    </article>
    <div>
    <?php } else if(isset($indiVProdDetails) and empty($indiVProdDetails)  ){?>
    <article class="module width_full">
      <header><h3>Individual Merchant Details</h3></header>
        <div class="not_active_message"> This Merchant is not activate till now.</a>
      <div class="clear"></div>
      </div>
    </article>

    <?php }else{
      ?>
      <div class="report_content">
        <div class="report_heading"><b>All Product Report</b>  <a href="javascript:void(0)" class="heading_link heading_link top_backup_button" onclick="print()">Print</a></div>
        <div class="filtaration_section">
          <form action="<?=$this->webroot?>/admin/products/report">
            <input type="text" name="fdate" value="<?php if(isset($this->request['url']['fdate'])){echo $this->request['url']['fdate'];}?>" class="date_picker" placeholder="From date">

            <input type="text" name="endate"  value="<?php if(isset($this->request['url']['endate'])){echo $this->request['url']['endate'];}?>" class="date_picker" placeholder="To date"> 
            <select name="merchants" onchange="this.form.submit();">
              <option value="">--Choose Merchnat--</option>
              <?php foreach ($merchants as $key => $value) { ?>
                <option value="<?=$value['User']['id']?>" <?=$this->Template->Select(isset($this->request['url']['merchants'])?$this->request['url']['merchants']:"",$value['User']['id'])?> ><?=$value['Profile']['website_name']?></option>            
              <?php } ?>
              
            </select>
           <select name="categories" onchange="this.form.submit();">
              <option value="">--Choose Departments--</option>
              <?php foreach ($categories as $key => $value) { ?>
                <option value="<?=$value['Product_category']['id']?>" <?=$this->Template->Select(isset($this->request['url']['categories'])?$this->request['url']['categories']:"",$value['Product_category']['id'])?>><?=$value['Product_category_lang']['category_name']?></option>
              <?php } ?>
              
             
            </select>
            <select name="rating" onchange="this.form.submit();">
              <option value="">--Choose Ratings--</option>
              <option value="5" <?=$this->Template->Select(isset($this->request['url']['rating'])?$this->request['url']['rating']:"",5)?>>5 Star</option>
              <option value="4" <?=$this->Template->Select(isset($this->request['url']['rating'])?$this->request['url']['rating']:"",4)?>>4 Star</option>
              <option value="3" <?=$this->Template->Select(isset($this->request['url']['rating'])?$this->request['url']['rating']:"",3)?> >3 Star</option>
              <option value="2" <?=$this->Template->Select(isset($this->request['url']['rating'])?$this->request['url']['rating']:"",2)?>>2 Star</option>
              <option value="1" <?=$this->Template->Select(isset($this->request['url']['rating'])?$this->request['url']['rating']:"",1)?>>1 Star</option>
              <option value="0" <?=$this->Template->Select($this->request['url']['rating'],'0')?> >No Star</option>
            </select>
            <select name="limit" onchange="this.form.submit();" >
              <option value="">--Choose limit--</option>
                <?php 
                  for($i=10;$i<=$countProducts;$i+=10){
                ?>
                  <option value="<?=$i?>" <?=$this->Template->Select(isset($this->request['url']['limit'])?$this->request['url']['limit']:"",$i)?>><?=$i?></option>
                <?php
                 
                  } 
                ?>       
             
              <option value="all" <?=$this->Template->Select(isset($this->request['url']['limit'])?$this->request['url']['limit']:"",'all')?>>all</option>              
            </select>
            <input type="submit" value="Submit" name="filter">
             <a class="reset_button" href="<?=$this->webroot?>admin/products/report" class="reset">Reset</a> 
          </form>
        </div>
        <div class="inner_report_content">
          <link rel="stylesheet" type="text/css" href="<?=$this->webroot?>css/layout.css">
      <link rel="stylesheet" type="text/css" href="<?=$this->webroot?>rating/rating.css">


      <style>
        @media print {
          table{
            border:1px solid #666;
          }
          table thead tr th:last-child{ 
             display: none!important;
            }
           table tbody tr td:last-child,.pagination_section{
               display: none!important;
            }
            .print_rat{
              display: block;
            }
        }
      </style>

          <table cellspacing="0">
            <thead>
              <tr>
                <th width="50" align="center"><?php echo $this->Paginator->sort('id', 'Sno.'); ?></th>
                <th>Product Name</th>
                <th>Department</th>
                <th>Merchant Name </th>
                <th>Ratings (Reviews)</th>  
                <th>No. of views </th>
                <th>View Details</th>          
              </tr>
            </thead>
            <tbody>
              <?php
              //print_r($products);
               if(empty($products)){ ?>
                <tr>
                  <td colspan="7"><center>No Product Found</center></td>
                </tr>
              <?php } else{
                $id=0;
                foreach ($products as $key => $val) {

                  
                  ?>
                  <tr>
                    <td align="center"><b><?=($key+1)+((isset($this->params['named']['page'])?$this->params['named']['page']:1)-1)*20?></b></td>
                    <td><?=$val['Product_lang'][0]['title']?></td>
                    <td><?=$val[0]['catName']?></td>
                    <td>
                      <?=$val['Merchant']['website_name']?><br>
                      <?php if($val['Merchant']['image_url']!="") {?>
               <img src="<?=$this->webroot?><?=$val['Merchant']['image_url']?>" alt="<?=$val['Merchant']['website_name']?>" height ="30" />
              <?php } ?>    
                    </td>
                    <td><div id="ratingsss_<?=$key.$key?>" class="showratings">
                              <div class="star_1 ratings_stars"></div>
                              <div class="star_2 ratings_stars"></div>
                              <div class="star_3 ratings_stars"></div>
                              <div class="star_4 ratings_stars"></div>
                              <div class="star_5 ratings_stars"></div>
                              <!--<div class="total_votes">vote data</div>-->
                            </div>
                            <script>
                              $(function(){
                               $('#ratingsss_<?=$key.$key?> div').each(function(k,v){
                                 var select=<?=strip_tags(stripslashes($val[0]['ratings']?$val[0]['ratings']:0))?>;
                                 if(select!=undefined)
                                  if(k<select)
                                  {
                                    $(this).prevAll().andSelf().addClass('ratings_over');
                                  }

                                })
                              })
  
                            </script><span class="print_rat"><?=strip_tags(stripslashes($val[0]['ratings']?$val[0]['ratings']:0))?> Stars</span><span>(<?=$val[0]['totRev']?> Review/s)</span></td>
                    <td><?=$val[0]['uniqueVisitoCount']?$val[0]['uniqueVisitoCount']:0?></td>
                    <td align="center"> 
                      <a href="<?=$this->webroot?>admin/products/report/view/<?=$val['Product']['id']?>">
            <input type="image" src="<?=$this->webroot?>images/dashbord/icn_categories.png" 
                title="View Details">
            </a></td>             
                  </tr>
               <?php }
              

                } ?>
             
          </tbody>

          </table>
          <div class="pagination_section">
               <div class="pagination-holder clearfix">
                <div id="light-pagination" class="pagination">

           <?php     
             echo $this->Paginator->first('< First');
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
              echo $this->Paginator->first('Last >');
            ?>
                </div>
              </div>
              <div class="clear" ></div>
          </div>
       </div>
      </div>
<?php } ?>
     <div class="clear" style="height:50px;"></div>
