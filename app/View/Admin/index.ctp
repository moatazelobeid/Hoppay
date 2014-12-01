<article class="module width_full">
      <header><h3>Status</h3></header>
      <div class="module_content">
         <article class="stats_overview s_line">
            <div class="overview_today s_line">
            <p class="overview_day s_line">Visitors</p>
            <div class="inner_s_lin">
            <p class="overview_count s_line"><?=$uniqueCount?></p><br>
            <p class="overview_type s_line">Unique</p>
           
            </div>
            <div class="inner_s_lin">
            <p class="overview_count s_line"><?=$prodCountUser?></p><br>
            <p class="overview_type s_line">Products Visited</p>
            
            </div>
            
          
          </div>
         </article>

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
          <a href="<?=$this->webroot?>admin/products/report" class="view_reports_but">View Reports</a>
        </article>
        
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
           <a href="<?=$this->webroot?>admin/merchant/report" class="view_reports_but">View Reports</a>
        </article>
        <div class="clear"></div>
      </div>
    </article><!-- end of stats article -->
    
   <?php /* ?> <article class="module width_3_quarter">
    <header><h3 class="tabs_involved">Content Manager</h3>
    <ul class="tabs">
        <li><a href="#tab1">Posts</a></li>
        <li><a href="#tab2">Comments</a></li>
    </ul>
    </header>

    <div class="tab_container">
      <div id="tab1" class="tab_content">
      <table class="tablesorter" cellspacing="0"> 
      <thead> 
        <tr> 
            <th></th> 
            <th>Entry Name</th> 
            <th>Category</th> 
            <th>Created On</th> 
            <th>Actions</th> 
        </tr> 
      </thead> 
      <tbody> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Lorem Ipsum Dolor Sit Amet</td> 
            <td>Articles</td> 
            <td>5th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Ipsum Lorem Dolor Sit Amet</td> 
            <td>Freebies</td> 
            <td>6th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr>
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Sit Amet Dolor Ipsum</td> 
            <td>Tutorials</td> 
            <td>10th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Dolor Lorem Amet</td> 
            <td>Articles</td> 
            <td>16th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr>
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Dolor Lorem Amet</td> 
            <td>Articles</td> 
            <td>16th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr>  
      </tbody> 
      </table>
      </div><!-- end of #tab1 -->
      
      <div id="tab2" class="tab_content">
      <table class="tablesorter" cellspacing="0"> 
      <thead> 
        <tr> 
            <th></th> 
            <th>Comment</th> 
            <th>Posted by</th> 
            <th>Posted On</th> 
            <th>Actions</th> 
        </tr> 
      </thead> 
      <tbody> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Lorem Ipsum Dolor Sit Amet</td> 
            <td>Mark Corrigan</td> 
            <td>5th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Ipsum Lorem Dolor Sit Amet</td> 
            <td>Jeremy Usbourne</td> 
            <td>6th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr>
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Sit Amet Dolor Ipsum</td> 
            <td>Super Hans</td> 
            <td>10th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Dolor Lorem Amet</td> 
            <td>Alan Johnson</td> 
            <td>16th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr> 
        <tr> 
            <td><input type="checkbox"></td> 
            <td>Dolor Lorem Amet</td> 
            <td>Dobby</td> 
            <td>16th April 2011</td> 
            <td><input type="image" src="<?=$this->webroot?>images/dashbord/icn_edit.png" title="Edit"><input type="image" src="<?=$this->webroot?>images/dashbord/icn_trash.png" title="Trash"></td> 
        </tr> 
      </tbody> 
      </table>

      </div><!-- end of #tab2 -->
      
    </div><!-- end of .tab_container -->
    
    </article><!-- end of content manager article -->
    
    <article class="module width_quarter">
      <header><h3>Messages</h3></header>
      <div class="message_list">
        <div class="module_content">
          <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>
          <p><strong>John Doe</strong></p></div>
          <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>
          <p><strong>John Doe</strong></p></div>
          <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>
          <p><strong>John Doe</strong></p></div>
          <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>
          <p><strong>John Doe</strong></p></div>
          <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>
          <p><strong>John Doe</strong></p></div>
        </div>
      </div>
      <footer>
        <form class="post_message">
          <input type="text" value="Message" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
          <input type="submit" class="btn_post_message" value=""/>
        </form>
      </footer>
    </article><!-- end of messages article --><?php */ ?> 
    
    <div class="clear"></div>
    
    <?php /* ?><article class="module width_full">
      <header><h3>Post New Article</h3></header>
        <div class="module_content">
            <fieldset>
              <label>Post Title</label>
              <input type="text">
            </fieldset>
            <fieldset>
              <label>Content</label>
              <textarea rows="12"></textarea>
            </fieldset>
            <fieldset style="width:48%; float:left; margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
              <label>Category</label>
              <select style="width:92%;">
                <option>Articles</option>
                <option>Tutorials</option>
                <option>Freebies</option>
              </select>
            </fieldset>
            <fieldset style="width:48%; float:left;"> <!-- to make two field float next to one another, adjust values accordingly -->
              <label>Tags</label>
              <input type="text" style="width:92%;">
            </fieldset><div class="clear"></div>
        </div>
      <footer>
        <div class="submit_link">
          <select>
            <option>Draft</option>
            <option>Published</option>
          </select>
          <input type="submit" value="Publish" class="alt_btn">
          <input type="submit" value="Reset">
        </div>
      </footer>
    </article><!-- end of post new article --> <?php */ ?>
    
    <?php /* ?><h4 class="alert_warning">A Warning Alert</h4>
    
    <h4 class="alert_error">An Error Message</h4>
    
    <h4 class="alert_success">A Success Message</h4>
    
    <article class="module width_full">
      <header><h3>Basic Styles</h3></header>
        <div class="module_content">
          <h1>Header 1</h1>
          <h2>Header 2</h2>
          <h3>Header 3</h3>
          <h4>Header 4</h4>
          <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras mattis consectetur purus sit amet fermentum. Maecenas faucibus mollis interdum. Maecenas faucibus mollis interdum. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>

<p>Donec id elit non mi porta <a href="#">link text</a> gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla. Cras mattis consectetur purus sit amet fermentum. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p>

          <ul>
            <li>Donec ullamcorper nulla non metus auctor fringilla. </li>
            <li>Cras mattis consectetur purus sit amet fermentum.</li>
            <li>Donec ullamcorper nulla non metus auctor fringilla. </li>
            <li>Cras mattis consectetur purus sit amet fermentum.</li>
          </ul>
        </div>
    </article><!-- end of styles article -->
    <div class="spacer"></div><?php */ ?>
 

