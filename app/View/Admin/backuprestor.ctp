<?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
<?php if(isset($this->request['url']['msg']) and $this->request['url']['msg']!="") {?>
   <h4 class="alert_success">Banner <?=$this->request['url']['msg']?> successfully</h4>
<?php } ?>
<article class="module width_full">
    <header><h3 class="tabs_involved">Backup List</h3>
    <a href="javascript:void(0);" onclick="backupAction('<?=$this->webroot?>admin/database_mysql_dump','Backup','Taking Backup of your Database Will take several time.','<?=$this->webroot?>images/admin/backup-blue.png','Are you want to Take Backup?')"
      class="heading_link top_backup_button">Take Backup</a>
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
 <form method="get" action="<?=$this->webroot?>admin/backuprestor"> 
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
            <th><?php echo $this->Paginator->sort('file_name', 'Name'); ?></th> 
           
            <th align="center"><?php echo $this->Paginator->sort('file_size', 'File Size'); ?></th> 
            <th align="center"><?php echo $this->Paginator->sort('date', 'Date'); ?></th>
            <th>Actions</th>
        </tr> 
      </thead> 
      <tbody> 
         <?php if(count($backup_list)<=0){ ?>
         <tr><td colspan="7"><center>
          No record found. <br>
          <a href="javascript:void(0);" onclick="backupAction('<?=$this->webroot?>admin/database_mysql_dump','Backup','Taking Backup of your Database Will take several time.','<?=$this->webroot?>images/admin/backup-blue.png','Are you want to Take Backup?')" class="backup_button">Take Backup</a>
        </center></td><tr>
         <?php } else {?>
         <?php foreach($backup_list as $key=>$val) { ?>
         <tr> 
            <td>
          
           <input type="checkbox" data-id="<?=$val['Backup_restor']['id']?>" class="user_checked <?=$val['Backup_restor']['id']?>">
     
            </td> 
            <td><?=$val['Backup_restor']['file_name']?></td>             
            <td width="100"><?=$val['Backup_restor']['file_size']?> bytes</td> 
            <td width="150"><?=$val['Backup_restor']['date']?></td> 
            <td width="100">

            <a onclick="backupAction('<?=$this->webroot?>admin/downloadDbBackups/<?=$val['Backup_restor']['id']?>','Download','','<?=$this->webroot?>images/admin/download.png','Are you want to Download your db?');"
              href="javascript:void(0)" ><input type="image" src="<?=$this->webroot?>images/admin/download.png" title="Download"></a>               
            <a  onclick="backupAction('<?=$this->webroot?>admin/restoreDb/<?=$val['Backup_restor']['id']?>','Restore','It Overwrite all you Existing data.','<?=$this->webroot?>images/admin/restor-gray.png','Are you want to restore your db?')"
              href="javascript:void(0)">   <input type="image" src="<?=$this->webroot?>images/admin/restor-gray.png" title="Restore"></a></td> 
             
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
