<?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Banner <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<article class="module width_full">
    <header><h3 class="tabs_involved">Crawl List</h3>
    <a href="javascript:void(0);" onclick="backupAction('<?=$this->webroot?>admin/database_mysql_dump','Backup','Taking Backup of your Database Will take several time.','<?=$this->webroot?>images/admin/backup-blue.png','Are you want to Take Backup?')"
      class="heading_link top_backup_button">Add Merchant website</a>
    </header>

     <div class="module_content listing_containt">
       <div id="stylized" class="myform search" style="width:100%">
        <!-- <table style="width:30%;float:left">
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
        </table> -->
 <form method="get" action="<?=$this->webroot?>admin/crawl"> 
        <table style="width:50%;float:right">
          <tr>
           <?php /*?> <td width="2%">
        <input type="text" name="text_search" 
        value="<?=(isset($this->request['url']['text_search']) and ($this->request['url']['text_search']!=""))?$this->request['url']['text_search']:''?>" placeholder="Search Here"> 
           </td><?php */ ?>
             <td width="1%">
               <input type="text" placeholder="From Date" class="date_picker" name="from_date" id="from_date" autocomplete="off" value="<?php if(isset($this->request['url']['from_date'])){echo $this->request['url']['from_date'];}?>" style="width: 100px !important;" />
            </td>
            <td width="1%">
                <input type="text" placeholder="To Date" name="to_date" id="to_date" autocomplete="off" class="date_picker" value="<?php if(isset($this->request['url']['to_date'])){echo $this->request['url']['to_date'];}?>" style="width: 100px !important;"  />
            </td>
          
            <td width="12%">
        <input type="submit" class="search_button" name="search" value="Search" placeholder="Search by here."> 
           </td>
            <td width="1%">
               <a class="reset_button" href="<?=$this->webroot?>admin/backuprestor" class="reset">Reset</a> 
           </td>
         </tr>
      </table>
  </form> 
      </div>
      <div id="tab1" class="tab_content">
      <table class="tablesorter ordered" id="" style="font-size: 14px;" cellspacing="0"> 
      <thead> 
        <tr> 
            <th width="20px"><input class="check_all" type="checkbox"></th> 
            <th><?php echo $this->Paginator->sort('merchant_url', 'webistes'); ?></th> 
           
            <th align="center"><?php echo $this->Paginator->sort('last_modified', 'Updated'); ?></th> 
            <th align="center"><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
            <th>Actions</th>
        </tr> 
      </thead> 
      <tbody> 
         <?php

          //print_r($crawl_data);
          if(count($crawl_data)<=0){ ?>
         <tr><td colspan="7"><span>
          No record found. <br>
          <a href="javascript:void(0);" onclick="backupAction('<?=$this->webroot?>admin/database_mysql_dump','Backup','Taking Backup of your Database Will take several time.','<?=$this->webroot?>images/admin/backup-blue.png','Are you want to Take Backup?')" class="backup_button">Add Merchant website</a>
        </span></td><tr>
         <?php } else {?>
         <?php foreach($crawl_data as $key=>$val) { ?>
         <tr> 
            <td>
          
           <input type="checkbox" data-id="<?=$val['Crawl_merchant_website']['id']?>" class="user_checked <?=$val['Crawl_merchant_website']['id']?>">
     
            </td> 
            <td><?=$val['Crawl_merchant_website']['merchant_url']?></td>             
            <td width="100"><?=$val['Crawl_merchant_website']['last_modified']?></td> 
            <td width="150"><?=$val['Crawl_merchant_website']['status']?></td> 
            <td width="100">
              
            <a  onclick="backupAction('<?=$this->webroot?>admin/crawl/init/<?=$val['Crawl_merchant_website']['id']?>','Crawl','Do you want to Crawl the data?','<?=$this->webroot?>images/admin/restor-gray.png','Do you want to Crawl the data?')"
              href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/admin/restor-gray.png" title="Crawl"></a></td> 
             
        </tr> 
        <?php } } ?>
       
      </tbody> 
       <tfoot>
        <tr>
          <td colspan="2"><input class="check_all" type="checkbox"><lable for="check_all">Select All</lable></td>
          
            <td colspan="3">
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

            echo $this->Paginator->last('Last >');
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
