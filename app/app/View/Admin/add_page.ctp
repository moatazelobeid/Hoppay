
   <?php $data=isset($page_data)?$page_data:""; 
       //print_r($lang);
       @extract($data);
       @extract($data['Page']);
       $lang_id=isset($_GET['lang_id'])?$_GET['lang_id']:1;
       if(isset($Page_lang))
       {
         //print_r($Page_lang);
        foreach($Page_lang as $val){
         // echo $val['lang_id'];
          if($val['lang_id']==$lang_id)
          {
             //print_r($val);
            $Page_lang=$val;
            break;
          }
          else
          {
            $Page_lang="";
          }
        }
      }
     // print_r($lang_id);
    ?>
    <script>
    var i=1;
      function attr_page_add_more(cthis){
        var template = $('#admin_add_attr').html();
        var data={'count':i++};
        var html = Mustache.to_html(template,data);
        $('.attr_inner_content').append(html);
      }
      function close_attr_fildes_in_admin_page_manager(cthis){
        $(cthis).parents('.attr_inner_inner_content').remove();
      }

    </script>
      <script id="admin_add_attr" type="text/template">
                     <div class="attr_inner_inner_content">
                        <label class="attr_lable">Enter Action Name</label>
                        <input type="text" name="attr[{{count}}][slug]">
                        <label class="attr_lable">Enter title</label>
                        <input type="text" name="attr[{{count}}][key]">
                        
                        <label class="attr_lable">Enter Subtitle</label>
                        <input type="text" name="attr[{{count}}][subtitle]">   
                        <label class="attr_lable">Enter Descriptions</label>
                        <textarea name="attr[{{count}}][values]"><?=isset($pg_keyword)?$pg_keyword:""?></textarea>
                        <label class="attr_lable">Choose Images</label>
                        <input type="file" name="attr[{{count}}][img]">
                        <a class="delete_each" href="javascript:void(0);" onclick="close_attr_fildes_in_admin_page_manager(this);">&times;Delete</a>
                        <hr />
                      </div>
                    </div>
        </script>
        <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
    <?=$this->Session->flash('bad')?> 
        <?=$this->Session->flash('msg')?>
      
 <article class="module width_full">
      <header><h3><?=$admin_button?> Page</h3>
      <a href="<?=$this->webroot?>admin/page_manager" class="heading_link">View Lists</a>
      </header>
     
        <div class="module_content">       
          <div id="stylized" class="myform" style="width:828px">
             <?php if(isset($id)){ ?>
        <form>
           <table>
                  <tr>
                    <td style="width: 188px;">
                   <label>Choose Language
                     <span class="small">Select Language</span>
                   </label>
                    </td>
                    <td>
                   

                      <select name="lang_id" onchange="this.form.submit();" style="width: 185px;">
                        <?php 
                        foreach($lang as $val){ ?>
                        <option value="<?=$val['Language']['id']?>" <?php echo $this->Template->Select($val['Language']['id'],empty($lang_id)?1:$lang_id);?>><?=$val['Language']['lang_name']?> (<?=$val['Language']['lang_short_name']?>)</option>
                       <?php } 
                        ?>
                      </select>
                      </td>
                  </tr>
                </table>
              </form>
         <?php } 
         else
           { ?>
            <form>
                <table>
                    <tr>
                      <td style="width: 188px;">
                     <label>Choose Language
                       <span class="small">Select Language</span>
                     </label>
                      </td>
                      <td>
             <select name="lang_id" disabled="disabled" onchange="this.form.submit();" style="width: 185px;">
                <option value="1" readonly="readonly">English</option>
             </select>
              </td>
                    </tr>
                  </table>
                </form>
         <?php  }
            ?>
              <form method="post" action="" class="validate" enctype="multipart/form-data"> 
                <input type="hidden" name="lang_id" value="<?=$lang_id?>"/>
                 <input type="hidden" name="page_lang_id" value="<?=@$Page_lang['id']?>"/>
                <table>
                  <tr>
                    <td>
                   <label>Title
                     <span class="small">Add Page Title.</span>
                   </label>
                    </td>
                    <td>
                    <input type="text" required name="pg_title" placeholder="Enter Page Title." value="<?=isset($Page_lang['pg_title'])?$Page_lang['pg_title']:""?>">
                    </td>
                 </tr>
                 
                  <tr>
                    <td>
                    <label>Page Content Editor  
                     <span class="small">(Use it carefully)</span>
                     </label>
                     </td>
                     <td>
                     <style>
                      iframe{
                        border-bottom: 1px solid #000 !important;
                        border-radius:5px;
                        margin-bottom: 5px !important;
                        margin-top: 5px !important;
                      }
                    </style>
                    <?php
                    echo $this->Fck->fckeditor(array('pg_detail'), $this->html->base, isset($Page_lang['pg_descriptions'])?htmlspecialchars_decode($Page_lang['pg_descriptions']):""); 
                   
                    ?>
                    </td>
                  </tr>
                    <tr>
                      <td>
                    <label>Choose Template Page
                     <span class="small">Select Template Page.</span>
                    </label>
                    </td>
                    <td>
                      <?php  $tempalate_name=$this->Template->getTemplateFilename();                         
                      ?>
                       <select name="page_template" requred>
                        <option value="">-- Choose Template --</option>
                         <?php foreach($tempalate_name as $val){ ?>
                      <option value="<?=$val['Tfile']?>" <?php if(isset($page_template) && ($page_template==$val['Tfile'])){ echo "selected='selected'";} ?>><?=$val['Tname']?></option>
                      <?php } ?>
                      </select>
                    </td>
                    </tr>
                    
                       <?php if(isset($pg_img) and $pg_img!=""){ ?>
                       <tr>
                        <td>
                        <label>Uploaded Image
                         <span class="small">current image</span>
                        </label>  
                        </td>
                        <td>
                        <img src="<?=isset($pg_img)?$this->webroot.$pg_img:""?>" style="height:100px" alt="hoppay"/>
                        </td>
                        </tr>
                    <?php } ?>

                    
               <tr>
                    <td>
                      <label>Image
                     <span class="small">Upload Image For this page.</span>
                     </label>
                    </td>
                    <td>
                      <input type="file" name="pg_img" placeholder="Choose Image For the Page">
                    </td>
                  </tr>
                  <tr>
                  <td>
                    <label>Add Attrs
                     <span class="small">Enter keys</span>
                   </label>
                  </td>
                   <td>
                  <div class="attr_main_content">
                    <div class="attr_inner_content">
                      <?php 
                     // echo $Page_lang['page_attrs'];
                      if($Page_lang['page_attrs']==""){?>
                      <div class="attr_inner_inner_content">
                        <label class="attr_lable">Enter Action Name</label>
                        <input type="text" name="attr[0][slug]">
                        <label class="attr_lable">Enter title</label>
                        <input type="text" name="attr[0][key]">    
                        <label class="attr_lable">Enter Subtitle</label>
                        <input type="text" name="attr[0][subtitle]">                     
                        <label class="attr_lable">Enter Descriptions</label>
                        <textarea name="attr[0][values]"></textarea>
                        <label class="attr_lable">Choose Images</label>
                        <input type="file" name="attr[0][img]">

                       <!--  <a class="delete_each" href="javascript:void(0);" onclick="close_attr_fildes_in_admin_page_manager(this);">&times;Delete</a> -->
                        <hr />
                      </div>
                      <?php } else {
                        //echo htmlspecialchars_decode(stripslashes($Page_lang['page_attrs']));
                         $page_attrs=json_decode(htmlspecialchars_decode($Page_lang['page_attrs']));
                        // print_r($page_attrs);
                        ?>
                        <script> 
                        i=<?=count($page_attrs)?>
                        </script>
                        <?php 
                       
                        foreach ($page_attrs as $key => $value) {
                        
                       ?>

                         <div class="attr_inner_inner_content">
                          <label class="attr_lable">Enter Action Name</label>
                            <input type="text"  readonly name="attr[<?=$key?>][slug]" value="<?=@$value->slug?>">
                            <label class="attr_lable">Enter title</label>
                            <input type="text" name="attr[<?=$key?>][key]" value="<?=@$value->key?>">
                            <label class="attr_lable">Enter Subtitle</label>
                            <input type="text" name="attr[<?=$key?>][subtitle]" value="<?=@$value->subtitle?>">  
                            <label class="attr_lable">Enter Descriptions</label>
                            <textarea name="attr[<?=$key?>][values]"><?=$value->values?></textarea>
                            <?php if($value->img!=""){?>
                            <span><img src="<?=$this->webroot?><?=@$value->img?>" style="max-height:100px;">
                            <input type="hidden" name="attr[<?=$key?>][img]" value="<?=@$value->img?>"></span>
                            <?php } ?>
                            <label class="attr_lable">Choose Images</label>
                            <input type="file" name="attr[<?=$key?>][img]">
                            
                            <a class="delete_each" href="javascript:void(0);" onclick="close_attr_fildes_in_admin_page_manager(this);">&times;Delete</a>
                            <hr />
                         </div>
                      <?php   
                        }
                      } ?>
                    </div>
                    <div class="attr_add_more">
                      <a href="javascript:void(0);" onclick="attr_page_add_more(this)">Add new</a>
                    </div>
                  </div>
                  </td>
                  </tr>
                     <tr>
                  <td>
                    <label>Meta Keywords:
                     <span class="small">Enter Key words. Ex. (abc, xxx, yyy)</span>
                   </label>
                   </td>
                   <td>
                    <textarea name="meta_keyword"><?=isset($Page_lang['meta_keyword'])?htmlspecialchars_decode($Page_lang['meta_keyword']):""?></textarea>
                    
                  </td>
                  </tr>
                  <tr>
                    <td>
                    <label>Meta Descriptions
                     <span class="small">Add Meta Description</span>
                   </label>
                   </td>
                    <td>
                     <textarea name="meta_description"><?=isset($Page_lang['meta_description'])?htmlspecialchars_decode($Page_lang['meta_description']):""?></textarea>
                  </td>
                  </tr>
                    <tr>
                      <td>
                    <label>status
                     <span class="small">Choose Status</span>
                     </label>
                     </td>
                     <td>
                    <select name="status" requred>
                      <option value="1" <?php if(isset($status) && $status==1){ echo "selected='selected'";} ?>>Active</option>
                      <option value="0" <?php if(isset($status) && $status==0){ echo "selected='selected'";} ?>>Inactive</option>
                    </select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td></td> 
                    <td>
                       <button type="submit" name=""><?=$admin_button?></button>
                    <td>
                </tr>
         
               </table>
                
         
          </form>
            
           <div class="clear"></div>
        </div>
      
       
     </div>
    </article><!-- end of post new article -->

